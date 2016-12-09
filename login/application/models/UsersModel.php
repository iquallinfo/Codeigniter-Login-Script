<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class UsersModel extends CI_Model{
        var $userid;
	function __construct() {
            parent::__construct();
            $this->userid = $this->session->userdata("id");
	}

        public function loginUser($data) {
            
            $query = $this->db->get_where('users',array('email'=>$data['email']));
            $result = $query->row_array();
            $salt = $result['salt'];
            $pass_from_db = $result['password'];
            $pass_from_user = sha1($salt . $data['password']);
            
           if ($pass_from_db==$pass_from_user )
           {
			   
			   if($result['is_verified'] != 0)
			   {
				 
                             if($result['status'] != 0)
			       { 
                                 $this->session->set_userdata($result);
                                  $this->session->set_userdata("userrole",$result["role"]);
                                  $this->session->set_userdata("is_login","true");
                                  redirect("/".$userRecords["role"]);
			      }
                             else
                              {
                                   $this->session->set_flashdata('error',('Your Account is Disable Please Contact Admin'));
				   redirect("/users/login");


                              }
                           }
			   else
			   {
                                  $this->session->set_flashdata('error',('Please Activate your Account'));
				   redirect("/users/login");
			   }
           }
           else
           {
               $this->session->set_flashdata('error',('Invalid Email or Password'));
               redirect("/users/login");
           }
	}
        
        public function user_signup(){
            $salt = substr(md5(uniqid(rand(), true)), 0, 9);
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
            $password = substr( str_shuffle( $chars ), 0,8 );
            $chars2 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $activationcode= substr( str_shuffle( $chars2 ), 0,15 );
            $default_password = sha1($salt . $password);
            $data = array(
                'salt' => $salt,
                'password' => $default_password,
                'company_name' => $this->input->post('company_name'),
                'brnno' => $this->input->post('brnno'),
                'phoneno' => $this->input->post('phoneno'),
                'email' => $this->input->post('email'),
                'building_name_no' => $this->input->post('building_name_no'),
                'street_name' => $this->input->post('street_name'),
                'country' => $this->input->post('country'),
                'post_code' => $this->input->post('post_code'),
                'role' => $this->input->post('role'),
                'status'=> 0,
                'is_verified'=> 0,
                'activationcode'=>$activationcode,
                'image'=>"",
            );
            $this->db->insert('users',$data);
            $userid = $this->db->insert_id();
            if($userid != NULL){
                
                $query = $this->db->get_where('users',array('id'=>$userid));
                $result = $query->row_array();
                $result["default_password"] = $password;
                $config=array(
                'charset'=>'utf-8',
                'wordwrap'=> TRUE,
                'mailtype' => 'html'
                );

                $this->email->initialize($config);
                $message = $this->load->view("email/verification_mail",$result, true);
                $this->email->from('info@wlc.com', 'WLC Facilitate Services');
                $this->email->to( $this->input->post('email'));

                $this->email->subject('WLC Activation Mail');
                $this->email->message($message);
                
                $this->email->send();
                    
                
            }
            
            $data = array(
                'userid' => $userid,
                'password' => $password,
                'salt' =>$salt,
            );
            $this->db->insert('automatic_password',$data);
            
        }
        
        public function change_password(){
            $old_password = $this->input->post("old_password");
           
            $query = $this->db->get_where('users',array('id'=>$this->userid));
            $result = $query->row_array();
            $salt = $result['salt'];
            $pass_from_db = $result['password'];
            $pass_from_user = sha1($salt . $old_password);
            
            if($pass_from_db == $pass_from_user)
            {
                $salt = substr(md5(uniqid(rand(), true)), 0, 9);
                $password = $this->input->post("new_password");
                
                $data= array(
                    "salt"     =>$salt,
                    "password" => sha1($salt . $password),
                );
                
                $this->db->where('id', $this->userid);
                $this->db->update('users', $data); 
                
                $this->session->set_flashdata('success',('Password is changed successfully'));
                redirect("/users/change_password");
            }
            else
            {
                $this->session->set_flashdata('error',('Invalid Old Password'));
                redirect("/users/change_password");
            }

        }
        public function getUserInfo() {
            $query = $this->db->get_where('users',array('id'=>$this->userid));
            $result = $query->row_array();
            
            return $result;
        }
        
        public function change_details(){
            
               $data = array(
                    'company_name' => $this->input->post('company_name'),
                    'brnno' => $this->input->post('brnno'),
                    'phoneno' => $this->input->post('phoneno'),
                    'building_name_no' => $this->input->post('building_name_no'),
                    'street_name' => $this->input->post('street_name'),
                    'country' => $this->input->post('country'),
                    'post_code' => $this->input->post('post_code'),
                );
                
                $this->db->where('id', $this->userid);
                $this->db->update('users', $data); 
                
                $this->session->set_flashdata('success',('Details is updated successfully'));
                redirect("/users/change_details");
           
        }
        public function activateAccount($activationcode){
           $query = $this->db->get_where('users',array('activationcode'=>$activationcode,'is_verified' => '0'));
           $result = $query->row_array(); 
           if($query->num_rows() > 0){    
               $data = array(
                    'status' =>'1',
                    'is_verified' =>'1',
                );
                
                $this->db->where('activationcode', $activationcode);
                $this->db->update('users', $data); 
                $data["process"]="success";
                return $data;
           }
           else{
               $data["process"]="fail";
                return $data;
           }
        }
        
        public function sendresetlink($email) {
            
            $query = $this->db->get_where('users',array('email'=>$email));
            $result = $query->row_array();
           
            
           if ($query->num_rows() > 0 )
           {
               
                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                $resetcode= substr( str_shuffle( $chars ), 0,15 );
                
                $data = array(
                    'password_reset_request' =>'1',
                    'reset_code' =>$resetcode,
                );
                $this->db->where('id', $result["id"]);
                $this->db->update('users', $data); 
                    
                
                $query = $this->db->get_where('users',array('email'=>$email));
                $result = $query->row_array();
        
                $config['charset'] = "utf-8";
                $config['mailtype'] = "html";
                $config['newline'] = "\r\n";

                $this->email->initialize($config);
                $message = $this->load->view("email/reset_password_mail",$result, true);
                $this->email->from('info@wlc.com', 'WLC Facilitate Services');
                $this->email->to( $this->input->post('email'));

                $this->email->subject('WLC Password Reset');
                $this->email->message($message);
                
                $this->email->send();
           }
           else
           {
               $this->session->set_flashdata('error',('Invalid Email. Do not Match with system records.'));
               redirect("/users/forgot_password");
           }
	}
        public function checkreset($resetcode) {
            
            $query = $this->db->get_where('users',array('reset_code'=>$resetcode,"password_reset_request"=>1));
            $result = $query->row_array();
            
            if($query->num_rows() <= 0){
                 $this->session->set_flashdata('error',('Not Allowed to reset'));
                redirect("/users/login");
            }
        }
        
	public function passwordreset($resetcode){

                $salt = substr(md5(uniqid(rand(), true)), 0, 9);
                $password = $this->input->post("new_password");
                
                $data= array(
                    "salt"     =>$salt,
                    "password" => sha1($salt . $password),
                    "password_reset_request" => 2,
                );
                $this->db->where('reset_code',$resetcode);
                $this->db->update('users', $data); 
                
                $this->session->set_flashdata('success',('Password is changed successfully'));
                redirect("/users/login");
            

        }
        
        
	
        
        
}
?>