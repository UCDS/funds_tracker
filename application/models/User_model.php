<?php


class User_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    function login(){
//        $post = (array)json_decode($this->security->xss_clean($this->input->raw_input_stream));
        $user_information = array();
        if($this->input->post('user_name') && $this->input->post('password')){
            $user_information['user_name'] = $this->input->post('user_name');
            $user_information['password'] = md5($this->input->post('password'));
        }else{
            return FALSE;
        }
        $this->db->select('*')
                ->from('user')
                ->where('user_name', $user_information['user_name'])
                ->where('password', $user_information['password']);
        $query = $this->db->get();
        
        $result = $query->result_object();
        return $result;
    }
	
	function validatePassword($userID, $pwd){
        $this->db->select('*')
                ->from('user')
                ->where('user_id', $userID)
                ->where('password', md5($pwd));
        $query = $this->db->get();
        
        $result = $query->result_object();
		if(sizeof($result) > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function updatePassword($userID, $pwd){
		$data["password"] = md5($pwd);
		$this->db->where('user_id',$userID);
		return $this->db->update('user',$data);
	}
			
    function get_user_functions(){
        return false;
    }
}
