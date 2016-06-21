<?php
class Pages_model extends CI_Model {

	function __construct(){
        parent::__construct();
        $this->load->database();
    }
        public function get_pages($page_id)
        {
             if ($page_id === FALSE)
                {
                        $query = $this->db->get('pages');
                        return $query->result_array();
                }

                $query = $this->db->get_where('pages', array('page_id' => $page_id));
                return $query->row_array();
        }
        
        public function make()
        {
                        $query = $this->db->get('make');
                        return $query->result_array();
             
        }
        

        public function add_page(){
                $data = array(
                        'title' => $this->input->post('title'),
                        'content' => $this->input->post('text'),
                        'meta-title' => $this->input->post('meta_title'),
                        'meta-keyword' => $this->input->post('meta_keyword'),
                        'meta-description' => $this->input->post('meta_description'),
                        'creation_time' => date('Y-m-d H:i:s'),
                        'update_time' => date('Y-m-d H:i:s'),
                        'is_active' => TRUE
                );
                return $this->db->insert('pages', $data);
        }
        public function get2($page_id=false){
        if($page_id){
            $query = $this->db->get_where('pages',array('page_id'=>$page_id));
            return $query->row_array();
        }else{
            $query = $this->db->get('pages');
            return $query->result_array();
        }
    }
        public function edit_page(){
                $data = array(
                        'title' => $this->input->post('title'),
                        'content' => $this->input->post('text'),
                        'meta-title' => $this->input->post('meta_title'),
                        'meta-keyword' => $this->input->post('meta_keyword'),
                        'meta-description' => $this->input->post('meta_description'),
                        'update_time' => date('Y-m-d H:i:s'),
                        'is_active' => TRUE
                );
                return $this->db->update('pages', $data, array('page_id' => $this->input->post('page_id')));
        }
        public function delete_page($page_id){
                return $this->db->delete('pages', array('page_id' => $page_id));
        }
}