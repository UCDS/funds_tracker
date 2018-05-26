<?php

class Upload extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->helper('form_helper');       
        $this->load->model('upload_model');       
    }
    
    function index(){
        $this->load->view('nav_bars/header');
		$this->load->view('nav_bars/left_nav');
		
		$this->data['PaymentVoucherNumber'] = $this->input->post('PaymentVoucherNumber');;
		$this->data['bank_account_id'] = $this->input->post('bank_account_id');
		$this->data['bank'] = $this->input->post('bank');
		$this->data['account_name'] = $this->input->post('account_name');
		$this->data['account_number'] = $this->input->post('account_number');
		$this->data['ledger_reference_table'] = $this->input->post('ledger_reference_table');
		$this->data['TrnxType'] = $this->input->post('TrnxType');
		$this->data['StartDate'] = $this->input->post('StartDate');
		$this->data['EndDate'] = $this->input->post('EndDate');
		$this->data['TranxID'] = $this->input->post('TranxID');
		
		$this->data['Date'] = $this->input->post('Date');
		$this->data['PartyName'] = $this->input->post('PartyName');
		$this->data['Narration'] = $this->input->post('Narration');
		$this->data['IType'] = $this->input->post('IType');
		$this->data['IID'] = $this->input->post('IID');
		$this->data['IDate'] = $this->input->post('IDate');
		$this->data['BName'] = $this->input->post('BName');
		$this->data['TType'] = $this->input->post('TType');
		$this->data['TAmt'] = $this->input->post('TAmt');
		$this->data['BCS'] = $this->input->post('BCS');
		$this->data['CD'] = $this->input->post('CD');
		$this->data['BR'] = $this->input->post('BR');
		$this->data['Notes'] = $this->input->post('Notes');
		$this->data['Module'] = $this->input->post('Module');
		$this->data['PartyID'] = $this->input->post('PartyID');
		$this->data['PartyName'] = $this->input->post('PartyName');
		$this->data['ClearanceStatus'] = $this->input->post('ClearanceStatus');
		
		$this->data['searchBy'] = $this->input->post('searchBy');
		$this->data['searchID'] = $this->input->post('searchID');
		$this->data['project_id'] = $this->input->post('project_id');

		$this->data['ledgerType'] = $this->input->post('ledgerType');

		$this->load->view('pages/FileUpload/upload',$this->data);
        $this->load->view('nav_bars/footer');
    }
	function uploadfile($tranxID,$ledgerType){
		require(__DIR__.'/UploadHandler.php');
		if($ledgerType != "1"){
			
			$upload_handler = new UploadHandler("journal.".$tranxID);
			$this->upload_model->updateJournalAttachmentsCount($tranxID);
		}else{
			$upload_handler = new UploadHandler($tranxID);
			$this->upload_model->updateAttachmentsCount($tranxID);
		}
	}
	function filehandle($tranxID){
		require(__DIR__.'/UploadHandler.php');
//		if($this->input->post('ledgerType') != "1"){
//			$upload_handler = new UploadHandler("journal/"+$tranxID);
//		}else{
			$upload_handler = new UploadHandler($tranxID);
//		}
	}
	function delete($tranxID){
	if($this->session->logged_in != 'YES'){
            echo false;
        }
        else{
			unlink(__DIR__.'/../../assets/bankbook_files/'.$tranxID.'/'.$this->input->get("file"));
			if (strpos($tranxID, 'journal') !== false) {
				$this->upload_model->updateJournalAttachmentsCount($tranxID);
				
			}else{
				$this->upload_model->updateAttachmentsCount($tranxID);
			}
			echo true;
		}
	}
}

?>