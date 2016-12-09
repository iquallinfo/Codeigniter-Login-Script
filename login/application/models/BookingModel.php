<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class BookingModel extends CI_Model{
        private $_controller_url 		= 'qr_code_generate/';
	private $_method_url 			= '';
	private $_form_attributes 		= array();

	public  $data 					= array();
        
        var $userid;
	function __construct() {
            parent::__construct();
            $this->userid = $this->session->userdata("id");
	}

        /* Book Now */
        
        public function getVehicles($data = array()){
            $this->db->select("*");
            $this->db->from("routes");
            $query = $this->db->get();
            $result = $query->result_array();
            $jdates = $this->input->post("jdate");
            $routes = array();
            $vehicle_number = array();
            $route_id = array();
            foreach ($result as $res){
				$route_days = json_decode($res["days"]);
                $isdays = array_intersect($route_days,$data["days"]);
                if(count($isdays) > 0){
					$substations = json_decode($res["sub_station"]);
					if(($data["start_from"] == $res["start_from"] || $data["start_from"] == $res["end_to"] || (in_array($data["start_from"],$substations))) && ($data["end_to"] == $res["end_to"] || $data["end_to"] == $res["start_from"] || (in_array($data["end_to"],$substations)))) {
						$time = explode(",",$data['time']);
						if(count($time) == 2){         
							if(( strtotime($time[0]) >= strtotime($res["sd_start_time"]) && (strtotime($time[0]) <= strtotime($res["sd_end_time"])) ) && ( strtotime($time[1]) >= strtotime($res["ed_start_time"]) && (strtotime($time[1]) <= strtotime($res["ed_end_time"])) ) ) {
								$routes[] = $res;
								$route_id[] = $res["id"];
								$vehicle_number[] = $res["vehicle_number"];
							}
						}
						else{
							if(( strtotime($time[0]) >= strtotime($res["sd_start_time"]) && (strtotime($time[0]) <= strtotime($res["sd_end_time"])) ) || ( strtotime($time[0]) >= strtotime($res["ed_start_time"]) && (strtotime($time[0]) <= strtotime($res["ed_end_time"])) ) ) {
								$routes[] = $res;
								$route_id[] = $res["id"];
								$vehicle_number[] = $res["vehicle_number"];
							}
						}
					}
				}
            }
            if(count($vehicle_number) > 0){
            $this->db->select("vehicles.*,routes.days,routes.start_from,routes.end_to,routes.id as rid,routes.vehicle_number as rt_vehicle_number");
            $this->db->from("vehicles");
            $this->db->join('routes', 'routes.vehicle_number = vehicles.vehicle_number');
            $this->db->where_in("vehicles.vehicle_number",$vehicle_number);
            $this->db->where_in("routes.id",$route_id);            
            $query = $this->db->get();
            $vehicles = $query->result_array();
            $html = "";
            foreach($vehicles as $vh){
				$route_days = json_decode($vh["days"]);
                $intersectdays = array_intersect($route_days,$data["days"]);
                $seats = $this->checkSeats($vh["id"],$jdates);
                $html .="<tr><td>";
                $html .="<img src='".base_url()."assets/images/vehicle/".$vh['image']."' width='50' height='50' /> </td>";
                $html .="<td class='center'>".$vh["vehicle_number"]."</td>";
                $html .="<td class='center'>".$vh["start_from"]." - ". $vh["end_to"]."</td>";
                $html .="<td class='center'>".$vh["seating_capacity"]."</td>";
                $html .="<td class='center seatavailable'>";
				if(count($intersectdays) != count($data['days'])){
					$notripday = array_diff($data['days'], $route_days);
					$dy = implode(",",$notripday);
					$html .="<div class='notripday sv_alert'><div class='alert alert-red'>Trip Vehicle is not available for ".$dy.". Below are other suggested trip day</div></div>";
				}
                $html .="<div class='seattab'>";
                $html .="<span class='spdate'><b>Date</b></span> <span class='spseat'><b>Seats</b></span>";
                $html .="</div>";
                $s = 1;
				
                foreach($seats as $seat){
                     $as = (int)$vh["seating_capacity"] - (int)$seat['seats'];
                     $as = (int)$vh["seating_capacity"] - (int)$seat['seats'];
                    
                    if($as <= 0){
                        $as = 0;
                        $s = 0;
                    }
					$tripdate = $seat['date']; 
					$timestamp = strtotime($tripdate);
					$trip_day = date('l', $timestamp);
					if(count($intersectdays) == count($data['days'])){
						if(in_array($trip_day,$data["days"])){
							$html .="<div class='seattab'>";
							$html .="<span class='spdate'>".$seat['date']."</span> <span class='spseat'>".$as."</span>";
							$html .="</div>";
						}
					}else{
						if(in_array($trip_day,$route_days)){
							$html .="<div class='seattab'>";
							$html .="<span class='spdate'>".$seat['date']."</span> <span class='spseat'>".$as."</span>";
							$html .="</div>";
						}
					}
                }
                $html .="</td>";
                 if($s == 0){
                $html .="<td class='booknowbtb'><button type='button' class='btn btn-default next-tab btn-flat btn-red' onclick='alert(&apos;No Seats&apos;)'>No Seats</button></td>";
                }
				else if(count($intersectdays) != count($data['days'])){
					$html .="<td class='booknowbtb'><button type='button' class='btn btn-default next-tab btn-flat btn-red' onclick='alert(&apos;No Available for selected days &apos;)'>NA</button></td>";
				}
                else{
                    $html .="<td class='booknowbtb'><button type='button' class='btn btn-default next-tab btn-flat btn-red' onclick='book_suggested_vehicle(&apos;".$vh['id']."&apos;,&apos;".$vh['rid']."&apos;)'>Book Now</button></td>";
                }
               
                $html .="</tr>";    
            }
               // return $html;
			   $return["response"] ="success";
			   $return["html"] =$html;
               return $return;
            }
            else{
				 $html ="No Vehciles";
				$return["response"] ="novehicles";
				$return["html"] =$html;
                return $return;
            }
            
        }
        
        
	public function suggestVehicles($data = array()){
            $jdates = $this->input->post("jdate");
            
            $this->db->select("*");
            $this->db->from("routes");
			
           
            $query = $this->db->get();
            $result = $query->result_array();
            $routes = array();
            $vehicle_number = array();
            $route_id = array();
			
            foreach ($result as $res){
				$route_days = json_decode($res["days"]);
                $isdays = array_intersect($route_days,$data["days"]);
                if(count($isdays) > 0){
					$substations = json_decode($res["sub_station"]);
					if(($data["start_from"] == $res["start_from"] || $data["start_from"] == $res["end_to"] || (in_array($data["start_from"],$substations))) && ($data["end_to"] == $res["end_to"] || $data["end_to"] == $res["start_from"] || (in_array($data["end_to"],$substations)))) {
						$routes[] = $res;
						$route_id[] = $res["id"];
						$vehicle_number[] = $res["vehicle_number"];
					}
				}
            }
			if(count($vehicle_number) > 0){
				
            $this->db->select("vehicles.*,routes.days,routes.start_from,routes.end_to,routes.sub_station,routes.sd_start_time,sd_end_time,ed_start_time,ed_end_time,routes.id as rid,routes.vehicle_number as rt_vehicle_number");
            $this->db->from("vehicles");
            $this->db->join('routes', 'routes.vehicle_number = vehicles.vehicle_number');
            $this->db->where_in("vehicles.vehicle_number",$vehicle_number);
            $this->db->where_in("routes.id",$route_id);            
            $query = $this->db->get();
            $vehicles = $query->result_array();
            $html = "";
			
            foreach($vehicles as $vh){
				$route_days = json_decode($vh["days"]);
                $intersectdays = array_intersect($route_days,$data["days"]);
				
                $seats = $this->checkSeats($vh["id"],$jdates);
				$substation = json_decode($vh['sub_station']);		
                // $html .="<tr><td>";
                // $html .="<img src='".base_url()."assets/images/vehicle/".$vh['image']."' width='50' height='50' /> </td>";
                // $html .="<td class='center'>".$vh["vehicle_number"]."</td>";
                // $html .="<td class='center'>".$vh["start_from"]." - ". $vh["end_to"]."</td>";
                // $html .="<td class='center'>";
                // foreach($substation  as $ss){
                    // $html .="<div>$ss</div>";
                // }
                // $html .="</td>";
                // $html .="<td class='center'>".$vh["seating_capacity"]."</td>";
                // $html .="<td class='center seatavailable'>";
                // $html .="<div class='seattab'>";
                // $html .="<span class='spdate'><b>Date</b></span> <span class='spseat'><b>Seats</b></span>";
                // $html .="</div>";
				
				$html .="<tr><td>";
                $html .="<img src='".base_url()."assets/images/vehicle/".$vh['image']."' width='50' height='50' /> </td>";
                $html .="<td class='center'>".$vh["vehicle_number"]."</td>";
                $html .="<td class='center'>".$vh["start_from"]." - ". $vh["end_to"]."</td>";
                $html .="<td class='center'>";
                foreach($substation  as $ss){
                    $html .="<div>$ss</div>";
                }
                $html .="</td>";
                // $html .="<td class='center'>".$vh["seating_capacity"]."</td>";
                $html .="<td class='center seatavailable rinfocols'>";
                // $html .="<div class='seattab'>";
                // $html .="<span class='spdate'><b>Date</b></span> <span class='spseat'><b>Seats</b></span>";
                // $html .="</div>";
                $s = 1;
				if(count($intersectdays) != count($data['days'])){
					$notripday = array_diff($data['days'], $route_days);
							$dy = implode(",",$notripday);
					$html .="<div class='notripday sv_alert'><div class='alert alert-red'>Trip Vehicle is not available for ".$dy.". Below are other suggested trip day</div></div>";
				}
                foreach($seats as $seat){
                    $as = (int)$vh["seating_capacity"] - (int)$seat['seats'];
                    
                    if($as <= 0){
                        $as = 0;
                        $s = 0;
                    }
					$tripdate = $seat['date']; 
					$timestamp = strtotime($tripdate);
					$trip_day = date('l', $timestamp);
					if(count($intersectdays) == count($data['days'])){
						
						if(in_array($trip_day,$data["days"])){
							$html .="<div class='tsd'><div class='seattab'>";
							$html .="<div class='dinfo'><b>Date:</b> <span class='spdate'>".$seat['date']."  <b>(".$trip_day.")</b></span></div>";
							$html .="<div class='rinfo'><b>Trip Start Time</b></span> - "."<span class='spdate'>".$vh["start_from"]."</span>"."<span class='spdate'>(".$vh["sd_start_time"].") To </span><span class='spdate'> ".$vh["end_to"]." </span>"."<span class='spdate'>(".$vh["sd_end_time"].")</span></div>";
							$html .="<div class='sa'><b>Seats Available - </b>".$as."</div>";
							$html .="</div>";
							
							$html .="<div class='seattab'>";
							$html .="<div class='rinfo'><b>Trip Return Time</b></span> - "."<span class='spdate'>".$vh["end_to"]." </span>"."<span class='spdate'>(".$vh["ed_start_time"].") To </span><span class='spdate'> ".$vh["start_from"]."  </span>"."<span class='spdate'>(".$vh["ed_end_time"].")</span></div>";
							$html .="<div class='sa'><b>Seats Available - </b>".$as."</div>";
							$html .="</div></div>";
						}
					}
					else{
						//echo "no\n";
						if(in_array($trip_day,$route_days)){
							$html .="<div class='tsd'><div class='seattab'>";
							$html .="<div class='dinfo'><b>Date:</b> <span class='spdate'>".$seat['date']."  <b>(".$trip_day.")</b></span></div>";
							$html .="<div class='rinfo'><b>Trip Start Time</b></span> - "."<span class='spdate'>".$vh["start_from"]."</span>"."<span class='spdate'>(".$vh["sd_start_time"].") To </span><span class='spdate'> ".$vh["end_to"]."</span>"."<span class='spdate'>(".$vh["sd_end_time"].")</span></div>";
							$html .="<div class='sa'><b>Seats Available - </b>".$as."</div>";
							$html .="</div>";
							
							$html .="<div class='seattab'>";
							$html .="<div class='rinfo'><b>Trip Return Time</b></span> - "."<span class='spdate'>".$vh["end_to"]."</span>"."<span class='spdate'>(".$vh["ed_start_time"].") To </span><span class='spdate'> ".$vh["start_from"]."</span>"."<span class='spdate'>(".$vh["ed_end_time"].")</span></div>";
							$html .="<div class='sa'><b>Seats Available - </b>".$as."</div>";
							$html .="</div></div>";
						}
					}
                }
                $html .="</td>";
                // $html .="<td class='center'>".$vh["sd_start_time"]."-".$vh["sd_end_time"]."</td>";
                // $html .="<td class='center'>".$vh["ed_start_time"]."-".$vh["ed_end_time"]."</td>";
                if($s == 0){
                $html .="<td class='booknowbtb'><button type='button' class='btn btn-default next-tab btn-flat btn-red' onclick='alert(&apos;No Seats&apos;)'>No Seats</button></td>";
                }
				else if(count($intersectdays) != count($data['days'])){
					$html .="<td class='booknowbtb'><button type='button' class='btn btn-default next-tab btn-flat btn-red' onclick='alert(&apos;Not Available for selected days&apos;)'>NA</button></td>";
				}
                else{
                    $html .="<td class='booknowbtb'><button type='button' class='btn btn-default next-tab btn-flat btn-red' onclick='book_suggested_vehicle(&apos;".$vh['id']."&apos;,&apos;".$vh['rid']."&apos;)'>Book Now</button></td>";
                }
                $html .="</tr>";    
            }
                $data["html"] = $html;
                return $html;
            }
            else{
                $html ="No Vehicles";
                return $html;
            }
            
        }
		
        public function addBooking($data = array()){

            if($data["journeytype"] != ""){
                $passengerinfo = array();
                for($i=0;$i<count($data['psngr_name']);$i++){
                    $passengerinfo[]=array(
                        "name" =>$data['psngr_name'][$i],
                        "email" =>$data['psngr_email'][$i],
                        "phoneno" =>$data['psngr_phoneno'][$i],
                    );
                }
                $triptype="";
                $payment_status ="0";
                if($data["journeytype"] == "recurring_journey"){
                    $dt_from= $data["rj_datefrom"];
                    $dt_to= $data["rj_dateto"];
                    $journeyday= $data["journeyday"];
                    if($data["rj_trip_type"] == "return"){
                        $trip_info = array(
                            "rj_returnpickupst" => $data["rj_returnpickupst"],
                            "rj_returnpickupet" => $data["rj_returnpickupet"],
                         );
                    }
                    else{
                       $trip_info=array(
                           "rj_onewaytime"=>$data["rj_onewaytime"]
                       ); 
                    }
                    $getdays = $this->getnumberdays($dt_from,$dt_to,$journeyday);
                   
                    $triptype = $data["rj_trip_type"];
                    $tripdata["recurring_journey"] = array(
                        "date_from" => $dt_from, 
                        "date_to" => $dt_to,
                        "journeyday" => $journeyday,
                        "trip_info" => $trip_info,
                    );
                    $jdate=array(
                        "dt_from" =>$dt_from,
                        "dt_to" =>$dt_to,
                    );
                    
                    $jrdate[0]["datefrom"] =$dt_from;
                    $jrdate[1]["dateto"] =$dt_from;
                    
                }
                else if($data["journeytype"] == "one_time_journey"){
                    $getdays = 1; // as it is one time;
		    $dt_fromotj= $data["otj_datefrom"];
                    if($data["otj_trip_type"] == "return"){
                        $trip_info = array(
                            "otj_returnpickupst" => $data["otj_returnpickupst"],
                            "otj_returnpickupet" => $data["otj_returnpickupet"],
                         );
                    }
                    else{
                       $trip_info=array(
                           "otj_onewaytime"=>$data["otj_onewaytime"]
                       ); 
                    }
                    $triptype = $data["otj_trip_type"];
                    $tripdata["one_time_journey"] = array(
		     "date_from" => $dt_fromotj,
                     "trip_info" => $trip_info,
                    );  
                    $jdate=array(
                        "dt_from" =>$dt_fromotj,
                    );
                }
//                if(isset($journeyday)){
//                    $jdays = count($journeyday);
//                }
//                else{
//                    $jdays = 1;
//                }
                
                if($data["noofemp"] != ""){
                    $noofemp = $data["noofemp"];
                }
                else{
                    $noofemp = 1;
                }
                
                $route_distance = $data["route_distance"];
//                $price = $this->countpayment($route_distance,$data["journeytype"],$triptype,$journeyday,$jrdate);
//                echo $price;
//                exit;
                //$price = $price * count($passengerinfo);
                $price = $data["route_price"] * $noofemp;
                
                //$query = $this->db->get_where('price_slabs');
                //$points = $query->row_array();
                
               
                if($triptype =="return"){
                    $points_earned = ($getdays * $noofemp)*2;
//                    $points_earned = ($getdays * count($passengerinfo))*2;
                    //$eachdaypoints = $price/$points;
                    //$points_earned = ($eachdaypoints*$jdays);
                }
                else{
                    $points_earned = $getdays * count($noofemp);
//                    $points_earned = $getdays * count($passengerinfo);
                    //$eachdaypoints = $price/$points;
                    //$points_earned = $eachdaypoints*$jdays;
                }
                
                
                $status = 0;
                
                $qrcode_data = $this->qrcode();
                $qrcode = $qrcode_data["qrcode"];
                
                        
                $bookingdata = array(
                    "userid" =>$this->userid,		
                    "pickup_from"  =>$data["pickup_from"],
                    "pickup_lat_lng"  =>$data["pickup_lat_lng"],
                    "drop_to"  =>$data["drop_to"],
                    "dropto_lat_lng"  =>$data["dropto_lat_lng"],
                    "journey_type"  =>$data["journeytype"],
                    "trip_type"  =>$data["rj_trip_type"],
                    "trip_info"  =>  json_encode($tripdata),
                    "return_journey"  =>(isset($data["return_journey"]))?"1":"0",
                    "route_id" =>$data["route_selected"],
                    "vehicle_booked"  =>$data["vehicle_selected"],
                    "passengers_info"  =>json_encode($passengerinfo),
                    "no_of_passengers"  =>$noofemp,
                    "total_amount" => $price,
                    "points_earned"=>$points_earned,
                    "qrcode"=>$qrcode,
                    "payment_mode"  =>$data["paymenttype"],
                    "cheque_or_transation_no"  =>$data["transaction_no"],
                    "payment_status"  =>$payment_status,
                );
                
            $this->db->insert('booking',$bookingdata);
            $bookingid = $this->db->insert_id();
            
			
			
            $booking_providers_points = array(
                "booker_id" =>$this->userid,
                "bookingid" => $bookingid,
                "route_id" =>$data["route_selected"],
                "total_trip_points" => $points_earned,
                "consumed_points" => "0",  
                "remain_points" => $points_earned, 
            );
            $this->db->insert('booking_providers_points',$booking_providers_points);
            /* seat management */
            if(count($jdate) == 2){
               $daterange = $this->createDateRange($jdate["dt_from"],$jdate["dt_to"]);
               foreach($daterange as $dr){
				   $tripdate = $dr; 
				   $timestamp = strtotime($tripdate);
				   $trip_day = date('l', $timestamp);
				   if(in_array($trip_day,$journeyday)){
					   $seatdata = array(
							"booking_id" =>$bookingid,
							"vehicle_id" =>$data["vehicle_selected"],
							"date" => $dr,
							"seat_booked"=>$noofemp,
						);
						$this->db->insert('seat_available',$seatdata);
					 }
               }
            }
            else{
                $seatdata = array(
                    "booking_id" =>$bookingid,
                    "vehicle_id" =>$data["vehicle_selected"],
                    "date" => $jdate["dt_from"],
                    "seat_booked"=>$noofemp,
                );
                $this->db->insert('seat_available',$seatdata);
            }
            
                $invoicedata = array(
                    "userid" =>$this->userid,
                    "bookingid" => $bookingid,
                    "amount" => $price,
                    "status" => $status,
                );
                $this->db->insert('invoice',$invoicedata);
            
			$config=array(
			'charset'=>'utf-8',
			'wordwrap'=> TRUE,
			'mailtype' => 'html',
			// 'protocol' => 'smtp',
			// 'smtp_host'=>'ssl://smtp.googlemail.com',
			// 'smtp_port'=>'465',
			// 'smtp_user'=>'demo1user123@gmail.com',
			// 'smtp_pass'=>'demo1admin',
			// 'newline'=>'\r\n'
			);
			

			$this->db->select("*");
			$this->db->from("users");
			$this->db->where("id",$this->userid);
			$q = $this->db->get();
			$d = $q->row_array();
			
			$this->db->select("routes.*,users.email");
			$this->db->from("routes");
			$this->db->join("users","users.id = routes.userid");
			$this->db->where("routes.id",$data["route_selected"]);
			$fq = $this->db->get();
			$fd = $fq->row_array();
			
			
			$passenger_email = $passengerinfo[0]["email"];
			$bookeremail = $d['email'];
			$fleetemail = $fd['email'];
			$to ="iq.web2@gmail.com";
                        
			$maildata = $bookingdata;
			
			$maildata["qrcodeimg"] ="<img src='".base_url()."tmp/qr_codes/".$maildata["qrcode"].".png' width='150' height='150' />";
                        $maildata["bookingid"] = $bookingid;
			/* mail to admin */
			$this->email->initialize($config);
			$message = $this->load->view("email/booking_added",$maildata, true);
			$this->email->from('info@wlc.com', 'WLC Facilitate Services');
			$this->email->to($to);	
			
			$this->email->subject('Booking Added');
			$this->email->message($message);
			
			$this->email->send();
			
			/* mail to passenger */
			$this->email->initialize($config);
			$message = $this->load->view("email/booking_added",$maildata, true);
			$this->email->from('info@wlc.com', 'WLC Facilitate Services');
			$this->email->to($passenger_email);	
			
			$this->email->subject('Booking Added');
			$this->email->message($message);
			
			$this->email->send();
          
		  /* mail to booker */
			$this->email->initialize($config);
			$message = $this->load->view("email/booking_added",$bookingdata, true);
			$this->email->from('info@wlc.com', 'WLC Facilitate Services');
			$this->email->to($bookeremail);	
			
			$this->email->subject('Booking Added');
			$this->email->message($message);
			
			$this->email->send();
			
			 /* mail to Fleet */
			$this->email->initialize($config);
			$message = $this->load->view("email/booking_added",$maildata, true);
			$this->email->from('info@wlc.com', 'WLC Facilitate Services');
			$this->email->to($fleetemail);	
			
			$this->email->subject('Booking Added');
			$this->email->message($message);
			
			$this->email->send();
			
			
             $response = array(
                 "bookingid" =>$bookingid,
                 "points" =>$points_earned,
                 "qrcode"=>$qrcode,
             );
			 
             return $response; 
            
            }
			 
             return false; 
           
        }
		
        public function getnumberdays($startDate,$endDate,$journeyday) {
//            $startDate="09/30/2016";
//            $endDate="10/15/2016";   
            $daycount = 0;
            foreach($journeyday as $jdays){
                $day_of_week = date('N', strtotime($jdays));
                
                for ($i = strtotime($startDate); $i <= strtotime($endDate); $i = strtotime('+1 day', $i)) {
                      if (date('N', $i) == $day_of_week) //Monday == 1
                       $daycount++;
                      //echo date('l Y-m-d', $i)."<br>"; //prints the date only if it's a Monday
                }
            }
            
            return $daycount;
            
        }
	
        public function getBookinghistory(){
            $this->db->select("booking.*,invoice.id as invid");
            $this->db->join("invoice","invoice.bookingid = booking.id");
            $this->db->order_by("booking.id","desc");
            $query = $this->db->get_where('booking',array('booking.userid'=>$this->userid));
            $result = $query->result_array();
            return $result;
        }
		  public function cheque_no($id,$chequede){
            $data = array(
                "cheque_or_transation_no"=>$chequede,
            );
            $this->db->where("id",$id);
            $this->db->update('booking',$data);
            return "true";
        }
        public function getbookings(){
            $query = $this->db->get_where('booking',array("userid"=>$this->userid));
            $result = $query->result_array();
            return $result;
        }
        public function countpayment($distance,$journeytype,$triptype,$journeyday,$jdate){
            $km = str_replace(" km","",$distance);
            $km = (float)$km;
            $query = $this->db->get_where('price_slabs');
            $result = $query->row_array();
            $slabs = json_decode($result["slabs"]);
            $price="";
            $lastprice="";
            foreach($slabs as $sb){
				$from_km = number_format($sb->kmfrom,2)."\n";
				$to_km = (float)$sb->kmto.".99";
				$to_km = number_format($to_km,2);
				
				
                if($km >= $sb->kmfrom && $km <= $to_km){
                    $price = $sb->price;
                    $flag = 1;
                    break;
                }
                else{
                    $flag = 0;
                    $lastprice = $sb->price;
                }
            }
            if($flag == 0){
                $price = $lastprice;
            }
           
			
            if($journeytype == "recurring_journey"){
                $start_date = $jdate[0]["datefrom"];
                $end_date = $jdate[1]["dateto"];
                $days = $this->getnumberdays($start_date,$end_date,$journeyday);
               
                if($triptype == "oneway"){
                    $price = $price*($days*$km);
                }
                else{
                    $price = ($price*($days*$km))*2;
                }
            }
            else{
                if($triptype == "oneway"){
                    $price = $price*1*$km;
                }
                else{
                    $price = ($price*1*$km)*2;
                }
            }
            return $price;
        }
        
        public function getInvoices(){
            $this->db->select("*");
            $this->db->from("invoice");
            $this->db->where("userid",$this->userid);
            $query = $this->db->get();
            $result = $query->result_array();
            return $result;
        }
        public function getBookingInfo($bookingid){
            $this->db->select("*");
            $this->db->from("booking");
            $this->db->where("userid",$this->userid);
            $this->db->where("id",$bookingid);
            $query = $this->db->get();
            $result = $query->row_array();
            return $result;
        }
        public function insertTransaction($data){
            $this->db->insert('booking_payment_info',$data);
            $paymentid = $this->db->insert_id();
            return $paymentid;
        }
        
       public function bookingupdate($data = array(),$bookingid){ 
           $this->db->where("id",$bookingid);
           $this->db->update("booking",$data);
       }
        
       public function getPointSummary(){
//            $this->db->select("*");
//            $this->db->from("price_slabs");
//            $query = $this->db->get();
//            $total_points = $query->row_array();
            
            $this->db->select("*");
            $this->db->from("booking_providers_points");
            $this->db->where("booker_id",$this->userid);
            $this->db->order_by("id","desc");
            $query = $this->db->get();
            $result = $query->result_array();
//            $data["total_points"] = $total_points["threshold_points"];
            $data["records"] = $result;
            
            return $data;
        }
        
        public function getInvoiceInfo($id){
            $this->db->select("invoice.*,invoice.id as inv_id,DATE_FORMAT(invoice.created_at, '%d-%m-%Y') AS invoice_date,booking.*,booking.id as bid,booking.userid as bk_userid,booking.no_of_passengers as no_of_passengers");
            $this->db->from("invoice");
            $this->db->join("booking","booking.id = invoice.bookingid","left");
            $this->db->where("invoice.id",$id);
            $query= $this->db->get();
            $result = $query->row_array();
            return $result;
        }
         public function qrcode(){
             
            $this->load->library('ci_qr_code');
            $this->config->load('qr_code');
            $qr_code_config = array(); 
            $qr_code_config['cacheable'] 	= $this->config->item('cacheable');
            $qr_code_config['cachedir'] 	= $this->config->item('cachedir');
            $qr_code_config['imagedir'] 	= $this->config->item('imagedir');
            $qr_code_config['errorlog'] 	= $this->config->item('errorlog');
            $qr_code_config['ciqrcodelib'] 	= $this->config->item('ciqrcodelib');
            $qr_code_config['quality'] 		= $this->config->item('quality');
            $qr_code_config['size'] 		= $this->config->item('size');
            $qr_code_config['black'] 		= $this->config->item('black');
            $qr_code_config['white'] 		= $this->config->item('white');

            $this->ci_qr_code->initialize($qr_code_config);

            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            //$img = substr( str_shuffle( $chars ), 0,8 );

           

            $chars2 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $qrcode= substr( str_shuffle( $chars2 ), 0,15 );
            
            $image_name = $qrcode.'.png';
             
            $params['data'] = $qrcode;
            $params['level'] = "H";
            $params['size'] = "7";
            $params['savename'] = FCPATH.$qr_code_config['imagedir'].$image_name;
            $this->ci_qr_code->generate($params); 
            $this->data['qrcode'] = $qrcode;
            $this->data['qr_code_image_url'] = base_url().$qr_code_config['imagedir'].$image_name;
          
            return $this->data;
        }
        
        function createDateRange($startDate, $endDate, $format = "m/d/Y")
        {
            $begin = new DateTime($startDate);
            $end = new DateTime($endDate);

            $interval = new DateInterval('P1D'); // 1 Day
            $dateRange = new DatePeriod($begin, $interval, $end);

            $range = [];
            foreach ($dateRange as $date) {
                $range[] = $date->format($format);
            }
			$range[] = $endDate;
            return $range;
        }
        
        function checkSeats($vehicle_id,$jdate){
            if(count($jdate) == 2){
                $ranges = $this->createDateRange($jdate[0]["datefrom"],$jdate[1]["dateto"]);
                $seats = array();
                foreach($ranges as $date){
                    $this->db->select("sum(seat_booked) as set_booked");
                    $this->db->from("seat_available");
                    $this->db->like("date",$date);
                    $this->db->where("vehicle_id",$vehicle_id);
                    $query = $this->db->get();
                    $result = $query->row_array();
                    //$seats[] = $result['set_booked'];
                    $seats[] = array(
                    "seats" => $result['set_booked'],
                    "date" =>$date,
                    );
                }
            }
            else{
                $this->db->select("sum(seat_booked) as set_booked");
                $this->db->from("seat_available");
                $this->db->like("date",$jdate[0]["datefrom"]);
                $this->db->where("vehicle_id",$vehicle_id);
                $query = $this->db->get();
                $result = $query->row_array();
                $seats[] = array(
                    "seats" => $result['set_booked'],
                    "date" =>$jdate[0]["datefrom"],
                    );
            }
            
            return $seats;
        }
        
        public function getpoints(){
            $this->db->select("sum(total_trip_points) as points_earned,sum(consumed_points) as consumed_points,sum(remain_points) as remain_points");
            $this->db->from("booking_providers_points");
            $this->db->where("booker_id",$this->userid);
            $query = $this->db->get();
            $result = $query->row_array();
            
            return $result;
        }      
        
        
        
}   
?>