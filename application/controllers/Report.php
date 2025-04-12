<?php

class Report extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('report_model');
        $this->load->model('bank_account_model');
        $this->load->library('session');
        error_reporting(0);
    }
    
    function index(){
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $this->load->view('pages/reports/party');
        $this->load->view('nav_bars/footer');
    }
    
    function party(){
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $this->data['bank_account_id'] = $this->input->post('bank_account_id');
        $this->data['bank'] = $this->input->post('bank');
        $this->data['account_name'] = $this->input->post('account_name');
        $this->data['account_number'] = $this->input->post('account_number');
        $this->data['TrnxType'] = $this->input->post('TrnxType');
        $this->data['ClearanceStatus'] = $this->input->post('ClearanceStatus');
        $this->data['PartyID'] = $this->input->post('PartyID');
        $this->data['PartyName'] = $this->input->post('PartyName');
        $this->data['FromDate'] = $this->input->post('FromDate');
        $this->data['ToDate'] = $this->input->post('ToDate');
        $this->load->view('pages/reports/party',$this->data);
        $this->load->view('nav_bars/footer');
    }
	
	function ledger(){
		$this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
		$this->load->model('party_model');
		$this->load->model('project_model');
		$this->load->model('generic_model');
        $this->data['parties'] = $this->party_model->get_party();
		$this->data['projects'] = $this->project_model->get_projects();
		$this->data['ledger_accounts'] = $this->generic_model->get_ledger_accounts_list();
		$this->data['ledger_sub_accounts'] = $this->generic_model->get_ledger_sub_accounts_list();
        $this->data['items'] = $this->generic_model->get_items_list();
        $this->data['bankaccounts'] = $this->bank_account_model->get_bank_book_accounts();
		
		$this->data['bank_account_id'] = $this->input->post('bank_account_id');
        $this->data['bank'] = $this->input->post('bank');
        $this->data['account_name'] = $this->input->post('account_name');
        $this->data['account_number'] = $this->input->post('account_number');
        $this->data['ledger_reference_table'] = $this->input->post('ledger_reference_table');
        $this->data['TrnxType'] = $this->input->post('TrnxType');
        $this->data['ClearanceStatus'] = $this->input->post('ClearanceStatus');
        $this->data['PartyID'] = $this->input->post('PartyID');
        $this->data['PartyName'] = $this->input->post('PartyName');
        $this->data['FromDate'] = $this->input->post('FromDate');
        $this->data['ToDate'] = $this->input->post('ToDate');
        $this->data['searchID'] = $this->input->post('searchID');
        $this->data['searchBy'] = $this->input->post('searchBy');
        $this->data['project_id'] = $this->input->post('project_id');
        
		
		$this->load->view('pages/reports/ledger',$this->data);
        $this->load->view('nav_bars/footer');
		
	}
	
	function payments(){
		$this->load->view('nav_bars/header');
		$this->load->view('nav_bars/left_nav');
		$this->load->view('pages/reports/payments');
		$this->load->view('nav_bars/footer');
	}
	function receipts(){
		$this->load->view('nav_bars/header');
		$this->load->view('nav_bars/left_nav');
		$this->load->view('pages/reports/receipts');
		$this->load->view('nav_bars/footer');
	}

	function getPartyData(){
        // echo "test".$this->input->post('partyID');
        $result =  $this->report_model->getPartyBasedTrnxData($this->input->post('partyID'),$this->input->post('startDate'),$this->input->post('endDate'));
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }

    function getPartyDetailsData(){
        $result =  $this->report_model->getPartyBasedTrnxDetails();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }

    function partyDetailsPage(){
        $this->load->view('pages/reports/party_details');
    }

	function getLedgerData(){
        $result =  $this->report_model->getLedgerBasedTrnxData($this->input->post('searchBy'),$this->input->post('searchID'),$this->input->post('startDate'),$this->input->post('endDate'), $this->input->post('bankAccount'));
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }

    function getLedgerDetailsData(){
        $result =  $this->report_model->getLedgerBasedTrnxDetails();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }

	function ledgerDetailsPage(){
        $this->load->view('pages/reports/ledger_details');
    }
}

?>