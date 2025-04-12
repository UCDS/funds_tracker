<?php

class Instrument_type_model extends CI_Model {
    
    private $return_size = 300;
    private $instrument_type_information = array();
    function __construct() {
        parent::__construct();
        $post = (array)json_decode($this->security->xss_clean($this->input->raw_input_stream));
        if(key_exists('instrument_type', $post)){
            $this->instrument_type_information['instrument_type'] = $post['instrument_type'];
        }
        
        $this->instrument_type_information['insert_date_time'] = 'Time here';
        $this->instrument_type_information['user_id'] = 'User ID here';
    }
    
    function add_instrument_type(){
        $this->db->insert('instrument_type', $this->instrument_type_information);
        return $this->db->insert_id();
    }
    
    function update_instrument_type(){
        $instrument_type_id = -1;                  // Non existent transaction id.
        $backup_information = array();
        //Checking for the existance of key paramter needed for the update.
        //Also getting the old record to create a edit log.
        if(key_exists('instrument_type_id', $this->instrument_type_information)){
            $instrument_type_id = $this->instrument_type_information['instrument_type_id'];
            //Get the previous record.
            $this->db->select('*')
                    ->from('instrument_type')
                    ->where('instrument_type_id', $instrument_type_id);
            $query = $this->db->get();            
            $backup_information['trail'] = $query->result();            
            //Check for the existence of previous record.
            if(sizeof($backup_information) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }
            $backup_information['trail'] = jason_encode($backup_information['trail'][0]);
            $backup_information['table_name'] = 'instrument_type';
        }else{
            return -2;                          // Flag indicating that a key parameter for the where condition is not set. In this case the instrument_type_id.
        }
        
        $this->db->trans_start();
        $this->db->where('instrument_type', $this->instrument_type_information);
        $this->db->insert('edit_log', $backup_information);
        $this->db->trans_complete();
        
        if($this->db->trans_status === FALSE){
            return -1;          // Flag indicating that there was a database error.
        }else{
            $this->db->select('*')
                    ->from('bank_book')
                    ->where('instrument_type_id', $instrument_type_id);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }        
    }
    
    function get_instrument_type(){
        if(key_exists('instrument_type_id', $this->instrument_type_information)){
            $instrument_type_id = $post['instrument_type_id'];
            
            $this->db->select('*')
                    ->from('cheque_book')
                    ->where('instrument_type_id', $instrument_type_id);
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
                ->from('instrument_type')
 //               ->where($instrument_type_condition)
                ->limit("$this->return_size");
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }
}
