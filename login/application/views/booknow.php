<form role="form" id="booknow" name="booknow">
<div class="bookingform">
<div class="row">
    <div class="col-md-12">
        <div class="panel with-nav-tabs panel-primary">
            <div class="panel-heading clearfix">
                    <ul class="nav nav-tabs tabstyle">
                        <li id="location" class="active"><a href="#tab1primary">Location <span class="tabno">1</span></a></li>
                        <li id="selveh"><a href="#tab2primary">Select Vehicle <span class="tabno">2</span></a></li>
                        <li id="bookform"><a href="#tab3primary">Booking form <span class="tabno">3</span></a></li>
						<li id="confirmpay"><a href="#tab4primary">Confirm and Pay <span class="tabno">4</span></a></li>
                        <li id="payment"><a href="#tab5primary">Payment <span class="tabno">5</span></a></li>
                        <li id="confirmation"><a href="#tab6primary">Confirmation <span class="tabno">6</span></a></li>
                        <li id="lastli"></li>
                    </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade  active in" id="tab1primary">
                        <div class="tabhead">
                            <div class="thead pull-left">
                                <h3>Select Location</h3>
                            </div>
<!--                            <div class="navigatebnt pull-right">
                                <button class="btn btn-default  next-tab btn-flat btn-red" type="button"><span class="glyphicon glyphicon-chevron-right"></span> Next</button>
                            </div>-->
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-6 col-md-6 col-sm-12 locationform formarea">
                                    <div class="formfield">
                                            <div class="form-group">
                                                <label>Pick up From</label>
                                                   <input type="text" name="pickup_from" id="pickup_from" class="form-control input-sm">
                                                   <input type="hidden" name="pickup_lat_lng" id="pickup_lat_lng" />
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Drop to</label>
                                                <input type="text" name="drop_to" id="drop_to" class="form-control input-sm pull-left ">
                                                <input type="hidden" name="dropto_lat_lng" id="dropto_lat_lng" />
                                            </div>
											
                                            <div class="form-group actnbtn">
                                                    <button class="btn btn-default btn-flat btn-red pull-left showroute" type="button"><i class="fa fa-map-marker"></i> Show Route on Map</button>
                                                    <!--<button class="btn btn-default btn-flat btn-red pull-left suggestVehicles" type="button"><i class="fa fa-bus"></i> Suggest Vehicles</button>-->
                                            </div>
                                            <div class="form-group timeofpickup">
                                                <label for="email2" class="pull-left">Journey Type</label>
                                                <div class="journeytype pull-left">
                                                    <input type="radio" name="journeytype" onclick="show_jtinfo('otj')" value="one_time_journey" class="radioinp"> <span> One Time Journey</span>
                                                    <input type="radio" name="journeytype" onclick="show_jtinfo('rj')" value="recurring_journey" class="radioinp"> <span> Recurring Journey</span>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div id="journeytype" class="form-group">
                                                <!-- ============================ One Time Journey ============================ -->
                                                <div id="otj" class="jtinfo">
                                                     <div class="form-group">
                                                        <label>Trip Type</label>
                                                        <select class="form-control" id="otj_trip_type" name="otj_trip_type" onchange="settripopt(this.value,'onetime')">
                                                            <option value="oneway">One way Trip</option>
                                                            <option value="return">Return trips</option>
                                                        </select>
                                                    </div>
                                                     <div class="form-group">
                                                        <label>Date</label>
                                                        <input name="otj_datefrom" id="otj_datefrom" class="form-control">
                                                    </div>
                                                    <div id="oneway" class="triptype" style="display:block !important">
                                                        <div class="form-group timeofpickup">
                                                           <label for="onewaytime" class="pull-left">Pick up Time:</label>
                                                           <div class="input-group bootstrap-timepicker timepicker pull-left">
                                                               <input id="timepicker1" type="text" name="otj_onewaytime" class="form-control input-small timepicker">
                                                               <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                           </div>
                                                        </div>
                                                    </div>
                                                   
                                                   <div id="return" class="triptype">
                                                        <div class="form-group timeofpickup">
                                                           <label for="returnpickupst" class="pull-left">Pickup Time - Start Location:</label>
                                                           <div class="input-group bootstrap-timepicker timepicker pull-left">
                                                               <input id="timepicker1" type="text" name="otj_returnpickupst" class="form-control input-small timepicker">
                                                               <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                           </div>
                                                        </div>
                                                        <div class="form-group timeofpickup">
                                                           <label for="returnpickupet" class="pull-left">Pickup Time - End Location:</label>
                                                           <div class="input-group bootstrap-timepicker timepicker pull-left">
                                                               <input id="timepicker1" type="text" name="otj_returnpickupet" class="form-control input-small timepicker">
                                                               <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                           </div>
                                                        </div>
                                                    </div>
													
                                                </div>
                                                
                                                
                                                <!--- ===================== Recurring Trip ====================== -->
                                                <div id="rj" class="jtinfo">
                                                    <div class="form-group">
                                                        <label>Date From</label>
                                                        <input class="form-control" id="rjfrom" name="rj_datefrom">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Date To</label>
                                                        <input class="form-control" id="rjto" name="rj_dateto">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Select Days</label>
                                                        <div class="journeyday">
                                                            <div class="dayblock">
                                                            <input type="checkbox" name="journeyday[]" value="Sunday" class="checkboxinp"> <span>Sunday</span>
                                                            </div>
                                                            <div class="dayblock">
                                                            <input type="checkbox" name="journeyday[]" value="Monday" class="checkboxinp"> <span>Monday</span>
                                                            </div>
                                                            <div class="dayblock">
                                                            <input type="checkbox" name="journeyday[]" value="Tuesday" class="checkboxinp"> <span>Tuesday</span>
                                                            </div>
                                                            <div class="dayblock">
                                                            <input type="checkbox" name="journeyday[]" value="Wednesday" class="checkboxinp"> <span>Wednesday</span>
                                                            </div>
                                                            <div class="dayblock">
                                                            <input type="checkbox" name="journeyday[]" value="Thursday" class="checkboxinp"> <span>Thursday</span>
                                                            </div>
                                                            <div class="dayblock">
                                                            <input type="checkbox" name="journeyday[]" value="Friday" class="checkboxinp"> <span>Friday</span>
                                                            </div>
                                                            <div class="dayblock">
                                                            <input type="checkbox" name="journeyday[]" value="Saturday" class="checkboxinp"> <span>Saturday</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Trip Type</label>
                                                        <select class="form-control" id="rj_trip_type" name="rj_trip_type" onchange="settripopt(this.value,'recurring')">
                                                            <option value="oneway">One way Trip</option>
                                                            <option value="return">Return trips</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div id="rec-oneway" class="rectriptype" style="display:block !important">
                                                        <div class="form-group timeofpickup">
                                                           <label for="onewaytime" class="pull-left">Pick up Time:</label>
                                                           <div class="input-group bootstrap-timepicker timepicker pull-left">
                                                               <input id="timepicker1" type="text" name="rj_onewaytime" class="form-control input-small timepicker">
                                                               <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                           </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="rec-return" class="rectriptype">
                                                        <div class="form-group timeofpickup">
                                                           <label for="returnpickupst" class="pull-left">Pickup Time - Start Location:</label>
                                                           <div class="input-group bootstrap-timepicker timepicker pull-left">
                                                               <input id="timepicker1" type="text" name="rj_returnpickupst" class="form-control input-small timepicker">
                                                               <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                           </div>
                                                        </div>
                                                        <div class="form-group timeofpickup">
                                                           <label for="returnpickupet" class="pull-left">Pickup Time - End Location:</label>
                                                           <div class="input-group bootstrap-timepicker timepicker pull-left">
                                                               <input id="timepicker1" type="text" name="rj_returnpickupet" class="form-control input-small timepicker">
                                                               <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                           </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="formsubmit pull-right">
                                           <!-- <div class="form-group">
                                                     <input type="checkbox" name="return_journey" value="1" class="checkboxinp"> <span>Return Journey (Optional)</span>
                                                 </div> -->
                                                <div class="navigatebnt pull-right">
                                                    <button class="btn btn-default next-tab btn-flat btn-red getvehicle" type="button"><span class="glyphicon glyphicon-chevron-right"></span> Next</button>
                                                </div>
                                            </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12 locationmap">
                                    <div class="map">
									<div id="dvMap" style="width: 100%; height:450px"></div>
                                        <!--<img src="<?= base_url()?>assets/images/map.jpg" />-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- =================================== Vehicle Tab ========================================= -->
                    <div class="tab-pane fade" id="tab2primary">
                        <div class="tabhead">
                            <div class="thead pull-left">
                                <h3>Select Vehicle</h3>
                            </div>
                        </div>
                        <input type="hidden" id="vehicle_selected" name="vehicle_selected" />
                        <input type="hidden" id="route_selected" name="route_selected" />
                        <input type="hidden" id="route_distance" name="route_distance" />
                        <input type="hidden" id="route_price" name="route_price" />
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="vehicleselect">
                                   <div class="row">
                                    <div class="col-lg-12">
                                            <!-- ========================= Available Vehicles ================================= -->
                                            <div id="available_vehicles" class="panel panel-default">
                                                    <div class="panel-heading">
                                                            Vehicles List
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                            <div class="dataTable_wrapper">
                                                                <div class="table-responsive">
                                                                    <table id="example2" class="table table-bordered table-hover">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th class="nosort">Vehicle Image</th>
                                                                                            <th>Vehicle Number</th>
                                                                                            <th>Route</th>
                                                                                            <th>Seating Capacity</th>
                                                                                            <th>Seating Available</th>
                                                                                            <th class="nosort"></th>
                                                                                            
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody id="vehiclelists">
                                                                                  
                                                                            </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <!-- /.table-responsive -->
                                                    </div>
                                                    <!-- /.panel-body -->
                                            </div>
                                        
                                            <!-- ========================= Suggested Vehicles ================================= -->
                                            
                                            
                                            <div id="suggested_vehicles" class="panel panel-default">
                                                <div class="sv_alert">
                                                    <div  id="sughead" class="alert alert-red">
                                                         
                                                    </div>
                                                </div>
                                                <div class="panel-heading">
                                                   <b>Suggested Vehicles List</b>
                                                </div>
                                                <!-- /.panel-heading -->
                                                <div class="panel-body">
                                                    <div class="dataTable_wrapper">
                                                            <div class="table-responsive">
                                                                <table id="example2" class="table table-bordered table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="nosort">Vehicle Image</th>
                                                                            <th>Vehicle Number</th>
                                                                            <th>Route</th>
                                                                            <th>Substations</th>
																			<th class="rinfocols">Date/Time/Seats Available</th>
                                                                            <!--<th>Seating Capacity</th>
                                                                            <th>Seating Available</th>
                                                                            <th>Start Destination</th>
                                                                            <th>End Destination</th>-->
                                                                            <th clas="nosort"></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="sugvehlists">

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                    </div>
                                                    <!-- /.table-responsive -->
                                                </div>
                                                            <!-- /.panel-body -->
                                            </div>
                                            
                                            <!-- /.panel -->
                                    </div>
                                    <!-- /.col-lg-12 -->
                                    </div>
                                </div>
                            </div>
                            <div class="navigatebnt pull-right">
                                <div class="col-md-12">
                                    <button class="btn btn-default previous-tab btn-flat btn-red" type="button"><span class="glyphicon glyphicon-chevron-left"></span> Previous</button>
                                    <!--<button id="vehiclenext" class="btn btn-default  next-tab btn-flat btn-red" type="button"><span class="glyphicon glyphicon-chevron-right"></span> Next</button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- =================================== Vehicle Tab End ========================================= -->
                    
                    <!-- =================================== Booking form Tab ========================================= -->
                    <div class="tab-pane fade" id="tab3primary">
                       <div class="tabhead">
                            <div class="thead pull-left">
                                <h3>Booking Form</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="vehicleselect">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-12 col-md-12 col-sm-12 bookingform formarea">
                                                <div class="formfield">
                                                    
                                                        <div class="input-group-form">
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" id="psngr_name" name="psngr_name[]" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="email" id="psngr_email" name="psngr_email[]" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Phone Number</label>
                                                                <input type="number" id="psngr_phoneno" name="psngr_phoneno[]" class="form-control">
                                                            </div>
                                                              <div class="form-group">
                                                                <label>Choose Option</label>
                                                                <select class="form-control" id="empdetoption" name="empdetoption" onchange="setoption(this.value)">
                                                                    <option value="">Choose Option</option>
                                                                    <option value="emp_details">Enter Employees details</option>
                                                                    <option value="enter_no">Enter only Number of Employees</option>
                                                                    <option value="both">Both</option>
                                                                </select>
                                                            </div>
