<?php

class Cheque_book_model extends CI_Model {
    
    private $return_size = 300;
    private $cheque_book_information = array();
    
    function __construct() {
        parent::__construct();
        $post = (array)json_decode($this->security->xss_clean($this->input->raw_input_stream));  
        if(key_exists('account_id', $post)){
            $this->cheque_book_information['account_id'] = $post['account_id'];
        }
        if(key_exists('cheque_book_number', $post)){
            $this->cheque_book_information['cheque_book_number'] = $post['cheque_book_number'];
        }
        if(key_exists('bank_id', $post)){
            $this->cheque_book_information['bank_id'] = $post['bank_id'];
        }
        if(key_exists('from_cheque', $post)){
            $this->cheque_book_information['from_cheque'] = $post['from_cheque'];
        }
        if(key_exists('to_cheque', $post)){
            $this->cheque_book_information['to_cheque'] = $post['to_cheque'];
        }
        $this->cheque_book_information['insert_date_time'] = 'Time here';
        $this->cheque_book_information['user_id'] = 'User ID here';        
    }
    
    function add_cheque_book(){        
        $this->db->insert('cheque_book', $this->cheque_book_information);        
        return $this->db->insert_id();
    }
    
    function update_cheque_book(){
        $cheque_book_id = -1;                  // Non existent transaction id.
        $this->backup_information = array();
        //Checking for the existance of key paramter needed for the update.
        //Also getting the old record to create a edit log.
        if(key_exists('cheque_book_id', $this->cheque_book_information)){
            $cheque_book_id = $this->cheque_book_information['cheque_book_id'];
            //Get the previous record.
            $this->db->select('*')
                    ->from('cheque_book')
                    ->where('cheque_book_id', $cheque_book_id);
            $query = $this->db->get();            
            $this->backup_information['trail'] = $query->result();            
            //Check for the existence of previous record.
            if(sizeof($this->backup_information) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }
            $this->backup_information['trail'] = jason_encode($this->backup_information['trail'][0]);
            $this->backup_information['table_name'] = 'cheque_book';
        }else{
            return -2;                          // Flag indicating that a key parameter for the where condition is not set. In this case the bank_account_id.
        }
                
        $this->db->trans_start();
        $this->db->where('cheque_book', $this->cheque_book_information);
        $this->db->insert('edit_log', $this->backup_information);
        $this->db->trans_complete();
        
        if($this->db->trans_status === FALSE){
            return -1;          // Flag indicating that there was a database error.
        }else{
            $this->db->select('*')
                    ->from('cheque_book')
                    ->where('cheque_book_id', $cheque_book_id);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }        
    }
    
    function get_cheque_books(){
        if(key_exists('cheque_book_id', $this->cheque_book_information)){
            $cheque_book_id = $this->cheque_book_information['cheque_book_id'];
            
            $this->db->select('*')
                    ->from('cheque_book')
                    ->where('cheque_book_id', $cheque_book_id);
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
                ->from('cheque_book')
     //           ->where('$this->cheque_book_information')
                ->limit("$this->return_size");
        $query = $this->db->get();
       
        $result = $query->result();
        return $result;
    }
}
