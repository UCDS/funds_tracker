<?php

class Report_model extends CI_Model {
    function __construct() {
    	 parent::__construct();
    }
    function getPartyBasedTrnxData($party_id,$startdate,$enddate){
    	$this->db->select("bbook.bank_account_id, ba.bank_id, ba.account_number, ba.account_name, '$party_id' AS sPartyID, '$startdate' AS sStartDate,'$enddate' AS sEndDate,"
    			. 'SUM(CASE WHEN clearance_status=1 AND bbook.debit_credit="Credit" THEN 1 ELSE 0 END) as RecptClearedCnt,'
				. 'ROUND(SUM(CASE WHEN clearance_status=1 AND bbook.debit_credit="Credit" THEN transaction_amount ELSE 0 END),2) as RecptCleared,'
				. 'SUM(CASE WHEN clearance_status=0 AND bbook.debit_credit="Credit" THEN 1 ELSE 0 END) as RecptUnclearedCnt,'
				. 'ROUND(SUM(CASE WHEN clearance_status=0 AND bbook.debit_credit="Credit" THEN transaction_amount ELSE 0 END),2) as RecptUncleared,'
				. 'SUM(CASE WHEN clearance_status=1 AND bbook.debit_credit="Debit" THEN 1 ELSE 0 END) as PayClearedCnt,'
				. 'ROUND(SUM(CASE WHEN clearance_status=1 AND bbook.debit_credit="Debit" THEN transaction_amount ELSE 0 END),2) as PayCleared,'
				. 'SUM(CASE WHEN clearance_status=0 AND bbook.debit_credit="Debit" THEN 1 ELSE 0 END) as PayUnClearedCnt,'
				. 'ROUND(SUM(CASE WHEN clearance_status=0 AND bbook.debit_credit="Debit" THEN transaction_amount ELSE 0 END),2) as PayUnCleared')
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
	
	function getLedgerBasedTrnxData($search_by,$search_id,$startdate,$enddate, $accountId){
		$result = array();
		
		if($accountId != "Journal") {
			$this->db->select("ldgr.ledger_id,ldgr.transaction_id,ldgr.narration,round(ldgr.amount,2) as amount,ldgr.project_id,ldgr.ledger_account_id,"
			. "ldgr.ledger_sub_account_id,ldgr.payee_party_id,ldgr.item_id,ldgr.donor_party_id,ldgr.ledger_reference_table,"
			. "bbook.bank_account_id, ba.bank_id, ba.account_number, ba.account_name, '$search_by' AS sSearchBy, '$startdate' AS sStartDate,'$enddate' AS sEndDate,"
			. 'SUM(CASE WHEN ldgr.debit_credit="Credit" THEN 1 ELSE 0 END) as RecptTotalCnt,'
			. 'ROUND(SUM(CASE WHEN ldgr.debit_credit="Credit" THEN ldgr.amount ELSE 0 END),2) as RecptTotal,'
			. 'SUM(CASE WHEN ldgr.debit_credit="Debit" THEN 1 ELSE 0 END) as PayTotalCnt,'
			. 'ROUND(SUM(CASE WHEN ldgr.debit_credit="Debit" THEN ldgr.amount ELSE 0 END),2) as PayTotal')
			->from('ledger ldgr')
			->where('ldgr.ledger_reference_table',1)
			->join('bank_book bbook','bbook.transaction_id=ldgr.transaction_id','left')
			->join('bank_account ba','ba.bank_account_id=bbook.bank_account_id','left');
	
			if ( $accountId && $accountId != '' && $accountId != "Journal" ) {
				$this->db->where('bbook.bank_account_id',$accountId);
			}
			if($search_by == "1" ){
				if($search_id != 0)
					$this->db->where('ldgr.ledger_account_id',$search_id);
				else
					$this->db->where('ldgr.ledger_account_id !=', 0);
				
				$this->db->select("la.ledger_account_name typename, ldgr.ledger_account_id AS sSearchID, la.account_type AS accounttype")
						->join("ledger_account la","la.ledger_account_id = ldgr.ledger_account_id");
				
				$this->db->group_by('ldgr.ledger_account_id');
			}
			else if($search_by == "7" || $search_by == "8"){
				if($search_id != 0)
					$this->db->where('ldgr.ledger_account_id',$search_id);
				else
					$this->db->where('ldgr.ledger_account_id !=', 0);
				$this->db->select("la.ledger_account_name typename, ldgr.ledger_account_id AS sSearchID, la.account_type AS accounttype, pjct.project_name") //
						->join("ledger_account la","la.ledger_account_id = ldgr.ledger_account_id")
						->join("project pjct","pjct.project_id = ldgr.project_id", "left");
				$this->db->group_by('ldgr.ledger_account_id');
				$this->db->group_by('ldgr.project_id');
			}
			else if($search_by == "2"){
				if($search_id != 0)
					$this->db->where('ldgr.ledger_sub_account_id',$search_id);
				else
					$this->db->where('ldgr.ledger_sub_account_id !=',0);
				$this->db->select("lsa.ledger_sub_account_name typename, ldgr.ledger_sub_account_id AS sSearchID")
						->join("ledger_sub_account lsa","lsa.ledger_sub_account_id = ldgr.ledger_sub_account_id");
				$this->db->group_by('ldgr.ledger_sub_account_id');
			}
			else if($search_by == "3"){
				if($search_id != 0)
					$this->db->where('ldgr.payee_party_id',$search_id);
				else
					$this->db->where('ldgr.payee_party_id !=',0);
				$this->db->select("prty.party_name typename, ldgr.payee_party_id AS sSearchID")
						->join("party prty","prty.party_id = ldgr.payee_party_id");
				$this->db->group_by('ldgr.payee_party_id');
			}
			else if($search_by == "4"){
				if($search_id != 0)
					$this->db->where('ldgr.item_id',$search_id);
				else
					$this->db->where('ldgr.item_id !=',0);

				$this->db->select("itm.item_name typename, ldgr.item_id AS sSearchID")
						->join("item itm","itm.item_id = ldgr.item_id");
				$this->db->group_by('ldgr.item_id');
			}
			else if($search_by == "5"){
				if($search_id != 0)
					$this->db->where('ldgr.project_id',$search_id);
				else
					$this->db->where('ldgr.project_id !=',0);
				$this->db->select("pjct.project_name typename, ldgr.project_id AS sSearchID")
						->join("project pjct","pjct.project_id= ldgr.project_id");
				$this->db->group_by('ldgr.project_id');
			}
			else if($search_by == "6"){
				if($search_id != 0)
					$this->db->where('ldgr.donor_party_id',$search_id);
				else
					$this->db->where('ldgr.donor_party_id !=',0);
				$this->db->select("prty.party_name typename, ldgr.donor_party_id AS sSearchID")
						->join("party prty","prty.party_id = ldgr.donor_party_id");
				$this->db->group_by('ldgr.donor_party_id');
			}
			if($startdate)
				$this->db->where('bbook.date >=',$startdate." 00:00:00");
			if($enddate)
				$this->db->where('bbook.date <=',$enddate." 23:59:59");
			$this->db->group_by('bbook.bank_account_id')
					->order_by('typename')
					->order_by('ba.account_name')
					->where('bank_book', 1);
			$query = $this->db->get();
			//echo $this->db->last_query();
			$result = $query->result();
		}	
		
		/**
		 * Journal transactions
		 */
		
		$result2 = array();
		if(!$accountId || $accountId == "Journal"){
			$this->db->select("ldgr.ledger_id,ldgr.transaction_id,ldgr.narration,round(ldgr.amount,2) as amount,ldgr.project_id,ldgr.ledger_account_id,"
					. "ldgr.ledger_sub_account_id,ldgr.payee_party_id,ldgr.item_id,ldgr.donor_party_id,ldgr.ledger_reference_table,"
					. "'Journal' AS account_name, '$search_by' AS sSearchBy, '$startdate' AS sStartDate,'$enddate' AS sEndDate,"
					. 'SUM(CASE WHEN ldgr.debit_credit="Credit" THEN 1 ELSE 0 END) as RecptTotalCnt,'
					. 'ROUND(SUM(CASE WHEN ldgr.debit_credit="Credit" THEN ldgr.amount ELSE 0 END),2) as RecptTotal,'
					. 'SUM(CASE WHEN ldgr.debit_credit="Debit" THEN 1 ELSE 0 END) as PayTotalCnt,'
					. 'ROUND(SUM(CASE WHEN ldgr.debit_credit="Debit" THEN ldgr.amount ELSE 0 END),2) as PayTotal')
					->from('ledger ldgr')
					->join('journal jrnl','jrnl.journal_id=ldgr.transaction_id')
					->where('ldgr.ledger_reference_table',2);
			if($search_by == "1" || $search_by == "7" || $search_by == "8"){
				if($search_id != 0)
					$this->db->where('ldgr.ledger_account_id',$search_id);
				else
					$this->db->where('ldgr.ledger_account_id !=', 0);
				$this->db->select("la.ledger_account_name typename, ldgr.ledger_account_id AS sSearchID, la.account_type AS accounttype")
						->join("ledger_account la","la.ledger_account_id = ldgr.ledger_account_id");
				$this->db->group_by('ldgr.ledger_account_id');
				if($search_by == "7" || $search_by == "8"){
					$this->db->select("pjct.project_name");
					$this->db->join("project pjct","pjct.project_id = ldgr.project_id", "left");
					$this->db->group_by('ldgr.project_id');
				}
			}
			else if($search_by == "2"){
				if($search_id != 0)
					$this->db->where('ldgr.ledger_sub_account_id',$search_id);
				else
					$this->db->where('ldgr.ledger_sub_account_id !=',0);
				$this->db->select("lsa.ledger_sub_account_name typename, ldgr.ledger_sub_account_id AS sSearchID")
						->join("ledger_sub_account lsa","lsa.ledger_sub_account_id = ldgr.ledger_sub_account_id");
				$this->db->group_by('ldgr.ledger_sub_account_id');
			}
			else if($search_by == "3"){
				if($search_id != 0)
					$this->db->where('ldgr.payee_party_id',$search_id);
				else
					$this->db->where('ldgr.payee_party_id !=',0);
				$this->db->select("prty.party_name typename, ldgr.payee_party_id AS sSearchID")
						->join("party prty","prty.party_id = ldgr.payee_party_id");
				$this->db->group_by('ldgr.payee_party_id');
			}
			else if($search_by == "4"){
				if($search_id != 0)
					$this->db->where('ldgr.item_id',$search_id);
				else
					$this->db->where('ldgr.item_id !=',0);

				$this->db->select("itm.item_name typename, ldgr.item_id AS sSearchID")
						->join("item itm","itm.item_id = ldgr.item_id");
				$this->db->group_by('ldgr.item_id');
			}
			else if($search_by == "5"){
				if($search_id != 0)
					$this->db->where('ldgr.project_id',$search_id);
				else
					$this->db->where('ldgr.project_id !=',0);
				$this->db->select("pjct.project_name typename, ldgr.project_id AS sSearchID")
						->join("project pjct","pjct.project_id= ldgr.project_id");
				$this->db->group_by('ldgr.project_id');
			}
			else if($search_by == "6"){
				if($search_id != 0)
					$this->db->where('ldgr.donor_party_id',$search_id);
				else
					$this->db->where('ldgr.donor_party_id !=',0);
				$this->db->select("prty.party_name typename, ldgr.donor_party_id AS sSearchID")
						->join("party prty","prty.party_id = ldgr.donor_party_id");
				$this->db->group_by('ldgr.donor_party_id');
			}

			if($startdate)
				$this->db->where('jrnl.journal_date_time >=',$startdate." 00:00:00");
			if($enddate)
				$this->db->where('jrnl.journal_date_time <=',$enddate." 23:59:59");

			$query = $this->db->get();
			$result2	 = $query->result();

			$result = array_merge($result,$result2);
		}
		/**
		 * Bank transactions
		 */
		 $result3 = array();
		 if(!$accountId) {
			if($search_by == "1" || $search_by == "7" || $search_by == "8"){
				$this->db->select('"Assets" AS accounttype, "Bank" AS typename, bank_account.account_name, bank_account.account_number'
					. ',bank_account.bank_account_id,bank_account.bank_id'
					. ',party.party_name party_name, bank.bank_name bank_name,'
					. 'bb.transaction_amount,bb.clearance_status, '
					. 'SUM(CASE WHEN debit_credit="Debit" THEN 1 ELSE 0 END) as RecptTotalCnt,'
					. 'SUM(CASE WHEN debit_credit="Credit" THEN 1 ELSE 0 END) as PayTotalCnt,'
					. 'SUM(CASE WHEN debit_credit="Credit" THEN transaction_amount ELSE 0 END) as PayTotal,'
					. 'SUM(CASE WHEN debit_credit="Debit" THEN transaction_amount ELSE 0 END) as RecptTotal,'
					. 'DATE_FORMAT( MAX(bb.last_upate_date_time), "%d-%b-%Y %H:%i:%S" ) lastupatedatetime')
					->from('bank_account')
					->join('party','bank_account.party_id=party.party_id','left')
					->join('bank', 'bank_account.bank_id=bank.bank_id','left')
					->join('bank_book bb','bank_account.bank_account_id=bb.bank_account_id','left')
					->group_by('bank_account.bank_account_id')
	//				->having('')
					->order_by('account_name')
					->where('bank_book', 1);

				if($startdate)
					$this->db->where('bb.date >=',$startdate." 00:00:00");
				if($enddate)
					$this->db->where('bb.date <=',$enddate." 23:59:59");
				$query = $this->db->get();
				$result3 = $query->result();
				$result = array_merge($result,$result3);
			}
		}
		return $result;
	}

    function getPartyBasedTrnxDetails(){

	    if($this->input->post('bank_account_id'))
			$this->db->where('bank_book.bank_account_id', $this->input->post('bank_account_id'));
		if($this->input->post('FromDate'))
			$this->db->where('bank_book.date >=', $this->input->post('FromDate')." 00:00:00");
		if($this->input->post('ToDate'))
			$this->db->where('bank_book.date <=', $this->input->post('ToDate').' 23:59:59');
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

		if($this->input->post('ledger_reference_table') || $this->input->post('ledger_reference_table') == '0')
			$this->db->where('ldgr.ledger_reference_table', $this->input->post('ledger_reference_table'));
		if($this->input->post('project_id') || $this->input->post('project_id') == '0')
			$this->db->where('ldgr.project_id', $this->input->post('project_id') == 0 ? "" : $this->input->post('project_id'));

		if($this->input->post('ledger_reference_table') == 2){
			
			if($this->input->post('FromDate'))
				$this->db->where('jrnl.journal_date_time >=', $this->input->post('FromDate')." 00:00:00");
			if($this->input->post('ToDate'))
				$this->db->where('jrnl.journal_date_time <=', $this->input->post('ToDate').' 23:59:59');
			if($this->input->post('TrnxType'))
					$this->db->where('ldgr.debit_credit', $this->input->post('TrnxType'));
//			$this->db->where('ldgr.ledger_reference_table', '2');
			$this->db->select('ldgr.debit_credit, jrnl.journal_date_time TrnxDate, jrnl.attachments_count,jrnl.journal_id transaction_id,jrnl.journal_annual_voucher_id voucher_id, 2 AS ledgerType')
					 ->from('ledger ldgr')
					 ->join('journal jrnl','jrnl.journal_id = ldgr.transaction_id','left')
					 ->order_by('jrnl.journal_date_time','desc')
					 ->order_by('ldgr.ledger_id','desc');
		}else if($this->input->post('ledger_reference_table') == 1){
			if($this->input->post('bank_account_id'))
				$this->db->where('bank_book.bank_account_id', $this->input->post('bank_account_id'));
			if($this->input->post('FromDate'))
				$this->db->where('bank_book.date >=', $this->input->post('FromDate')." 00:00:00");
			if($this->input->post('ToDate'))
				$this->db->where('bank_book.date <=', $this->input->post('ToDate').' 23:59:59');
			if($this->input->post('TrnxType'))
					$this->db->where('bank_book.debit_credit', $this->input->post('TrnxType'));
			if($this->input->post('ClearanceStatus') || $this->input->post('ClearanceStatus') == '0')
				$this->db->where('bank_book.clearance_status', $this->input->post('ClearanceStatus'));
			$this->db->select('bank_book.*,bank_book.bank_annual_voucher_id voucher_id,  1 AS ledgerType, DATE_FORMAT(bank_book.date,"%d-%b-%Y %T") as TrnxDate,DATE_FORMAT(bank_book.clearance_date,"%d-%b-%Y") as TrnxClearance_date,'
					.'DATE_FORMAT(bank_book.instrument_date,"%d-%b-%Y") as TrnxInstrument_date,bank_account.account_number as account_number,'
					. 'round(bank_book.transaction_amount,2) as transaction_amount_ui, instrument_type.instrument_type instrument_type')
					->from('bank_book')
					->join('ledger ldgr',"ldgr.transaction_id=bank_book.transaction_id")
					->join('instrument_type','bank_book.instrument_type_id=instrument_type.instrument_type_id','left')
					->join('bank_account','bank_book.bank_account_id=bank_account.bank_account_id','left');
			
			$this->db->order_by('bank_book.date','desc')
				->order_by("bank_book.transaction_id", "desc");
		}
		$this->db->select('round(ldgr.amount,2) as amount, ldgr.narration as ledger_narration,ldgract.ledger_account_name,'
				.'ldgrsubact.ledger_sub_account_name, item.item_name, prjct.project_name,'
				. 'payer_party.party_name as payer_party_name, donor_party.party_name as donor_party_name,'
				. 'project.project_name project_name')
				->join('project','ldgr.project_id=project.project_id','left')
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
			if($search_by == "1" || $search_by == "7" || $search_by == "8")
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
			// ->limit("$this->return_size");
        $query = $this->db->get();
        // echo $this->db->last_query();
        $result = $query->result();
        return $result;
    }
	
}

