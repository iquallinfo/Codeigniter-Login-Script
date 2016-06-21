<?php

class User extends CI_Controller {
        public function __construct()
	{
           parent::__construct();
            $this->load->library('session');
            $this->load->helper('url');
            $user= $this->session->userdata('user');
          
            if($user!='admin'){
                redirect('login', 'refresh');
            }
        }

        public function index($page_id= FALSE){
            $data['title'] = 'Admin';
            $data['msg'] = $this->session->userdata('msg');
            $this->session->unset_userdata('msg');
            $this->load->view('common/header.tpl',$data);
            $this->load->view('index.tpl',$data);
            $this->load->view('common/footer.tpl',$data);
        }

        

}
