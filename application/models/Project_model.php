<?php

class Project_model extends CI_Model {
    
    private $return_size = 300;
    
    function __construct() {
        parent::__construct();
    }
    
    function add_project(){     
        $post = (array)json_decode($this->security->xss_clean($this->input->raw_input_stream));
        $project_information = array();
        if(key_exists('project_name',$post)){
            $project_information['project_name'] = $post['project_name'];
        }
        /*if(key_exists('project_group_id',$post)){
            $project_information['project_group_id'] = $post['project_group_id'];
        }*/
        if($this->input->post('note')){
            $project_information['note'] = $this->input->post('note');
        }
        
        $project_information['insert_date_time'] = 'Time here';
        $project_information['user_id'] = 'User ID here';
        
        $this->db->insert('project', $project_information);        
        return $this->db->insert_id();        
    }
    
    function update_project(){
        $project_id = -1;                  // Non existent transaction id.
        $backup_information = array();
        //Checking for the existance of key paramter needed for the update.
        //Also getting the old record to create a edit log.
        if($this->input->post('project_id')){
            $project_id = $this->input->post('project_id');
            //Get the previous record.
            $this->db->select('*')
                    ->from('project')
                    ->where('project_id', $project_id);
            $query = $this->db->get();            
            $backup_information['trail'] = $query->result();            
            //Check for the existence of previous record.
            if(sizeof($backup_information) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }
            $backup_information['trail'] = jason_encode($backup_information['trail'][0]);
            $backup_information['table_name'] = 'project';
        }else{
            return -2;                          // Flag indicating that a key parameter for the where condition is not set. In this case the project_id.
        }
        
        $project_information = array();
        if($this->input->post('project_name')){
            $project_information['project_name'] = $this->input->post('project_name');
        }
        /*if($this->input->post('project_group_id')){
            $project_information['project_group_id'] = $this->input->post('project_group_id');
        }*/
        if($this->input->post('note')){
            $project_information['note'] = $this->input->post('note');
        }        
        
        $project_information['user_id'] = 'User ID here';
        
        $this->db->trans_start();
        $this->db->where('project', $project_information);
        $this->db->insert('edit_log', $backup_information);
        $this->db->trans_complete();
        
        if($this->db->trans_status === FALSE){
            return -1;          // Flag indicating that there was a database error.
        }else{
            $this->db->select('*')
                    ->from('project')
                    ->where('project_id', $project_id);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }        
    }
    
    function get_project(){
        if($this->input->post('project_id')){
            $project_id = $this->input->post('project_id');
            
            $this->db->select('project.*, project_group.project_group_name')
                    ->from('project')                    
                    //->join('project_group','project_group.project_group_id = project.project_group_id')                
                    ->where('project_id', $project_id);
            $query = $this->db->get();            
            $result = $query->result();            
            //Check for the existence of record.
            if(sizeof($result) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }else{
                return $result;
            }            
        }
        
        $project_condition = array();
        if($this->input->post('project_name')){
            $project_condition['project_name'] = $this->input->post('project_name');
        }
        /*if($this->input->post('project_group_id')){
            $project_condition['project_group_id'] = $this->input->post('project_group_id');
        }*/
        if($this->input->post('note')){
            $project_condition['note'] = $this->input->post('note');
        }
        
        $this->db->select('*')
                ->from('project')
                //->join('project_group','project_group.project_group_id = project.project_group_id','left')
                ->where($project_condition)
                ->limit("$this->return_size");
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;        
    }
    
    function get_projects(){        
        $this->db->select('*')
                ->from('project')
                //->join('project_group','project_group.project_group_id = project.project_group_id','left')
                ->limit("$this->return_size");
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;        
    }
    
    function get_project_groups(){
        $this->db->select('*')
                ->from('project_group')
        //        ->where($project_condition)
                ->limit("$this->return_size");
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;  
    }
    
}
