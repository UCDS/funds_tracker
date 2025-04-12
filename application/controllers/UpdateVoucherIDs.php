<?php

class UpdateVoucherIDs extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('generic_model');
    }
    
    function index(){
		$ResultData = array();
		if($this->session->logged_in != 'YES'){
            $ResultData["Status"] = 1001;
            $ResultData["ErroMsg"] = "Please login to access this data";
			
        }        
        else{
			$this->generic_model->updateAnnualVoucherIDs();
			$this->generic_model->updateAnnualJournalVoucherIDs();
			$ResultData["Status"] = 1;
		}
		
		// $this->output->set_content_type('application/json')->set_output(json_encode($ResultData));
    }
}
?>