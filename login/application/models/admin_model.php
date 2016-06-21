<?php
class Admin_model extends CI_Model {

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
        
        public function account2($current_pwd,$pwd){
                $current_pwd = md5($current_pwd);
                $data= array(
                    'password'=>md5($pwd)
                );
                $this->db->update('admin',$data,array('password'=>$current_pwd));
                return $this->db->affected_rows();
        }
        
        public function get_by_hash($hash){
                $query = $this->db->get_where('admin',array('password'=>$hash));
                return $query->row_array();
        }
            
        public function get_hashcode(){
                $query = $this->db->get_where('admin',array('email'=>$this->input->post('email')));
                return $query->row_array();
        }
        
        public function chg_password($admin_id,$pwd){
                $data= array(
                    'password'=>md5($pwd)
                );
                $this->db->update('admin',$data,array('admin_id'=>$admin_id));
                return $this->db->affected_rows();
        }
        
        public function accounts(){
            $query = $this->db->get('admin');
            return $query->result_array();
        }
        
        public function account($id){
            $query = $this->db->get_where('admin',array('admin_id'=>$id));
            return $query->row_array();
        }
        
        public function get_userinfo($username){
            $query = $this->db->get_where('admin',array('admin'=>$username));
            return $query->row_array();
        }

        public function add(){
              $data = array(
                    'admin' => $this->input->post('admin'),
                    'email' => $this->input->post('email'),
                    'password' =>  md5($this->input->post('password')),
                    'date_added' => date('Y-m-d H:i:s'),
                    'status' => $this->input->post('status'),
               );
               return $this->db->insert('admin', $data);
        }
        
        public function update($id){
            
               $data = array(
                    'admin' => $this->input->post('admin'),
                    'email' => $this->input->post('email'),
                    'date_modified' => date('Y-m-d H:i:s'),
                    'status' => $this->input->post('status'),
               );
               return $this->db->update('admin', $data,array('admin_id'=>$id));
        }
        
        public function delete($id){
               return $this->db->delete('admin', array('admin_id'=>$id));
        }

}