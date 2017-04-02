<?php

class Bank_model extends CI_Model {

    private $return_size = 300;
    
    function __construct() {
        parent::__construct();
    }
    
    function add_bank(){
        $post = (array)json_decode($this->security->xss_clean($this->input->raw_input_stream));
        $bank_information = array();
        if(key_exists('bank_id',$post)){
            $bank_information['bank_id'] = $post['bank_id'];
        }
        if(key_exists('bank_name',$post)){
            $bank_information['bank_name'] = $post['bank_name'];
        }
        if(key_exists('note', $post)){
            $bank_information['note'] = $post['note'];
        }
        
        $bank_information['insert_date_time'] = 'Time here';
        $bank_information['user_id'] = 'User ID here';
        
        $this->db->insert('bank', $bank_information);        
        return $this->db->insert_id();
    }
    
    function get_all_banks(){
    	$this->db->select('bank.*')
        	->from('bank');
    	$query = $this->db->get();
	$result = $query->result();
        return $result;
    }
	
    function get_banks(){
        $post = (array)json_decode($this->security->xss_clean($this->input->raw_input_stream));
        $bank_filters = array();
        $bank_id = key_exists('bank_id', $post) ? $post['bank_id'] : ($this->input->post('bank_id') ? $this->input->post('bank_id') : -1);
	if($bank_id != -1){
            $this->db->select('bank.*')
                    ->from('bank')                    
                    ->where('bank_id', $bank_id);
            $query = $this->db->get();
            $result = $query->result();
            //Check for the existence of record.
            if(sizeof($result) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }else{
                return $result;
            }            
        }
        
        $bank_condition = array();
        if(key_exists('bank_name', $post)){
            $bank_condition['bank_name'] = $post['bank_name'];
        }
        if(key_exists('bank_group_id', $post)){
            $bank_condition['bank_group_id'] = $post['bank_group_id'];
        }
        if(key_exists('note', $post)){
            $bank_condition['note'] = $post['note'];
        }
        
        $this->db->select('*')
                ->from('bank')
        //       ->join('bank_group','bank_group.bank_group_id = bank.bank_group_id')
                ->where($bank_condition)
                ->limit("$this->return_size");
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }
    
}