<!--                                                            <div class="form-group">
                                                                <div class="inputcheckbox">
                                                                    <input type="checkbox" id="empopt" class="checkboxinp" onchange="setempdetail()" name="option" /> <span>Add Employees Details</span>
                                                                </div>
                                                            </div>-->
                                                        </div>
                                                        <div id="empno" class="empdetail">
                                                            <div class="form-group">
                                                                <label>Enter No. Employees</label>
                                                                <input type="number" id="noofemp" name="noofemp" value="" class="form-control">
                                                            </div>
                                                        </div>
                                                            <div id="empdetails" class="empdetail">
                                                                <div id="emplists">
                                                                    
                                                                </div>
                                                                <div class="addemp">
                                                                    <button type="button" class="btn btn-warning btn-flat" onclick="addmoreemp()"><i class="fa fa-plus"></i> Add More Employee</button>
                                                                </div>
                                                            </div>
                                                        <!--<button type="button" class="btn btn-default btn-red btn-flat"> Submit</button>-->
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="navigatebnt pull-right">
                                <div class="col-md-12">
                                    <button class="btn btn-default previous-tab btn-flat btn-red" type="button"><span class="glyphicon glyphicon-chevron-left"></span> Previous</button>
                                    <button class="btn btn-default  next-tab btn-flat btn-red bookingformbtn" type="button"><span class="glyphicon glyphicon-chevron-right"></span> Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- =================================== Booking form Tab End ========================================= -->
					<!-- =================================== Booking Confirm ========================================= -->
					<div class="tab-pane fade" id="tab4primary">
                        <div class="tabhead">
                            <div class="thead pull-left">
                                <h3>Booking Details</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="bookingdetails">
                                        <div class="row">
                                                <div class="col-sm-12">
                                                        <div class="bdlab pull-left">Date </div>
                                                        <div class="bdtext pull-left" id="bkdate"></div>
                                                </div>
                                                <div class="col-sm-12">
                                                        <div class="bdlab pull-left">Route </div>
                                                        <div class="bdtext pull-left" id="bkroute"></div>
                                                </div>

                                                <div class="col-sm-12">
                                                        <div class="bdlab pull-left">Total KM </div>
                                                        <div class="bdtext pull-left" id="bkkm"></div>
                                                </div>

                                                <div class="col-sm-12">
                                                        <div class="bdlab pull-left">Time </div>
                                                        <div class="bdtext pull-left" id="bktime"></div>
                                                </div>
                                                <div class="col-sm-12">
                                                        <div class="bdlab pull-left">Days </div>
                                                        <div class="bdtext pull-left" id="jdays"></div>
                                                </div>
                                                <div class="col-sm-12">
                                                        <div class="bdlab pull-left">No. of Passengers </div>
                                                        <div class="bdtext pull-left" id="no_of_passenger"></div>
                                                </div>
                                                <div class="col-sm-12">
                                                        <div class="bdlab pull-left">Passenger Info</div>
                                                    <div class="psginf">
                                                                <table class="table table-reflow">
                                                                  <thead>
                                                                        <tr>
                                                                          <th>Name</th>
                                                                          <th>Email</th>
                                                                          <th>Phone</th>
                                                                        </tr>
                                                                  </thead>
                                                                  <tbody>

                                                                  </tbody>
                                                                </table>
                                                        </div>
                                                </div>

                                                <div class="col-sm-12">
                                                        <div class="bdlab pull-left">Amount: </div>
                                                        <div class="bdtext pull-left" id="bkamt"></div>
                                                </div>
                                        </div>
                                </div>
                            </div>
							<div class="navigatebnt pull-right">
                                <div class="col-md-12">
                                    <button class="btn btn-default previous-tab btn-flat btn-red" type="button"><span class="glyphicon glyphicon-chevron-left"></span> Previous</button>
                                    <button class="btn btn-default  next-tab btn-flat btn-red" type="button"><span class="glyphicon glyphicon-chevron-right"></span> Confirm and Pay</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- =================================== Booking Confirm Tab End ========================================= -->
                    
                    <!-- =================================== Payment Tab ========================================= -->
                    <div class="tab-pane fade" id="tab5primary">
                       <div class="tabhead">
                            <div class="thead pull-left">
                                <h3>Payment</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="vehicleselect">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-12 col-md-12 col-sm-12 formarea">
                                                <div class="formfield">
                                                        <div class="form-group">
                                                            Total Amount:<span  id="totalprice" data-toggle="tooltip" data-placement="right" data-html="true" title="<p align='left'>Route : Singapore Zoo to Singapore Safari <br> Rate : $5 <br> No. Of Passenger:5</p>">$25</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Select Payment Mode</label> <Br>
                                                            <input type="radio" id="paypal" name="paymenttype" value="paypal"> Paypal <Br>
                                                            <input type="radio" name="paymenttype" value="banktransfer"> Bank Transfer<Br>
                                                            <input type="radio" name="paymenttype" value="cheque"> Cheque<Br>
                                                        </div>
                                                        
                                                        <div id="transaction_no" class="form-group hide">
                                                            <label>Enter Transaction or Cheque No.</label> <Br>
                                                <input type="text" id="empty" name="transaction_no"  class="form-control">
                                                        </div>
												   <div id="transaction_no_check" class="form-group hide">
                                                           
                                                          <input type="checkbox" onchange="check_check()" id="empty_check" name="transaction_no_check"  class="form-control checkbox" /><span>Enter value later</span>
                                                    </div>
                                                        
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="navigatebnt pull-right">
                                <div class="col-md-12">
                                    <button class="btn btn-default previous-tab btn-flat btn-red" type="button"><span class="glyphicon glyphicon-chevron-left"></span> Previous</button>
                                    <button class="btn btn-default  next-tab btn-flat btn-red payment" type="button"><span class="glyphicon glyphicon-chevron-right"></span> Next</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- =================================== Payment Tab End ========================================= -->
                    
                    <!-- =================================== Final Tab ========================================= -->
                    <div class="tab-pane fade" id="tab6primary">
                        <div class="tabhead">
                            <div class="thead pull-left">
                                <h3>Thank You</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <p>Thanks for Booking with us. Your booking has been confirmed</p>
                                
                                <div class="bookingdetail">
                                    <h4>Your Booking details</h4>
                                    <ul>
                                        <li><b>Booking ID</b> -<span id="bookingid"> </span> </li>
                                        <li><b>QR CodeD</b> -<span id="qrcode"></span> </li>
                                        <li><b>Tickets</b> -<span id="prearn"></span> </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="navigatebnt pull-right">
