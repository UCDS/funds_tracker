<?php


class Instrument_type extends CI_Controller{

    function __construct(){
        parent::__construct();        
        if($this->session->logged_in != 'YES'){
            redirect(base_url()+"/");
        }
        $this->load->model('instrument_type_model');        
    }
    
    function index(){
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $this->load->view('pages/bank_pages/instrument_type');
        $this->load->view('nav_bars/footer');
    }
    
    function add_instrument_type(){
        $instrument_type_id = $this->instrument_type_model->add_instrument_type();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($instrument_type_id));
    }
    
    function get_instrument_type(){
        $instrument_type_information = $this->instrument_type_model->get_instrument_type();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($instrument_type_information));
    }
    
}
