<?php

class Account extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->load->library('session');
            $this->load->helper('url');
            $this->load->model('admin_model');
        }
        
        public function login(){
            $this->load->helper('form');
            $this->load->library('form_validation');
            $data['title'] = 'login';
            $this->form_validation->set_rules('username', 'password', 'required');
            $this->form_validation->set_rules('password', 'username', 'required');
            if ($this->form_validation->run() === FALSE)
            {
                    $data['title'] = 'Login';
                    $data['msg'] = $this->session->userdata('msg');
                    $this->session->unset_userdata('msg');
                    $this->load->view('pages/login.tpl',$data);
            }
            else
            {
                    $is_valid= $this->admin_model->authorize($this->input->post('username'),$this->input->post('password'));
                    

                     if($is_valid){
                        $this->session->set_userdata('user', 'admin');
                        $this->session->set_userdata('username', $this->input->post('username'));
                        redirect('/');
                    }else{
                        $this->session->set_userdata('msg','Wrong Username or password!');
                        redirect('/login/');
                    }
            }
        }
        
         public function logout(){
            //$this->session->sess_destroy();
            $this->session->unset_userdata('user');
            $this->session->unset_userdata('username');
            redirect('/login/', 'refresh');
        }
        
        public function reset($hash){
            
            $user = $this->admin_model->get_by_hash($hash);
            $this->session->set_userdata('msg','Please, change your password!');
            $this->session->set_userdata('user', 'admin');
            $this->session->set_userdata('username', $user['admin']);
            redirect('/admin/my_account');
        }

        
}
