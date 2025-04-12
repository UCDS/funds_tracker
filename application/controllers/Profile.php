<?php
/*
* Added By : Pranay
* Date : 2017-05-20
*/
class Profile extends CI_Controller{
    function __construct() {
        parent::__construct();
        if($this->session->logged_in != 'YES'){
            redirect(base_url()+"/");
        }
        $this->load->model('user_model');

    }

    function index(){
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
		/**
		* As of now no other module are there for profile. showimg changepassword for index
		* Data : 2015-05-20
		* By : Pranay
		*/
        $this->load->view('pages/profile/change_password');
        $this->load->view('nav_bars/footer');
    }
    
    function changepassword(){        
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $this->load->view('pages/profile/change_password');
        $this->load->view('nav_bars/footer');
    }

	function updatepassword(){
		if($this->session->logged_in != 'YES'){
            $ResultData["Status"] = 1001;
            $ResultData["ErroMsg"] = "Please login to update password";
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($ResultData));
        }        
        else{
			if(! $this->input->post('old_password')){
				$ResultData["ErroMsg"] = "old password shoudn't be empty";
			}
			else if(! $this->input->post('password')){
				$ResultData["ErroMsg"] = "new password shoudn't be empty";
			}
			else if($this->input->post('password') != $this->input->post('confirm_password')){
				$ResultData["ErroMsg"] = "new password and confirm password shoud match";
			}
			else{
				if($this->user_model->validatePassword($this->session->userdata["user_id"], $this->input->post('old_password')) == false){
					$ResultData["ErroMsg"] = "Invalid old password";
				}else{
					if($this->user_model->updatePassword($this->session->userdata["user_id"], $this->input->post('password'))){
						$ResultData["Status"] = "1";
					}else{
						$ResultData["ErroMsg"] = "Something went wrong";
					}
				}
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($ResultData));
		}
	}

    function get_projects(){        
        $projects_information = $this->project_model->get_projects();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($projects_information));
    }
    
    function get_project_groups(){
        $project_groups = $this->project_model->get_project_groups();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($project_groups));
    }
}

?>