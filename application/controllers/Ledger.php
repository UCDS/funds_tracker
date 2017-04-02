<?php

class Ledger extends CI_Controller {
	private $ledger_tranx_information = array();
    function __construct(){
        parent::__construct();
		
		if($this->input->post('ledger_id')){
            $this->ledger_tranx_information['ledger_id'] = $this->input->post('ledger_id');
        }
        if($this->input->post('transaction_id')){
            $this->ledger_tranx_information['transaction_id'] = $this->input->post('transaction_id');
        }
        if($this->input->post('narration')){
            $this->ledger_tranx_information['narration'] = $this->input->post('narration');
        }
        if($this->input->post('amount')){
            $this->ledger_tranx_information['amount'] = $this->input->post('amount');
        }
        if($this->input->post('project_id')){
            $this->ledger_tranx_information['project_id'] = $this->input->post('project_id');
        }else{
			$this->ledger_tranx_information['project_id'] = 0;
		}
        if($this->input->post('ledger_account_id')){
            $this->ledger_tranx_information['ledger_account_id'] = $this->input->post('ledger_account_id');
        }else{
			$this->ledger_tranx_information['ledger_account_id'] = 0;
		}
        if($this->input->post('ledger_sub_account_id')){
            $this->ledger_tranx_information['ledger_sub_account_id'] = $this->input->post('ledger_sub_account_id');
        }else{
			$this->ledger_tranx_information['ledger_sub_account_id'] = 0;
		}
        if($this->input->post('narration')){
            $this->ledger_tranx_information['narration'] = $this->input->post('narration');
        }
        if($this->input->post('payee_party_id')){
            $this->ledger_tranx_information['payee_party_id'] = $this->input->post('payee_party_id');
        }else{
			$this->ledger_tranx_information['payee_party_id'] = 0;
		}
        if($this->input->post('item_id')){
            $this->ledger_tranx_information['item_id'] = $this->input->post('item_id');
        }else{
			$this->ledger_tranx_information['item_id'] = 0;
		}
        if($this->input->post('donor_party_id')){
            $this->ledger_tranx_information['donor_party_id'] = $this->input->post('donor_party_id');
        }else{
			$this->ledger_tranx_information['donor_party_id'] = 0;
		}

        $this->load->model('generic_model');        
        $this->load->model('ledger_model');        
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
	
    function getLedgerAccountList(){
        if($this->session->logged_in != 'YES'){
            $ResultData["Status"] = 1001;
            $ResultData["ErroMsg"] = "Please login to access this data";
			echo json_encode($ResultData);
        }        
        else{
			$items = $this->generic_model->get_ledger_accounts_list();
			echo json_encode($items);
		}
    }
	function getLedgerSubAccountList(){
		if($this->session->logged_in != 'YES'){
            $ResultData["Status"] = 1001;
            $ResultData["ErroMsg"] = "Please login to access this data";
			echo json_encode($ResultData);
        }        
        else{
			$items = $this->generic_model->get_ledger_sub_accounts_list();
			echo json_encode($items);
		}
	}
	function addLedgerTransaction(){
		if(key_exists('ledger_id', $this->ledger_tranx_information)){
			$this->db->where('ledger_id',$this->ledger_tranx_information['ledger_id']);
			unset($this->ledger_tranx_information['ledger_id']);
			$this->db->update('ledger',$this->ledger_tranx_information);
			return true;
		}else{
			$this->db->insert('ledger', $this->ledger_tranx_information);        
			return $this->db->insert_id();
		}
	}
	function getLedgerTransactions($trnxID){
		$ResultData = array();
		if($this->session->logged_in != 'YES'){
            $ResultData["Status"] = 1001;
            $ResultData["ErroMsg"] = "Please login to access this data";
			echo json_encode($ResultData);
        }        
        else{
			$ledger_transactions = $this->ledger_model->get_ledger_transactions($trnxID);
			echo json_encode($ledger_transactions);
		}
	}
	function deleteLedgerTransaction($ledger_id){
		$ResultData = array();
		if($this->session->logged_in != 'YES'){
            $ResultData["Status"] = 1001;
            $ResultData["ErroMsg"] = "Please login to access this data";
			echo json_encode($ResultData);
        }        
        else{
			$ledger_transactions = $this->ledger_model->delete_ledger_transaction($ledger_id);
			echo json_encode($ledger_transactions);
		}
	}
}
?>
