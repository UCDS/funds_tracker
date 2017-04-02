<?php

class Report extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('report_model');
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
        $this->data['searchID'] = $this->input->post('searchID');
        $this->data['searchBy'] = $this->input->post('searchBy');
        
		
		$this->load->view('pages/reports/ledger',$this->data);
        $this->load->view('nav_bars/footer');
		
	}

    function getPartyData(){
        // echo "test".$this->input->post('partyID');
        $result =  $this->report_model->getPartyBasedTrnxData($this->input->post('partyID'),$this->input->post('startDate'),$this->input->post('endDate'));
        echo json_encode($result);
    }

    function getPartyDetailsData(){
        $result =  $this->report_model->getPartyBasedTrnxDetails();
        echo json_encode($result);
    }

    function partyDetailsPage(){
        $this->load->view('pages/reports/party_details');
    }

	function getLedgerData(){
        $result =  $this->report_model->getLedgerBasedTrnxData($this->input->post('searchBy'),$this->input->post('searchID'),$this->input->post('startDate'),$this->input->post('endDate'));
        echo json_encode($result);
    }

    function getLedgerDetailsData(){
        $result =  $this->report_model->getLedgerBasedTrnxDetails();
        echo json_encode($result);
    }

	function ledgerDetailsPage(){
        $this->load->view('pages/reports/ledger_details');
    }
}

?>