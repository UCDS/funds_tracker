<?php

class Party_model extends CI_Model {
    
    private $return_size = 300;
    private $party_information = array();    
    
    function __construct() {
        parent::__construct();
        $post = (array)json_decode($this->security->xss_clean($this->input->raw_input_stream));
        if(key_exists('party_name', $post)){
            $this->party_information['party_name'] = $post['party_name'];        
        }
        if(key_exists('party_type_id', $post)){
            $this->party_information['party_type_id'] = $post['party_type_id'];        
        }
        if(key_exists('gender', $post)){
            $this->party_information['gender'] = $post['gender'];        
        }
        if(key_exists('address', $post)){
            $this->party_information['address'] = $post['address'];        
        }
        if(key_exists('place', $post)){
            $this->party_information['place'] = $post['place'];        
        }
        if(key_exists('district_id', $post)){
            $this->party_information['district_id'] = $post['district_id'];        
        }
        if(key_exists('phone', $post)){
            $this->party_information['phone'] = $post['phone'];        
        }
        if(key_exists('email', $post)){
            $this->party_information['email'] = $post['email'];        
        }
        if(key_exists('alt_phone', $post)){
            $this->party_information['alt_phone'] = $post['alt_phone'];        
        }
        if(key_exists('note', $post)){
            $this->party_information['note'] = $post['note'];        
        }
        if(key_exists('party_id', $post)){
            $this->party_information['party_id'] = $post['party_id'];        
        }
        
        $this->party_information['insert_date_time'] = 'Time here';
        $this->party_information['user_id'] = 'User ID here';        
    }
    
    function add_party(){
       if(key_exists('party_id', $this->party_information)){
            $this->db->where('party_id',$this->party_information['party_id']);
            unset($this->party_information['party_id']);
            $this->db->update('party',$this->party_information);
            return true;
        }else{
            $this->db->insert('party', $this->party_information);
            return $this->db->insert_id();
        }
        
    }
    
    function update_party(){
        $party_id = -1;                  // Non existent transaction id.
        $backup_information = array();
        //Checking for the existance of key paramter needed for the update.
        //Also getting the old record to create a edit log.
        if(key_exists('party_id', $this->party_information)){
            $party_id = $this->party_information['party_id'];
            //Get the previous record.
            $this->db->select('*')
                    ->from('party')
                    ->where('party_id', $party_id);
            $query = $this->db->get();            
            $backup_information['trail'] = $query->result();            
            //Check for the existence of previous record.
            if(sizeof($backup_information) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }
            $backup_information['trail'] = jason_encode($backup_information['trail'][0]);
            $backup_information['table_name'] = 'party';
        }else{
            return -2;                          // Flag indicating that a key parameter for the where condition is not set. In this case the party_id.
        }
        
        $this->db->trans_start();
        $this->db->where('party', $this->party_information);
        $this->db->insert('edit_log', $backup_information);
        $this->db->trans_complete();
        
        if($this->db->trans_status === FALSE){
            return -1;          // Flag indicating that there was a database error.
        }else{
            $this->db->select('*')
                    ->from('bank_book')
                    ->where('party_id', $party_id);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }        
    }
    
    function get_party(){        
        if(key_exists('party_id', $this->party_information)){
            $party_id = $this->party_information;
            
            $this->db->select('*')
                    ->from('cheque_book')
                    ->where('party_id', $party_id);
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
            ->from('party')
			->order_by("party_name", "asc");
     //       ->where($this->party_information)
//            ->limit("$this->return_size");
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;        
    }
    
}
