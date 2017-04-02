<?php

class Project extends CI_Controller{
    function __construct() {
        parent::__construct();
        if($this->session->logged_in != 'YES'){
            redirect(base_url()+"/");
        }
        $this->load->model('project_model');       
    }
    
    function index(){
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $this->load->view('pages/project_pages/add_project');
        $this->load->view('nav_bars/footer');
    }
    
    function add_project(){        
        $project_id = $this->project_model->add_project();
        echo json_encode($project_id);
    }
    
    function get_projects(){        
        $projects_information = $this->project_model->get_projects();
        echo json_encode($projects_information);
    }
    
    function get_project_groups(){
        $project_groups = $this->project_model->get_project_groups();
        echo json_encode($project_groups);
    }
}

?>