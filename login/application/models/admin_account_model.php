<?php
class Admin_account_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
               // $this->load->library('encrypt');
        }
        
        public function authorize($user,$pass){
               // $pass = $this->encrypt->encode($pass);
                $pass = md5($pass);
                $query = $this->db->get_where('admin',array('admin'=>$user,'password'=>$pass));
                if($query->num_rows == 1) return true;
        }
        
        public function chg_password($current_pwd,$pwd){
                $current_pwd = md5($current_pwd);
                $data= array(
                    'password'=>md5($pwd)
                );
                $this->db->update('admin',$data,array('password'=>$current_pwd));
                return $this->db->affected_rows();
        }
        
        public function emailPass($email){
            
        }
}