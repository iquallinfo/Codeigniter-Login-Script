<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardMenu {

	public function getDashboardMenu($usertype)
	{
		$menuarray = array(
                 /* ================================ Admin usermenu  ================================*/
                "fleetproviders" => array(
                        "title"  => "Fleet Provider",
                        "icon"=> "fa fa-car",
                        "url"=>base_url()."admin/fleet_providers",
                        "usertype" => "admin",
                   ),    
                "bookingcomp" => array(
                                "title"  => "Booking Companies",
                                "icon"=> "fa fa-bookmark",
                               "url"=>base_url()."admin/booking_companies",
                                "usertype" => "admin",
                           ),   
                 "viewbooking" => array(
                                "title"  => "View Booking",
                                "icon"=> "fa fa-bookmark",
                               "url"=>base_url()."admin/view_bookings",
                                "usertype" => "admin",
                           ),      
                 "invoice_receive" => array(
                                 "title" =>"Invoice Receivables",
                                "icon"=> "fa fa-money",
                                "url"=>base_url()."admin/invoice_receivables",
                                "usertype" => "admin",
                           ),  
                    
//                 "invoice_payable" => array(
//                                 "title" =>"Invoice Payables",
//                                "icon"=> "fa fa-money",
//                                "url"=>base_url()."admin/invoice_payables",
//                                "usertype" => "admin",
//                           ), 
                "fleet_invoice" => array(
                            "title" =>"Invoice Payables",
                            "icon"=> "fa fa-money",
                            "url"=>base_url()."admin/fleet_invoice",
                            "usertype" => "admin",
                       ),  
                "manage_slabs" => array(
                                    "title"  => "Manage Price & Threshold ",
                                    "icon"=> "fa fa-star-o",
                                    "url"=>base_url()."admin/manage_slabs",
                                    "usertype" => "admin"
                           ),
               "admin_profile" => array(
					 "title"  => "Manage Profile",
					 "icon"=> "fa fa-user",
					 "url"=> "#",
					 "child"=> array(
							"admin_chgpass" => array(
											   "title" =>"Change Password",
											   "icon"=> "fa fa-caret-right",
											   "url"=>base_url()."users/change_password",
											   ),
							"admin_chgdet" => array(
											   "title" =>"Changes Details",
											   "icon"=> "fa fa-caret-right",
											   "url"=>base_url()."users/change_details",
											   ),
							),
					 "usertype" => "admin",

				),   
                /* ================================ Booking usermenu  ================================*/
                 "bookinghistory" => array(
                                    "title"  => "Booking",
                                    "icon"=> "fa fa-calendar",
                                    "url"=> base_url()."booking/booking_history",
                                    "usertype" => "booking",
                                   ),   
                "pointsummary" => array(
                                "title"  => "Tickets Summary",
                                "icon"=> "glyphicon glyphicon-star-empty",
                                "url"=> base_url()."booking/booking_points",
                                "usertype" => "booking",
                               ),
                 "booking_invoice" => array(
                                "title"  => "Invoice",
                                "icon"=> "fa fa-dollar",
                                "url"=> base_url()."booking/booking_invoices",
                                "usertype" => "booking",
                               ),
                "bookknow" => array(
                                "title"  => "Book Now",
                                "icon"=> "fa fa-tag fa-fw",
                                "url"=> base_url()."booking/booknow",
                                "usertype" => "booking",
                               ),
                "booking_profile" => array(
                                 "title"  => "Manage Profile",
                                 "icon"=> "fa fa-user",
                                 "url"=> "#",
                                 "child"=> array(
                                        "booking_chgpass" => array(
                                                           "title" =>"Change Password",
                                                           "icon"=> "fa fa-caret-right",
                                                           "url"=>base_url()."users/change_password",
                                                           ),
                                        "booking_chgdet" => array(
                                                           "title" =>"Changes Details",
                                                           "icon"=> "fa fa-caret-right",
                                                            "url"=>base_url()."users/change_details",
                                                           ),
                                        ),
                                 "usertype" => "booking",

               ),           	     
            /* ================================ Fleet usermenu  ================================*/
                "vehicle_manage" => array(
                        "title"  => "Vehicle Management",
                        "icon"=> "fa fa-bus",
                        "url"=> "#",
                        "child"=> array(
                                 "manageveh" => array(
                                                   "title" =>"Manange Vehicle",
                                                   "icon"=> "fa fa-caret-right",
                                                   "url"=>base_url()."fleet/manage_vehicles",
                                                   ),
                                 "addveh" => array(
                                                   "title" =>"Add Vehicle",
                                                   "icon"=> "fa fa-caret-right",
                                                   "url"=>base_url()."fleet/addvehicle",
                                                   ),
                                ),
                        "usertype" => "fleet",
                                ),
                "routemanage" => array(
                                 "title"  => "Route Management",
                                 "icon"=> "fa fa-road",
                                 "url"=> "#",
                                 "child"=> array(
                                        "manageroute" => array(
                                                           "title" =>"Manange Route",
                                                           "icon"=> "fa fa-caret-right",
                                                            "url"=>base_url()."fleet/manage_route",
                                                           ),
                                        "addroute" => array(
                                                           "title" =>"Add Route",
                                                           "icon"=> "fa fa-caret-right",
                                                            "url"=>base_url()."fleet/addroute",
                                                           )
                                        ),
                                "usertype" => "fleet",

                                ),
                "paymentmanage" => array(
                                 "title"  => "Payment Management",
                                 "icon"=> "fa fa-dollar",
                                 "url"=> "#",
                                 "child"=> array(
                                        "manageroute" => array(
                                                           "title" =>"View Payment",
                                                           "icon"=> "fa fa-caret-right",
                                                            "url"=>base_url()."fleet/manage_payment",
                                                           ),
                                        ),
                                "usertype" => "fleet",

                                ),
                
                "confirm_trip" => array(
                                 "title"  => "Confirm Trip",
                                 "icon"=> "fa fa-road",
                                 "url"=> "#",
                                 "child"=> array(
                                        "addbookingpoints" => array(
                                                           "title" =>"Add Booking Tickets",
                                                           "icon"=> "fa fa-caret-right",
                                                            "url"=>base_url()."fleet/addbookingpoints",
                                                           )
                                        ),
                                "usertype" => "fleet",
                                ),  
                "flpointsummary" => array(
                            "title"  => "Tickets Summary",
                            "icon"=> "glyphicon glyphicon-star-empty",
                            "url"=> base_url()."fleet/fleet_points",
                            "usertype" => "fleet",
                           ),
                "profileupdate" => array(
                                 "title"  => "Manage Profile",
                                 "icon"=> "fa fa-user",
                                 "url"=> "#",
                                 "child"=> array(
                                        "fleet_chgpass" => array(
                                                           "title" =>"Change Password",
                                                           "icon"=> "fa fa-caret-right",
                                                           "url"=>base_url()."users/change_password",
                                                           ),
                                        "fleet_chgdet" => array(
                                                           "title" =>"Changes Details",
                                                           "icon"=> "fa fa-caret-right",
                                                            "url"=>base_url()."users/change_details",
                                                           ),
                                        ),
                                 "usertype" => "fleet",

                                ),

            );
	
		return $menuarray;
	}
}