<!--                                <div class="col-md-12">
                                    <button class="btn btn-default previous-tab btn-flat  btn-red" type="button"><span class="glyphicon glyphicon-chevron-left"></span> Previous</button>
                                    <button class="btn btn-default  next-tab btn-flat btn-red" type="button"><span class="glyphicon glyphicon-chevron-ok"></span> Submit</button>
                                 </div>-->
                            </div>
                        </div>
                    </div>
                    <!-- =================================== Final Tab End ========================================= -->
                    <!-- =================================== success ========================================= -->
                    <div class="tab-pane fade" id="tab6primary">
                        <div class="tabhead">
                            <div class="thead pull-left">
                                <h3>Booking Success</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <p>Booking Submitted Successfully</p>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
 </div>
</div>
</form>

<!--<div id="suggestVehicles" class="hide popupmodel">
    <div class="popupmodel_inner container">
	<div class="alert alert-warning pull-left">
		No Vehicles are available at given time for your route. Below are the suggested list.
	</div>
		<div class="closebnt">
            <button data-dismiss="modal" class="btn btn-red btn-flat no-border pull-right" onclick="closemap()" type="button"><i class="fa fa-times fa-2x"></i></button>
        </div>
        <div class="row">
            <div class="col-lg-12">
                    <div class="vehicleselect">
                       <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <b>Suggested Vehicles List</b>
                                    </div>
                                     /.panel-heading 
                                    <div class="panel-body">
                                        <div class="dataTable_wrapper">
                                                <div class="table-responsive">
                                                    <table id="example2" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="nosort">Vehicle Image</th>
                                                                <th>Vehicle Number</th>
                                                                <th>Route</th>
                                                                <th>Substations</th>
                                                                <th>Seating Capacity</th>
                                                                <th>Start Destination</th>
                                                                <th>End Destination</th>
                                                                <th clas="nosort"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="sugvehlists">

                                                        </tbody>
                                                    </table>
                                                </div>
                                        </div>
                                         /.table-responsive 
                                    </div>
                                                 /.panel-body 
                                </div>
                                             /.panel 
                            </div>
                             /.col-lg-12 
                            </div>
                    </div>
            </div>
            </div>
    </div>
