<?php

class Bank_book extends CI_Controller {
    function __construct() {        
        parent::__construct();
        $this->load->model('bank_book_model');
        $this->load->model('bank_model');
        $this->load->model('project_model');
        $this->load->model('cheque_leaf_model');
        $this->load->model('instrument_type_model');
        $this->load->model('party_model');
    }
    
    function index(){ 
	$this->load->helper('form');
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');        
        $this->data['parties'] = $this->party_model->get_party();
        $this->data['instrument_types'] = $this->instrument_type_model->get_instrument_type();
        $this->data['cheque_leaves'] = $this->cheque_leaf_model->get_cheque_leaves();
        $this->data['projects'] = $this->project_model->get_projects();
        $this->data['banks'] = $this->bank_model->get_banks();
        $this->data['bank_id'] = $this->input->post('bank');
        $this->data['account_name'] = $this->input->post('account_name');        
        $this->data['bank_account_id'] = $this->input->post('bank_account_id');
        $this->data['account_number'] = $this->input->post('account_number');
        $this->data['TrnxType'] = $this->input->post('TrnxType');
        $this->data['ClearanceStatus'] = $this->input->post('ClearanceStatus');
        $this->data['PartyID'] = $this->input->post('PartyID');
        $this->data['FromDate'] = $this->input->post('FromDate');
        $this->data['ToDate'] = $this->input->post('ToDate');
        $this->load->view('pages/bank_pages/bank_book', $this->data);
        $this->load->view('nav_bars/footer');
    }
    
    function add_transaction(){
		$ResultData = array();
		if($this->session->logged_in != 'YES'){
            $ResultData["Status"] = 1001;
            $ResultData["ErroMsg"] = "Please login to access this data";
        }        
        else{
			if($this->input->post('bank_account_id'))
			{
				
			}else{
				redirect("bank_account/bank_book_summary");
			}
			$transaction_id = $this->bank_book_model->add_transaction();
			
			/*$this->load->helper('form');
			$this->load->view('nav_bars/header');
			$this->load->view('nav_bars/left_nav');
			$this->data['account_name'] = $this->input->post('account_name');
			$this->data['parties'] = $this->party_model->get_party();
			$this->data['instrument_types'] = $this->instrument_type_model->get_instrument_type();
			$this->data['cheque_leaves'] = $this->cheque_leaf_model->get_cheque_leaves();
			$this->data['projects'] = $this->project_model->get_projects();
			$this->data['banks'] = $this->bank_model->get_all_banks();
			$this->data['bank_id'] = $this->input->post('bank');
			$this->data['bank_account_id'] = $this->input->post('bank_account_id');
			$this->data['account_number'] = $this->input->post('account_number');
			$this->load->view('pages/bank_pages/bank_book', $this->data);
			$this->load->view('nav_bars/footer');*/
			$ResultData["TrnxID"] = $transaction_id;
		}
		echo json_encode($ResultData);
		
    }
    
    function add_bank_book(){
        if($this->session->logged_in != 'YES'){
            $ResultData["Status"] = 1001;
            $ResultData["ErroMsg"] = "Please login to access this data";
			echo json_encode($ResultData);
        }        
        else{
		$bank_book_id = $this->bank_book_model->add_bank_book();
		echo json_encode($bank_book_id);
	}
    }
    
    function get_bank_books($account_id_get = 0){
        $bank_books_infromation = $this->bank_book_model->get_bank_books($account_id_get);
        echo json_encode($bank_books_infromation);
    }
	
	function search_bank_books($account_id_get = 0){
        $bank_books_infromation = $this->bank_book_model->search_bank_books($account_id_get);
        echo json_encode($bank_books_infromation);
    }
}
