<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
         $this->load->library('email'); 
        $this->load->helper('text');
	$this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->load->library("pagination");
        $this->load->library('upload');	
        $this->load->library('DashboardMenu');
        $this->load->model('UsersModel');
        $this->load->model('FleetModel');
      $this->load->model('AdminModel');
        $this->load->model('BookingModel');
        $this->uri->segment(2);

    }
    
    public function loadView($fileName,$data = array()){
        $menuarray = $this->dashboardmenu->getDashboardMenu($this->session->userdata("role"));
        $userdata = $this->session->userdata("userdata");
        $data["dashboardmenu"] = $menuarray;
        $data["usertype"] =$this->session->userdata('userrole');
        $data["userdata"] = $userdata;
        $this->load->view('common/header',$data);
        $this->load->view($fileName,$data);
        $this->load->view('common/footer',$data);
    }
    public function checkSession()
    {
        if(empty($this->session->userdata('id')))
        {
             redirect("/login");
        }
    }
    public function getRedirect()
    {
        $role = $this->session->userdata("userrole");
        return $role;
    }
    
    
    
}