</div>-->
<div class="loading">Loading&#8230;</div>
<script>

function show_jtinfo(id){
    $(".jtinfo").fadeOut()
    $("#"+id).fadeIn()
}
function settripopt(value,type){
    if(type == "onetime"){
        if(value == "oneway"){
            $(".triptype").hide();
            $("#oneway").show();
        }
        else{
            $(".triptype").hide();
            $("#return").show();
        }
    }
    else{
        if(value == "oneway"){
            $(".rectriptype").hide();
            $("#rec-oneway").show();
        }
        else{
            $(".rectriptype").hide();
            $("#rec-return").show();
        }
    }
}
</script>

<script>
    
$(function () {
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
     "order": [[ 1, "desc" ]],
    "ordering": true,
    "info": true,
    "autoWidth": false,
    'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': ['nosort']
        }]
  });
});
$(document).ready(function(){
    $("input[name=paymenttype]").change(function(){
        var paymentopt = $('input[name=paymenttype]:checked').val(); 
        if(paymentopt !="paypal"){
            $("#transaction_no").removeClass("hide");
			$("#transaction_no_check").removeClass("hide");
        }
        else{
            $("#transaction_no").addClass("hide");
			$("#transaction_no_check").addClass("hide");
        }
    });

});

function check_check()
{
var chkPassport = document.getElementById("empty_check");
var a = document.getElementById("empty");
      if (chkPassport.checked) { 
             a.value = "0";
	        $("#transaction_no").addClass("hide");
        } else {
             a.value = "";
	        $("#transaction_no").removeClass("hide");
        }
	
	 
}
var cnt = 1;
function setempdetail(){
    var ischk = $('#empopt').is(":checked");
    if(ischk == true){
        $("#empdetails").show();
    }
    else{
        $("#empdetails").hide();
        $("#emplists").html(" ");
        cnt=1;
    }
}
function addmoreemp(){
    var value = $("#empdetoption").val();
    if(value == "both"){        
        var noofemp = $("#noofemp").val();
        if(cnt > noofemp){
            bootbox.alert("Cannot add more");
            return false;
        }
    }
    var html ='<div id="emp-'+cnt+'" class="input-group-form">';
    html +='<div class="form-group">';
    html +='<div class="inphead pull-left">Employee '+cnt+'</div>';
    html +='<button type="button" class="btn btn-sm btn-danger btn-flat removeslab pull-right" onclick="removemoreemp('+cnt+')"><i class="fa fa-trash"></i> Remove </button>';
    html +='</div>';
    html +='<div class="form-group">';
    html +='<label>Name</label>';
    html +='<input type="text" id="psngr_name" name="psngr_name[]" class="form-control">';
    html +='</div>';
    html +='<div class="form-group">';
    html +='<label>Email</label>';
    html +='<input type="email"  name="psngr_email[]" class="form-control">';
    html +='</div>';
    html +='<div class="form-group">';
    html +='<label>Phone Number</label>';
    html +='<input type="number"  name="psngr_phoneno[]" class="form-control">';
    html +='</div>';
    html +='</div>';
    $("#emplists").append(html);
    $("#noofemp").val(cnt);
    cnt++
}

