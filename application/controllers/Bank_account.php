<?php

class Bank_account extends CI_Controller {
    function __construct() {
        parent::__construct();
        
        $this->load->model('bank_account_model');
    }
    
    function index(){
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $this->load->view('pages/bank_pages/bank_account');
        $this->load->view('nav_bars/footer');
    }
    
    function add_bank_account(){
	$ResultData = array();
	if($this->session->logged_in != 'YES'){
            $ResultData["Status"] = 1001;
            $ResultData["ErroMsg"] = "Please login to access this data";
			echo json_encode($ResultData);
        }else{
			$bank_account_id = $this->bank_account_model->add_bank_account();
			echo json_encode($bank_account_id);
		}
    }
    
    function get_bank_accounts(){
        $bank_accounts_information = $this->bank_account_model->get_bank_accounts();
        echo json_encode($bank_accounts_information);
    }
    
    function search_bank_accounts(){
        $bank_accounts_information = $this->bank_account_model->search_bank_accounts();
        echo json_encode($bank_accounts_information);
    }

    function get_bank_book_accounts(){
        $bank_accounts_information = $this->bank_account_model->get_bank_book_accounts_details();
        echo json_encode($bank_accounts_information);
    }

    function bank_book_summary(){
        $this->load->helper('form');
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $this->load->view('pages/bank_pages/bank_accounts_template');
        $this->load->view('nav_bars/footer');
    }
}
