<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Upload_model extends CI_Model {
    function __construct() {
    	 parent::__construct();
    }
    function updateAttachmentsCount($tranxID){
		$count = count(scandir(__DIR__.'/../../assets/bankbook_files/'.$tranxID)) - 2;
		// if(glob(__DIR__.'/../../assets/bankbook_files/'.$tranxID.'/') != false)
		// 	$count = count(glob(__DIR__.'/../../assets/bankbook_files/'.$tranxID.'/'));
		if(!isset($count) ||  $count < 0) $count = 0;
		$data["attachments_count"] = $count;
		$this->db->where('transaction_id',$tranxID);
		$this->db->update('bank_book',$data);
	}
	function updateJournalAttachmentsCount($tranxID){
		$count = count(scandir(__DIR__.'/../../assets/bankbook_files/journal.'.$tranxID)) - 2;
		if(!isset($count) ||  $count < 0) $count = 0;
		$data["attachments_count"] = $count;
		$this->db->where('journal_id',$tranxID);
		$this->db->update('journal',$data);
		
	}
	function updateviewvalue($tranxID,$view)
	{
		$data["view"] = $view;
		$this->db->where('transaction_id',$tranxID);
		$this->db->update('bank_book',$data);
	}

	function getviewval()
	{
		$paymentVoucherNumber = $this->session->userdata('PaymentVoucherNumber');
		$this->db->select('view');
		$this->db->from('bank_book');
		$this->db->where('bank_annual_voucher_id',$paymentVoucherNumber);
		$query = $this->db->get();
        $result = $query->result();
		return $result;
	}

}