function journeytype(type){
    
}
function removemoreemp(empblkid){
    $("#emp-"+empblkid).remove();
    cnt--;
    $("#noofemp").val(cnt);
}
function submitform(){
    $(".tab-pane").removeClass("active in");
    $("#tab6primary").addClass("active in");
}


var options = {
address: 'address',
componentRestrictions: {country: "sgp"}
};

$(function () {	
$("#pickup_from")
        .geocomplete(options)
        .bind("geocode:result", function (event, result) {						
                var lat_lng = result.geometry.location.lat()+","+result.geometry.location.lng();
                $("#pickup_lat_lng").val(lat_lng);
                //console.log(result);
});

$("#drop_to")
        .geocomplete(options)
        .bind("geocode:result", function (event, result) {						
                var lat_lng = result.geometry.location.lat()+","+result.geometry.location.lng();
                $("#dropto_lat_lng").val(lat_lng);
});
});

</script>
<script type="text/javascript">
$(document).ready(function(){
	var markers = [
		{
			"title": 'Singapore Zoo',
			"lat": '1.4043',
			"lng": '103.7930',
			"description": 'Singapore Zoo.'
		}
	,
		{
			"title": 'Merlion Park',
			"lat": '1.2868',
			"lng": '103.8545',
			"description": 'Merlion Park.'
		}
	
	];
        initialize(markers);
	//showroute(markers);
	
	$(".showroute").click(function(){
		var pickup_lat_lng = $("#pickup_lat_lng").val();
		var pickup_from = $("#pickup_from").val();
		
		var dropto_lat_lng = $("#dropto_lat_lng").val();
		var drop_to = $("#drop_to").val();
		
		var pll = pickup_lat_lng.split(",");
		var dll = dropto_lat_lng.split(",");
		var markers = [
		{
			"title": pickup_from,
			"lat": pll[0],
			"lng": pll[1],
			"description": pickup_from
		}
	,
		{
			"title": drop_to,
			"lat": dll[0],
			"lng": dll[1],
			"description":drop_to
		}
	
	];
	showroute(markers);
	});
	$(".suggestVehicles").click(function(){
		suggestVehicles();
	});
	
});
function showroute(routes){
	var markers = routes;
	initialize(markers);
	
}


