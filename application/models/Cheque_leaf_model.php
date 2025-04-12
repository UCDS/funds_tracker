<?php


class Cheque_leaf_model extends CI_Model {
    
    private $return_size = 300;
    private $cheque_leaf_information = array();    
    
    function __construct() {
        parent::__construct();
        $post = (array)json_decode($this->security->xss_clean($this->input->raw_input_stream)); 
        if(key_exists('cheque_book_id', $post)){
            $this->cheque_leaf_information['cheque_book_id'] = $post['cheque_book_id'];
        }
        if(key_exists('cheque_leaf_id', $post)){
            $this->cheque_leaf_information['cheque_leaf_id'] = $post['cheque_leaf_id'];
        }
        if(key_exists('cheque_leaf_number', $post)){
            $this->cheque_leaf_information['cheque_leaf_number'] = $post['cheque_leaf_number'];
        }
        if(key_exists('clearance_status', $post)){
            $this->cheque_leaf_information['clearance_status'] = $post['clearance_status'];
        }
        $this->cheque_leaf_information['insert_date_time'] = 'Time here';
        $this->cheque_leaf_information['user_id'] = 'User ID here';        
    }
    
    function add_cheque_leaf(){
        $this->db->insert('cheque_leaf', $this->cheque_leaf_information);        
        return $this->db->insert_id();        
    }
    
    function update_cheque_leaf(){
        $cheque_leaf_id = -1;                  // Non existent transaction id.
        $backup_information = array();
        //Checking for the existance of key paramter needed for the update.
        //Also getting the old record to create a edit log.
        if(key_exists('cheque_leaf_id', $this->cheque_leaf_information)){
            $cheque_leaf_id = $this->cheque_leaf_information['cheque_leaf_id'];
            //Get the previous record.
            $this->db->select('*')
                    ->from('cheque_leaf')
                    ->where('cheque_leaf_id', $cheque_leaf_id);
            $query = $this->db->get();            
            $backup_information['trail'] = $query->result();            
            //Check for the existence of previous record.
            if(sizeof($backup_information) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }
            $backup_information['trail'] = jason_encode($backup_information['trail'][0]);
            $backup_information['table_name'] = 'cheque_leaf';
        }else{
            return -2;                          // Flag indicating that a key parameter for the where condition is not set. In this case the cheque_leaf_id.
        }
        
        $this->db->trans_start();
        $this->db->where('cheque_leaf', $this->cheque_leaf_information);
        $this->db->insert('edit_log', $backup_information);
        $this->db->trans_complete();
        
        if($this->db->trans_status === FALSE){
            return -1;          // Flag indicating that there was a database error.
        }else{
            $this->db->select('*')
                    ->from('cheque_leaf')
                    ->where('cheque_leaf_id', $cheque_leaf_id);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }        
    }
    
    function get_cheque_leaves(){
        if(key_exists('cheque_leaf_id', $this->cheque_leaf_information)){
            $cheque_leaf_id = $this->cheque_leaf_information['cheque_leaf_id'];
            
            $this->db->select('*')
                    ->from('cheque_book')
                    ->where('cheque_leaf_id', $cheque_leaf_id);
            $query = $this->db->get();            
            $result = $query->result();            
            //Check for the existence of record.
            if(sizeof($result) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }else{
                return $result;
            }            
        }
        
        $this->db->select('*')
                ->from('cheque_leaf')
       //         ->where($this->cheque_leaf_information)
                ->limit("$this->return_size");
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }
    
}
