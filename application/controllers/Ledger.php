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
        if($this->input->post('debit_credit')){
            $this->ledger_tranx_information['debit_credit'] = $this->input->post('debit_credit');
        }
        if($this->input->post('ledger_reference_table')){
            $this->ledger_tranx_information['ledger_reference_table'] = $this->input->post('ledger_reference_table');
        }
        if($this->input->post('narration')){
            $this->ledger_tranx_information['narration'] = $this->input->post('narration');
        }
        if($this->input->post('amount') || $this->input->post('amount') == 0){
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
//        if($this->session->logged_in != 'YES'){
//            $ResultData["Status"] = 1001;
//            $ResultData["ErroMsg"] = "Please login to access this data";
//			$this->output
//			->set_content_type('application/json')
//			->set_output(json_encode($ResultData));
//        }
//        else
			{
			$items = $this->generic_model->get_ledger_accounts_list();
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($items));
		}
    }
	function getLedgerSubAccountList(){
//		if($this->session->logged_in != 'YES'){
//            $ResultData["Status"] = 1001;
//            $ResultData["ErroMsg"] = "Please login to access this data";
//			$this->output
//			->set_content_type('application/json')
//			->set_output(json_encode($ResultData));
//        }        
//        else
			{
			$items = $this->generic_model->get_ledger_sub_accounts_list();
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($items));
		}
	}
	function addLedgerTransaction(){
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $request = json_decode($stream_clean);
        if(isset($request)) {
            $arrlength = count($request);
            for($x = 0; $x < $arrlength; $x++) {
                $local_ledger_tranx_info = $request[$x];
                $local_ledger_tranx_info = $this->transformLedgerRequest($local_ledger_tranx_info);
                if(key_exists('ledger_id', $local_ledger_tranx_info)){
                    $this->db->where('ledger_id',$local_ledger_tranx_info['ledger_id']);
                    unset($local_ledger_tranx_info['ledger_id']);
                    $this->db->update('ledger',$local_ledger_tranx_info);
                    // return true;
                }else{
                    $this->db->insert('ledger', $local_ledger_tranx_info);        
                    // return $this->db->insert_id();
                }
            }
        }
    }
    
    private function transformLedgerRequest($sourceLedgerData) {
        $transformedLedgerData = array();
        if(key_exists('ledger_id', $sourceLedgerData)){
            $transformedLedgerData['ledger_id'] = $sourceLedgerData->ledger_id;
        }
        if(key_exists('transaction_id', $sourceLedgerData)){
            $transformedLedgerData['transaction_id'] = $sourceLedgerData->transaction_id;
        }
        if(key_exists('debit_credit', $sourceLedgerData)){
            $transformedLedgerData['debit_credit'] = $sourceLedgerData->debit_credit;
        }
        if(key_exists('ledger_reference_table', $sourceLedgerData)){
            $transformedLedgerData['ledger_reference_table'] = $sourceLedgerData->ledger_reference_table;
        }
        if(key_exists('narration', $sourceLedgerData)){
            $transformedLedgerData['narration'] = $sourceLedgerData->narration;
        }
        if(key_exists('amount', $sourceLedgerData) || $sourceLedgerData->amount == 0){
            $transformedLedgerData['amount'] = $sourceLedgerData->amount;
        }
        if(key_exists('project_id', $sourceLedgerData)){
            $transformedLedgerData['project_id'] = $sourceLedgerData->project_id;
        }else{
			$transformedLedgerData['project_id'] = 0;
		}
        if(key_exists('ledger_account_id', $sourceLedgerData)){
            $transformedLedgerData['ledger_account_id'] = $sourceLedgerData->ledger_account_id;
        }else{
			$transformedLedgerData['ledger_account_id'] = 0;
		}
        if(key_exists('ledger_sub_account_id', $sourceLedgerData)){
            $transformedLedgerData['ledger_sub_account_id'] = $sourceLedgerData->ledger_sub_account_id;
        }else{
			$transformedLedgerData['ledger_sub_account_id'] = 0;
		}
        if(key_exists('narration', $sourceLedgerData)){
            $transformedLedgerData['narration'] = $sourceLedgerData->narration;
        }
        if(key_exists('payee_party_id', $sourceLedgerData)){
            $transformedLedgerData['payee_party_id'] = $sourceLedgerData->payee_party_id;
        }else{
			$transformedLedgerData['payee_party_id'] = 0;
		}
        if(key_exists('item_id', $sourceLedgerData)){
            $transformedLedgerData['item_id'] = $sourceLedgerData->item_id;
        }else{
			$transformedLedgerData['item_id'] = 0;
		}
        if(key_exists('donor_party_id', $sourceLedgerData)){
            $transformedLedgerData['donor_party_id'] = $sourceLedgerData->donor_party_id;
        }else{
			$transformedLedgerData['donor_party_id'] = 0;
        }
        return $transformedLedgerData;
    }

	function getLedgerTransactions($trnxID,$type){
//		$ResultData = array();
		$ledger_transactions = $this->ledger_model->get_ledger_transactions($trnxID,$type);
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($ledger_transactions));
//		}
	}
	function deleteLedgerTransaction($ledger_id){
		$ResultData = array();
		if($this->session->logged_in != 'YES'){
            $ResultData["Status"] = 1001;
            $ResultData["ErroMsg"] = "Please login to access this data";
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($ResultData));
        }        
        else{
			$ledger_transactions = $this->ledger_model->delete_ledger_transaction($ledger_id);
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($ledger_transactions));
		}
	}
}
?>
