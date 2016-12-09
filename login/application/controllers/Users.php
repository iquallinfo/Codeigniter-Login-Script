<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

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
	
    public function index()
    {
        if(empty($this->session->userdata('id')))
        {
            redirect("/users/login");
        }
        else{
            $getRedirect = $this->getRedirect();
            redirect($getRedirect);
        }
    }
        
    public function login()
    {
        if ($this->session->userdata('is_login') == "true") {
            redirect("/");
        }
        $data["pageTitle"]="WLC Login";
        $this->load->view('login',$data);
    }

    public function getLogin()
    {           
        $records = array(
            "email" => $this->input->post("email"), 
            "password" => $this->input->post("password"),
        );
        $response = $this->UsersModel->loginUser($records);
    }
    public function signup()
    {
        if(!empty($this->session->userdata('id')))
        {
           $getRedirect = $this->getRedirect();
            redirect($getRedirect);
        }
        
        if(!isset($_GET['signupas'])){
            redirect("/users/login");
        }
        $data["signupas"] = $_GET['signupas'];
        $data["pageTitle"]="WLC Sign Up";
        $this->load->view('signup',$data);
    }
    public function register()
    {
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('phoneno', 'Phone Number', 'trim|required');
        $this->form_validation->set_rules('building_name_no', 'Building Name/Number', 'trim|required');
        $this->form_validation->set_rules('street_name', 'Street Name', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('post_code', 'Post Code', 'trim|required');
        if($this->input->post('role') == "fleet"){
            $this->form_validation->set_rules('brnno', 'B.R.NO.', 'trim|required');
        }

        if ($this->form_validation->run() == FALSE)
        {
//            $this->session->set_flashdata('error',$this->form_validation->run());
//            redirect("/users/login");
        $data["signupas"] = $_GET['signupas'];
            $data["pageTitle"]="Sign Up";
            $this->load->view('signup',$data);
        }
        else
        {
            $this->UsersModel->user_signup();   
            $this->session->set_flashdata('success', 'Sucessfully updated.');
            redirect("/users/success"); 
        }
    }
    public function success()
    {
        if(!$this->session->flashdata('success')){
            redirect("/users/login"); 
        }
        $data["pageTitle"]="Sign Up Success";
        $this->load->view('success',$data);
    }
    public function logout()
    {
           $this->session->sess_destroy();
           redirect("/");
    }
    
    
    public function change_password()
    {
		$tabarray = array("admin_profile","booking_profile","profileupdate");
		$data["tabisarray"]="1";
		$data["activetab"]=$tabarray;
        $data["pageTitle"]="Change Password";
        $data["pageclass"] = "change_password";
        if($this->input->post("submit")){
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('confirm_password', 'Confirmation Password', 'trim|required|min_length[8]|matches[new_password]');

            if (!$this->form_validation->run() == FALSE)
            {
                $this->UsersModel->change_password();
            }
        }
            $this->loadView('users/changepassword',$data);
    }
    
    
    public function change_details()
    {
        $tabarray = array("admin_profile","booking_profile","profileupdate");
        $data["tabisarray"]="1";
        $data["activetab"]=$tabarray;
        $data["pageTitle"]="Change Details";
        $data["pageclass"] = "change_details";
        $userinfo = $this->UsersModel->getUserInfo();
        $data["userinfo"] = $userinfo;
        if($this->input->post("submit")){
            $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('phoneno', 'Phone Number', 'trim|required');
            $this->form_validation->set_rules('building_name_no', 'Building Name/Number', 'trim|required');
            $this->form_validation->set_rules('street_name', 'Street Name', 'trim|required');
            $this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('post_code', 'Post Code', 'trim|required');
            if($this->session->userdata('role') == "fleet"){
                $this->form_validation->set_rules('brnno', 'B.R.NO.', 'trim|required');
            }
            if (!$this->form_validation->run() == FALSE)
            {
                $this->UsersModel->change_details();
            }
        }
            $this->loadView('users/changedetails',$data);
    }
    
    public function activation($id=NULL)
    {
        
        if($id !=NULL){
           $res = $this->UsersModel->activateAccount($id);
           if($res["process"] == "success")
                $this->session->set_flashdata('success', 'Account is activated successfully. You can now login.');
           else
                $this->session->set_flashdata('error', 'Problem in activating account. Contact System Admin.');
           
           redirect("/users/login"); 
        }
    }
    
    public function forgot_password()
    {
         if ($this->session->userdata('is_login') == "true") {
            redirect("/");
        }
        $data["pageTitle"]="WLC Forgot Password";
        $this->load->view('forgot_password',$data);
    }
    
    public function sendresetlink()
    {
       $email = $this->input->post("email");
       $getRedirect = $this->UsersModel->sendresetlink($email); 
       $this->session->set_flashdata('success',('Reset Password link is send to your email address'));
       redirect("/users/forgot_password");
    }
    
    public function resetpassword($resetcode = NULL)
    {
        if ($this->session->userdata('is_login') == "true") {
                redirect("/");
            }
         
        if($resetcode != NULL){
            if($this->input->post()){
                $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]');
                $this->form_validation->set_rules('conf_password', 'Confirmation Password', 'trim|required|min_length[8]|matches[new_password]');

                if (!$this->form_validation->run() == FALSE)
                {
                    $this->UsersModel->passwordreset($resetcode);
                }
            }
            
            $checkreset = $this->UsersModel->checkreset($resetcode); 
            
            $data["pageTitle"]="WLC Reset Password";
            $data['resetcode'] = $resetcode;
            $this->load->view('reset_password',$data);
        }
        else{
            redirect("/");
        }
    }
    public function ignore_reset($resetcode = NULL)
    {
        $data= array(
            "password_reset_request" => 0,
            "reset_code" =>""
        );
        $this->db->where('reset_code',$resetcode);
        $this->db->update('users', $data); 
        
        $this->session->set_flashdata('success',('Password Reset is ignored'));
        redirect("/users/login");
    }
    
    public function passwordreset($resetcode)
    {
        if($resetcode != NULL){
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('confirm_password', 'Confirmation Password', 'trim|required|min_length[8]|matches[new_password]');

            if (!$this->form_validation->run() == FALSE)
            {
                $this->UsersModel->passwordreset($resetcode);
            }
            
        }
        else{
            redirect("/");
        }
    }
        
}
