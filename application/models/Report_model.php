<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Report_model extends CI_Model {
    function __construct() {
    	 parent::__construct();
    }
    function getPartyBasedTrnxData($party_id,$startdate,$enddate){
    	$this->db->select("bbook.bank_account_id, ba.bank_id, ba.account_number, ba.account_name, '$party_id' AS sPartyID, '$startdate' AS sStartDate,'$enddate' AS sEndDate,"
    			. 'SUM(CASE WHEN clearance_status=1 AND debit_credit="Credit" THEN 1 ELSE 0 END) as RecptClearedCnt,'
				. 'ROUND(SUM(CASE WHEN clearance_status=1 AND debit_credit="Credit" THEN transaction_amount ELSE 0 END),2) as RecptCleared,'
				. 'SUM(CASE WHEN clearance_status=0 AND debit_credit="Credit" THEN 1 ELSE 0 END) as RecptUnclearedCnt,'
				. 'ROUND(SUM(CASE WHEN clearance_status=0 AND debit_credit="Credit" THEN transaction_amount ELSE 0 END),2) as RecptUncleared,'
				. 'SUM(CASE WHEN clearance_status=1 AND debit_credit="Debit" THEN 1 ELSE 0 END) as PayClearedCnt,'
				. 'ROUND(SUM(CASE WHEN clearance_status=1 AND debit_credit="Debit" THEN transaction_amount ELSE 0 END),2) as PayCleared,'
				. 'SUM(CASE WHEN clearance_status=0 AND debit_credit="Debit" THEN 1 ELSE 0 END) as PayUnClearedCnt,'
				. 'ROUND(SUM(CASE WHEN clearance_status=0 AND debit_credit="Debit" THEN transaction_amount ELSE 0 END),2) as PayUnCleared')
				->from('bank_book bbook')
				->join('bank_account ba','ba.bank_account_id=bbook.bank_account_id','left')
				->where('bbook.party_id',$party_id);
		if($startdate)
			$this->db->where('bbook.date >=',$startdate." 00:00:00");
		if($enddate)
			$this->db->where('bbook.date <=',$enddate." 23:59:59");
		$this->db->group_by('bbook.bank_account_id')
				->order_by('ba.account_name')
				->where('bank_book', 1);
		$query = $this->db->get();
		 //echo $this->db->last_query();
        $result = $query->result();
		return $result;
    }
	
	function getLedgerBasedTrnxData($search_by,$search_id,$startdate,$enddate){
		$this->db->select("ldgr.ledger_id,ldgr.transaction_id,ldgr.narration,round(ldgr.amount,2) as amount,ldgr.project_id,ldgr.ledger_account_id,ldgr.ledger_sub_account_id,ldgr.payee_party_id,ldgr.item_id,ldgr.donor_party_id,"
				." bbook.bank_account_id, ba.bank_id, ba.account_number, ba.account_name, '$search_by' AS sSearchBy, $search_id AS sSearchID, '$startdate' AS sStartDate,'$enddate' AS sEndDate,"
    			. 'SUM(CASE WHEN clearance_status=1 AND debit_credit="Credit" THEN 1 ELSE 0 END) as RecptClearedCnt,'
				. 'ROUND(SUM(CASE WHEN clearance_status=1 AND debit_credit="Credit" THEN ldgr.amount ELSE 0 END),2) as RecptCleared,'
				. 'SUM(CASE WHEN clearance_status=0 AND debit_credit="Credit" THEN 1 ELSE 0 END) as RecptUnclearedCnt,'
				. 'ROUND(SUM(CASE WHEN clearance_status=0 AND debit_credit="Credit" THEN ldgr.amount ELSE 0 END),2) as RecptUncleared,'
				. 'SUM(CASE WHEN clearance_status=1 AND debit_credit="Debit" THEN 1 ELSE 0 END) as PayClearedCnt,'
				. 'ROUND(SUM(CASE WHEN clearance_status=1 AND debit_credit="Debit" THEN ldgr.amount ELSE 0 END),2) as PayCleared,'
				. 'SUM(CASE WHEN clearance_status=0 AND debit_credit="Debit" THEN 1 ELSE 0 END) as PayUnClearedCnt,'
				. 'ROUND(SUM(CASE WHEN clearance_status=0 AND debit_credit="Debit" THEN ldgr.amount ELSE 0 END),2) as PayUnCleared')
				->from('ledger ldgr')
				->join('bank_book bbook','bbook.transaction_id=ldgr.transaction_id','left')
				->join('bank_account ba','ba.bank_account_id=bbook.bank_account_id','left');
				if($search_by == "1")
					$this->db->where('ldgr.ledger_account_id',$search_id);
				else if($search_by == "2")
					$this->db->where('ldgr.ledger_sub_account_id',$search_id);
				else if($search_by == "3")
					$this->db->where('ldgr.payee_party_id',$search_id);
				else if($search_by == "4")
					$this->db->where('ldgr.item_id',$search_id);
				else if($search_by == "5")
					$this->db->where('ldgr.project_id',$search_id);
				else if($search_by == "6")
					$this->db->where('ldgr.donor_party_id',$search_id);
		if($startdate)
			$this->db->where('bbook.date >=',$startdate." 00:00:00");
		if($enddate)
			$this->db->where('bbook.date <=',$enddate." 23:59:59");
		$this->db->group_by('bbook.bank_account_id')
				->order_by('ba.account_name')
				->where('bank_book', 1);
		$query = $this->db->get();
		 //echo $this->db->last_query();
        $result = $query->result();
		return $result;
	}

    function getPartyBasedTrnxDetails(){

	    if($this->input->post('bank_account_id'))
			$this->db->where('bank_book.bank_account_id', $this->input->post('bank_account_id'));
		if($this->input->post('FromDate'))
			$this->db->where('bank_book.date >=', $this->input->post('FromDate')."00:00:00");
		if($this->input->post('ToDate'))
			$this->db->where('bank_book.date <=', $this->input->post('ToDate').'23:59:59');
		if($this->input->post('TrnxType'))
				$this->db->where('bank_book.debit_credit', $this->input->post('TrnxType'));
		if($this->input->post('ClearanceStatus') || $this->input->post('ClearanceStatus') == '0')
			$this->db->where('bank_book.clearance_status', $this->input->post('ClearanceStatus'));
		if($this->input->post('PartyID') || $this->input->post('PartyID') == '0')
			$this->db->where('bank_book.party_id', $this->input->post('PartyID'));

		$this->db->select('bank_book.*,DATE_FORMAT(bank_book.date,"%d-%b-%Y %T") as TrnxDate,DATE_FORMAT(bank_book.clearance_date,"%d-%b-%Y") as TrnxClearance_date,DATE_FORMAT(bank_book.instrument_date,"%d-%b-%Y") as TrnxInstrument_date, bank_account.account_number as account_number,	'
				. 'round(bank_book.transaction_amount,2) as transaction_amount_ui,party.party_name party_name, bank.bank_name bank_name,'
					. 'instrument_type.instrument_type instrument_type,'
					. 'project.project_name project_name')
                ->from('bank_book')
				->join('party','bank_book.party_id=party.party_id','left')
				->join('instrument_type','bank_book.instrument_type_id=instrument_type.instrument_type_id','left')
				->join('project','bank_book.project_id=project.project_id','left')
				->join('bank','bank_book.bank_id=bank.bank_id','left')
				->join('bank_account','bank_book.bank_account_id=bank_account.bank_account_id','left')
				->order_by('bank_book.date','desc')
				->order_by("bank_book.transaction_id", "desc");
                // ->limit("$this->return_size");
        $query = $this->db->get();
        // echo $this->db->last_query();
        $result = $query->result();
        return $result;
    }

    function getLedgerBasedTrnxDetails(){

	    if($this->input->post('bank_account_id'))
			$this->db->where('bank_book.bank_account_id', $this->input->post('bank_account_id'));
		if($this->input->post('FromDate'))
			$this->db->where('bank_book.date >=', $this->input->post('FromDate')."00:00:00");
		if($this->input->post('ToDate'))
			$this->db->where('bank_book.date <=', $this->input->post('ToDate').'23:59:59');
		if($this->input->post('TrnxType'))
				$this->db->where('bank_book.debit_credit', $this->input->post('TrnxType'));
		if($this->input->post('ClearanceStatus') || $this->input->post('ClearanceStatus') == '0')
			$this->db->where('bank_book.clearance_status', $this->input->post('ClearanceStatus'));
		
		

		$this->db->select('bank_book.*, round(ldgr.amount,2) as amount, ldgr.narration as ledger_narration,ldgract.ledger_account_name,ldgrsubact.ledger_sub_account_name, item.item_name, prjct.project_name,'
				. 'payer_party.party_name as payer_party_name, donor_party.party_name as donor_party_name,'
				. 'DATE_FORMAT(bank_book.date,"%d-%b-%Y %T") as TrnxDate,DATE_FORMAT(bank_book.clearance_date,"%d-%b-%Y") as TrnxClearance_date,DATE_FORMAT(bank_book.instrument_date,"%d-%b-%Y") as TrnxInstrument_date, bank_account.account_number as account_number,	'
				. 'round(bank_book.transaction_amount,2) as transaction_amount_ui,party.party_name party_name, bank.bank_name bank_name,'
					. 'instrument_type.instrument_type instrument_type,'
					. 'project.project_name project_name')
                ->from('bank_book')
				->join('party','bank_book.party_id=party.party_id','left')
				->join('instrument_type','bank_book.instrument_type_id=instrument_type.instrument_type_id','left')
				->join('project','bank_book.project_id=project.project_id','left')
				->join('bank','bank_book.bank_id=bank.bank_id','left')
				->join('bank_account','bank_book.bank_account_id=bank_account.bank_account_id','left')
				->join('ledger ldgr',"ldgr.transaction_id=bank_book.transaction_id")
				->join('ledger_account ldgract',"ldgract.ledger_account_id=ldgr.ledger_account_id",'left')
				->join('ledger_sub_account ldgrsubact',"ldgrsubact.ledger_sub_account_id=ldgr.ledger_sub_account_id",'left')
				->join('item',"item.item_id=ldgr.item_id",'left')
				->join('project prjct',"prjct.project_id=ldgr.project_id",'left')
				->join('party payer_party',"payer_party.party_id=ldgr.payee_party_id",'left')
				->join('party donor_party',"donor_party.party_id=ldgr.donor_party_id",'left');
				
		
			if($this->input->post('searchBy') || $this->input->post('searchBy') == '0'){
			if($this->input->post('searchID') || $this->input->post('searchID') == '0'){
				$search_by = $this->input->post('searchBy');
				$search_id = $this->input->post('searchID');
				if($search_by == "1")
					$this->db->where('ldgr.ledger_account_id',$search_id);
				else if($search_by == "2")
					$this->db->where('ldgr.ledger_sub_account_id',$search_id);
				else if($search_by == "3")
					$this->db->where('ldgr.payee_party_id',$search_id);
				else if($search_by == "4")
					$this->db->where('ldgr.item_id',$search_id);
				else if($search_by == "5")
					$this->db->where('ldgr.project_id',$search_id);
				else if($search_by == "6")
					$this->db->where('ldgr.donor_party_id',$search_id);
			}
		}
		$this->db->order_by('bank_book.date','desc')
			->order_by("bank_book.transaction_id", "desc");
			// ->limit("$this->return_size");
        $query = $this->db->get();
        // echo $this->db->last_query();
        $result = $query->result();
        return $result;
    }
	
}

