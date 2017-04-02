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
		$this->data['bank_account_id'] = $this->input->post('bank_account_id');
		$this->data['bank'] = $this->input->post('bank');
		$this->data['account_name'] = $this->input->post('account_name');
		$this->data['account_number'] = $this->input->post('account_number');
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
        
		
		$this->load->view('pages/FileUpload/upload',$this->data);
        $this->load->view('nav_bars/footer');
    }
	function uploadfile($tranxID){
		require(__DIR__.'/UploadHandler.php');
		$upload_handler = new UploadHandler($tranxID);
		$this->upload_model->updateAttachmentsCount($tranxID);
	}
	function filehandle($tranxID){
		require(__DIR__.'/UploadHandler.php');
		$upload_handler = new UploadHandler($tranxID);
	}
	function delete($tranxID){
	if($this->session->logged_in != 'YES'){
            echo false;
        }
        else{
			unlink(__DIR__.'/../../assets/bankbook_files/'.$tranxID.'/'.$this->input->get("file"));
			$this->upload_model->updateAttachmentsCount($tranxID);
			echo true;
		}
	}
}

?>