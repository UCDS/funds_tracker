<?php

class Project_overdraft extends CI_Model {
    
    private $return_size = 300;
    
    function __construct() {
        parent::__construct();
    }
    
    function add_project_overdraft(){        
        $overdraft_infromation = array();
        
        if($this->input->post('transaction_id')){
            $overdraft_infromation['transaction_id'] = $this->input->post('transaction_id');
        }
        if($this->input->post('overdraft_project_id')){
            $overdraft_infromation['overdraft_project_id'] = $this->input->post('overdraft_project_id');
        }
        
        $overdraft_infromation['insert_date_time'] = 'Time here';
        $overdraft_infromation['user_id'] = 'User ID here';
        
        $this->db->insert('project', $overdraft_infromation);
        
        return $this->db->insert_id();        
    }
    
    function update_project_overdraft(){
        $overdraft_id = -1;                  // Non existent transaction id.
        $backup_information = array();
        //Checking for the existance of key paramter needed for the update.
        //Also getting the old record to create a edit log.
        if($this->input->post('overdraft_id')){
            $overdraft_id = $this->input->post('overdraft_id');
            //Get the previous record.
            $this->db->select('*')
                    ->from('overdraft')
                    ->where('overdraft_id', $overdraft_id);
            $query = $this->db->get();            
            $backup_information['trail'] = $query->result();            
            //Check for the existence of previous record.
            if(sizeof($backup_information) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }
            $backup_information['trail'] = jason_encode($backup_information['trail'][0]);
            $backup_information['table_name'] = 'overdraft';
        }else{
            return -2;                          // Flag indicating that a key parameter for the where condition is not set. In this case the overdraft_id.
        }
        
        $overdraft_infromation = array();        
        if($this->input->post('transaction_id')){
            $overdraft_infromation['transaction_id'] = $this->input->post('transaction_id');
        }
        if($this->input->post('overdraft_project_id')){
            $overdraft_infromation['overdraft_project_id'] = $this->input->post('overdraft_project_id');
        }        
        
        $overdraft_infromation['user_id'] = 'User ID here';
        
        $this->db->trans_start();
        $this->db->where('project_overdraft', $overdraft_information);
        $this->db->insert('edit_log', $backup_information);
        $this->db->trans_complete();
        
        if($this->db->trans_status === FALSE){
            return -1;          // Flag indicating that there was a database error.
        }else{
            $this->db->select('*')
                    ->from('project_overdraft')
                    ->where('overdraft_id', $overdraft_id);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }        
    }
    
    function get_project_overdraft(){
        
        if($this->input->post('overdraft_id')){
            $overdraft_id = $this->input->post('overdraft_id');
            
            $this->db->select('*')
                    ->from('overdraft_id')
                    ->where('overdraft_id', $overdraft_id);
            $query = $this->db->get();            
            $result = $query->result();            
            //Check for the existence of record.
            if(sizeof($result) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }else{
                return $result;
            }            
        }
        
        $overdraft_condition = array();        
        if($this->input->post('transaction_id')){
            $overdraft_condition['transaction_id'] = $this->input->post('transaction_id');
        }
        if($this->input->post('overdraft_project_id')){
            $overdraft_condition['overdraft_project_id'] = $this->input->post('overdraft_project_id');
        }
        
        $this->db->select('*')
                ->from('project_overdraft')
                ->where($overdraft_condition)
                ->limit("$this->return_size");
        $query = $this->db->get();
        
        $result = $query->result();
        return $result; 
    }
}
