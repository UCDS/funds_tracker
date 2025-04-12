<?php

class Party extends CI_Controller {    
    function __construct(){
        parent::__construct();        
        $this->load->model('party_model');        
    }
    
    function index(){
        if($this->session->logged_in != 'YES'){
            redirect(base_url()+"/");   
        }        
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $this->load->view('pages/party_pages/party');
        $this->load->view('nav_bars/footer');
    }
    
    function add_party(){      
        if($this->session->logged_in != 'YES'){
            $ResultData["Status"] = 1001;
            $ResultData["ErroMsg"] = "Please login to access this data";
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($ResultData));
        }        
        else{
		$party_id = $this->party_model->add_party();
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($party_id));
	}
    }
    
    function get_party(){        
        $party_information = $this->party_model->get_party();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($party_information));
    }
}

?>
