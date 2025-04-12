<?php

class Cheque_book extends CI_Controller{    
    function __construct() {
        parent::__construct();   
        if($this->session->logged_in != 'YES'){
            redirect(base_url()+"/");
        }
        $this->load->model('cheque_book_model');
	$this->load->model('bank_account_model');
    }
    
    function index(){
	$this->data['bankaccounts'] = $this->bank_account_model->get_bank_accounts();
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $this->load->view('pages/bank_pages/cheque_book');
        $this->load->view('nav_bars/footer');
    }
    
    function add_cheque_book(){
        $cheque_book_id = $this->cheque_book_model->add_cheque_book();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($cheque_book_id));
    }
    
    function get_cheque_books(){
        $cheque_books_information = $this->cheque_book_model->get_cheque_books();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($cheque_books_information));
    }
}


?>