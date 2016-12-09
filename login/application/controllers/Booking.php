<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    
         /* Manage Dashboard */
    
        public function __construct() {        
             parent::__construct();
             $this->load->library('paypal_lib');
             $this->userid = $this->session->userdata("id");
            if ($this->session->userdata('is_login') != "true") {
                redirect("users/login");
            }
            
            if ($this->session->userdata('role') != "booking") {
                redirect("/");
            }
        } 
	public function index()
	{
	    $data["activetab"]="dashboard";
            $data["pageTitle"]="Booking Dashboard";
            $data["pageclass"] = "booking_dashboard";
	    $bookings =  $this->BookingModel->getbookings();
            $data["booking"] = count($bookings);
            
           // $points =  $this->AdminModel->get_priceslabs();
            
            $pointsdata=  $this->BookingModel->getpoints();
            $data["points_earned"] = ($pointsdata["points_earned"] > 0)?$pointsdata["points_earned"]:"0";
            
            
            $data["points_consumed"] =($pointsdata['consumed_points'] > 0)?$pointsdata['consumed_points']:"0";
            
            $data["points_remain"] =($pointsdata["remain_points"]> 0)?$pointsdata["remain_points"]:"0";
            
            $invoices =  $this->BookingModel->getInvoices();
            $data["invoices"] = (count($invoices) > 0)?count($invoices):"0";
            
            $this->loadView('booking/dashboard-booking',$data);
	}
        
        /* Manage Book Now */
        
    public function booknow()
    {
		$data["activetab"]="bookknow";
        $data["pageTitle"]="Book Now";
        $data["pageclass"] = "booking_form";

        $this->loadView('booking/booknow/booknow',$data);
    }
    public function addbooking()
    {
            $data= $this->input->post();
            
            $response = $this->BookingModel->addBooking($data);
            $result["bookingid"] = $response["bookingid"];
            $result["points"] = $response["points"];
            $result["qrcode"] = $response["qrcode"];
            
            echo json_encode($result);
    }
    public function get_suggested_routeinfo(){
            $id = $this->input->post("routeid");
            $routes = $this->FleetModel->getRouteInfo($id);
            echo json_encode($routes);   
           
    }
    public function getVehicles()
    {
        $days = array();
        $start_from = $this->input->post("start_from");
        $end_to = $this->input->post("end_to");
        $journeytype = $this->input->post("journeytype");
        $triptype = $this->input->post("triptype");
        $time = $this->input->post("pickuptime_st");
        $days = $this->input->post('journeyday');
		if($days == null){
			$df = $this->input->post('jdate');
			
			$fromdate = $df[0]['datefrom']; 
			 
            $timestamp = strtotime($fromdate);
            $trdays = date('l', $timestamp);
			$days[] = $trdays;
			
		}
		
        if($this->input->post("pickuptime_et") != NULL){
           $time .=",".$this->input->post("pickuptime_et");
        }
        $data = array(
            "start_from" => $start_from,
            "end_to" => $end_to,
            "time" => $time,
            "days"=>$days
        );
        $vehicles = $this->BookingModel->getVehicles($data);
        echo json_encode($vehicles);
          
    }
	
    public function suggestVehicles()
    {
        $start_from = $this->input->post("start_from");
        $end_to = $this->input->post("end_to");
		$journeytype = $this->input->post("journeytype");
		
		if($journeytype == "one_time_journey"){
			$jdate = $this->input->post("jdate");		
			$date= date_create($jdate[0]["datefrom"]);
			$date = date_format($date,"m/d/Y");
			$timestamp = strtotime($date);
			$dayname = date('l', $timestamp);
			$days[] = $dayname;
		}
        else{
			 $days = $this->input->post("days");
		}
        $data = array(
            "start_from" => $start_from,
            "end_to" => $end_to,
             "days" => $days,
        );
		
        $vehicles = $this->BookingModel->suggestVehicles($data);
        echo $vehicles;
//            
    }
    
    public function countpayment()
    {
        $distance= $this->input->post("distance");
        $journeyday = $this->input->post("journeyday");
        $triptype = $this->input->post("triptype");
        $jdate = $this->input->post("jdate");
        $journeytype = $this->input->post("journeytype");
        
        
        
//        $triptype="return";
//        $journeyday=3;
//        $distance = "3 km";
        
        $paymentinfo = $this->BookingModel->countpayment($distance,$journeytype,$triptype,$journeyday,$jdate);
        echo $paymentinfo;
//            
    }
	
        
    /* Manage Booking History */

   public function booking_history()
        {
			$data["activetab"]="bookinghistory";
        $data["pageTitle"]="Booking History";
        $data["pageclass"] = "booking_history listingpage";
        $data["bookings"] = $this->BookingModel->getBookinghistory();

        $this->loadView('booking/booking_history/booking_history',$data);
         }

    /* Manage Booking History */
     public function chequeno(){
              $id = $this->input->post("id");
	         $chequede = $this->input->post("chequede");
              $response = $this->BookingModel->cheque_no($id,$chequede);
              
              echo $response;
          }
    public function booking_points()
    {
        $data["activetab"]="pointsummary";
        $records = $this->BookingModel->getPointSummary();
        $pointssummary =$records["records"];
        $data["pointssummary"] = $pointssummary;
        $data["pageTitle"]="Booked Ticktes";
        $data["pageclass"] = "booking_points listingpage";
        $this->loadView('booking/points/booking_points',$data);
    }

    /* Manage Booking Invoice */

    public function booking_invoices()
    {
	$data["activetab"]="booking_invoice";
        $invoices = $this->BookingModel->getInvoices();
        $data["invoices"]=$invoices;
        $data["pageTitle"]="Booking Invoices";
        $data["pageclass"] = "booking_invoices listingpage";
        $this->loadView('booking/invoices/booking_invoices',$data);
    }

    function getroutedetails(){
        $id = $this->input->post("id");
        $routes = $this->FleetModel->getRouteInfo($id);
        $startlatlng = explode(",",$routes["start_lat_lng"]);
        $endlatlng = explode(",",$routes["end_lat_lng"]);
        $routeinfo[0] = array(
        "title" => $routes["start_from"],
        "lat" => $startlatlng[0],
        "lng" => $startlatlng[1],
        "description"=> $routes["start_from"],
        );
        $substations = json_decode($routes["sub_station"]);
        $ss_lat_lng = json_decode($routes["ss_lat_lng"]);
        $index=1;
        for($i=0; $i < count($ss_lat_lng);$i++){
            $sublatlng = explode(",",$ss_lat_lng[$i]);
            $routeinfo[$index] =array(
                    "title" => $substations[$i],
                    "lat" => $sublatlng[0],
                    "lng" => $sublatlng[1],
                    "description"=> $substations[$i],
                    );
            $index++;
        }
        $routeinfo[count($ss_lat_lng)+1] =array(
                    "title" => $routes["end_to"],
                    "lat" => $endlatlng[0],
                    "lng" => $endlatlng[1],
                    "description"=> $routes["end_to"],
                    );

        echo json_encode($routeinfo);
    }
    
    function paypalsetup($bookingid){
        //Set variables for paypal form
        $returnURL = base_url().'paypal/success'; //payment success url
        $cancelURL = base_url().'paypal/cancel'; //payment cancel url
        $notifyURL = base_url().'paypal/ipn'; //ipn url
        //get particular product data
        
        $bookinginfo = $this->BookingModel->getBookingInfo($bookingid);
        
        $userID = $this->userid; //current user id
        $logo = base_url().'assets/images/logo.png';
        $paypalID = "demo1user123@gmail.com";
        $this->paypal_lib->add_field('business', $paypalID);
        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name',$bookinginfo["pickup_from"]." to ".$bookinginfo["drop_to"]);
        $this->paypal_lib->add_field('custom', $userID);
        $this->paypal_lib->add_field('item_number', $bookinginfo["id"]);
        $this->paypal_lib->add_field('amount', $bookinginfo["total_amount"]);  
        $this->paypal_lib->image($logo);
        $this->paypal_lib->paypal_auto_form();
        
    }
    
    
    public function getInvoiceInfo($id){
        $invoiceinfo = $this->BookingModel->getInvoiceInfo($id);
        echo json_encode($invoiceinfo);
        
    }
    public function test(){
        $invoiceinfo = $this->BookingModel->qrcode();
        
        
        
    }
    
}