function suggestVehicles(jdate){
    //$("#suggestVehicles").removeClass("hide");
     $("#suggested_vehicles").show();
     $("#available_vehicles").hide();
	var days = [];
	$('[name="journeyday[]"]:checked').each(function() {
		days.push($(this).attr('value'));
	});
	var pickup_from = $("#pickup_from").val();
         var dropto = $("#drop_to").val();
		 var journeytype = $("input[name='journeytype']:checked").val();
		
         if(pickup_from != "" && dropto !=""){
            $.ajax({
                     url: baseurl+"booking/suggestVehicles",
                     type:"post",
                     data:{
                             start_from:pickup_from,
                             end_to:dropto,
                             jdate:jdate,
							 days:days,
							 journeytype:journeytype,
                     },
                     dataType:"html",
                     success: function(result){
                             if(result == "No Vehicles"){
                                 $("#sughead").html("<b>Sorry No Match Found.</b>");
                             }
                             else{
                                 $("#sughead").html("<b>Sorry, no exact matches found however we have few suggested trips for you!</b>");
                             }
                             $("#sugvehlists").html(result);
                             return false;
                     }
             });
        }
        else{
                alert("Select Locations");
                return false;
        }
}


function closemap(){
    $("#suggestVehicles").addClass("hide");
}

function setoption(value){
    cnt = 1;    
    $("#noofemp").val(cnt);
    $("#emplists").html("");
    $(".empdetail").hide();
    if(value == "emp_details"){
        $("#empdetails").show();
    }
    
    if(value == "enter_no"){
        $("#empno").show();
    }
    
    if(value == "both"){
        $("#empdetails").show();
        $("#empno").show();
    }
    
}
</script>

