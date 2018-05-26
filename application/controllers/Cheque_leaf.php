<?php

class Cheque_leaf extends CI_Controller {
    function __construct() {
        parent::__construct();        
        if($this->session->logged_in != 'YES'){
            redirect(base_url()+"/");
        }
        $this->load->model('cheque_leaf_model');
    }
    
    function index(){        
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $this->load->view('pages/bank_pages/cheque_leaf');
        $this->load->view('nav_bars/footer');
    }
    
    function add_cheque_leaf(){
        $cheque_leaf_id = $this->cheque_leaf_model->add_cheque_leaf();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($cheque_leaf_id));
    }
    
    function get_cheque_leaves(){
        $cheque_leaves_information = $this->cheque_leaf_model->get_cheque_leaves();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($cheque_leaves_information));
    }
}

?>