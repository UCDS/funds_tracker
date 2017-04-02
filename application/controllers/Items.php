<?php

class Items extends CI_Controller {    
    function __construct(){
        parent::__construct();        
        $this->load->model('generic_model');        
    }
    
    function index(){
        //if($this->session->logged_in != 'YES'){
            redirect(base_url()+"/");   
        //}        
        //$this->load->view('nav_bars/header');
        //$this->load->view('nav_bars/left_nav');
        //$this->load->view('pages/party_pages/party');
        //$this->load->view('nav_bars/footer');
    }
	
    function getItemsList(){
        if($this->session->logged_in != 'YES'){
            $ResultData["Status"] = 1001;
            $ResultData["ErroMsg"] = "Please login to access this data";
			echo json_encode($ResultData);
        }        
        else{
			$items = $this->generic_model->get_items_list();
			echo json_encode($items);
		}
    }
}
?>
