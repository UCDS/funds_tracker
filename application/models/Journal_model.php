<?php

class Journal_model extends CI_Model{

    private $return_size = 3000;
    private $journal_information = array();

    function __construct() {
        parent::__construct();
        
        if($this->input->post('journal_date_time')){
            $this->journal_information['journal_date_time'] = $this->input->post('journal_date_time');
        }
        if($this->input->post('journal_narration')){
            $this->journal_information['journal_narration'] = $this->input->post('journal_narration');
        }
		if($this->input->post('journal_id')){
			$this->journal_information['journal_id'] = $this->input->post('journal_id');
		}
    }
	
	function addJournalTransaction(){
        if(key_exists('journal_id',$this->journal_information)){
			$this->db->where('journal_id',$this->journal_information['journal_id']);
            // unset($this->journal_information['journal_id']);
            $this->db->update('journal',$this->journal_information);
			return $this->journal_information['journal_id'];
		}
		else{
			///
			/// Get Journal Annual Voucher ID for this financial Year
			///
			$voucherID = $this->get_journal_annual_voucher_id( strtotime($this->journal_information['journal_date_time']) );
			$this->journal_information['journal_annual_voucher_id'] = $voucherID;
			$this->db->insert('journal', $this->journal_information);
			return $this->db->insert_id();
		}
	}
	
	function get_journal_annual_voucher_id($time){
		if(date('m',$time) <= 3){
			$this->db->where('journal_date_time between "'.(date('Y',$time)-1).'-04-01 00:00:00" and "'.date('Y',$time).'-03-31 23:59:59"');
		}else{
			$this->db->where('journal_date_time between "'.date('Y',$time).'-04-01 00:00:00" and "'. (date('Y',$time)+1) .'-03-31 23:59:59"');
		}
		$this->db->select('max(`journal_annual_voucher_id`) as journal_annual_voucher_id')
			->from('journal');
		
		$query = $this->db->get();
		$result = $query->result();
		return (sizeof($result) > 0 ? $result[0]->journal_annual_voucher_id+1 : 0);
	}
    
	function searchJournalTransactions(){
		if($this->input->post('fromdate'))
			$this->db->where('journal.journal_date_time >=', $this->input->post('fromdate')." 00:00:00");
		if($this->input->post('todate'))
			$this->db->where('journal.journal_date_time <=', $this->input->post('todate')." 23:59:59");
			$this->db->where('ldgr.ledger_reference_table', 2);

		$this->db->select('journal.journal_id, journal.journal_annual_voucher_id, journal.journal_date_time,journal.journal_narration,journal.attachments_count,'
				. 'ldgr.debit_credit,ldgr.narration,round(ldgr.amount,2) amount, ldgr.ledger_id, ldgr.project_id, '
				. 'ldgr.ledger_account_id,ldgr.ledger_sub_account_id,ldgr.payee_party_id, ldgr.item_id, ldgr.donor_party_id, '
				. ' pp.party_name payee_party, dp.party_name donor_party,'
				. 'project.project_name, ldgract.ledger_account_name, ldgrsubact.ledger_sub_account_name,itm.item_name')
                ->from('journal')
				->join('ledger ldgr','ldgr.transaction_id=journal.journal_id')
				->join('party pp','ldgr.payee_party_id=pp.party_id','left')
				->join('party dp','ldgr.donor_party_id=dp.party_id','left')
				->join('ledger_account ldgract','ldgr.ledger_account_id=ldgract.ledger_account_id','left')
				->join('ledger_sub_account ldgrsubact','ldgr.ledger_sub_account_id=ldgrsubact.ledger_sub_account_id','left')
				->join('project','ldgr.project_id=project.project_id','left')
				->join('item itm','ldgr.item_id=itm.item_id','left')
				->order_by("journal.journal_date_time", "desc")
				->order_by("journal.journal_id", "desc");
		        
		

        $query = $this->db->get();
		//echo $this->db->last_query();
        $result = $query->result();
        return $result;
	}
	
	function getJournalTransactions($journalID){
		$this->db->select('journal.journal_id, journal.journal_annual_voucher_id, journal.journal_date_time, DATE_FORMAT(journal.journal_date_time, "%d-%b-%Y") journal_date_time_ui, journal.journal_narration,journal.attachments_count')
                ->from('journal')
				->join('ledger ldgr','ldgr.transaction_id=journal.journal_id');
		
		$this->db->where('journal.journal_id', $journalID);
		$this->db->where('ldgr.ledger_reference_table', '2');
		$query = $this->db->get();
		$result = $query->result();
		return (sizeof($result) > 0 ? $result[0] : null);
	}
	function getJournalLedgerTransactions($journalID){
		$this->db->select('ldgr.debit_credit,ldgr.narration,round(ldgr.amount,2) amount, ldgr.ledger_id, ldgr.project_id, '
				. 'ldgr.ledger_account_id,ldgr.ledger_sub_account_id,ldgr.payee_party_id, ldgr.item_id, ldgr.donor_party_id, '
				. 'pp.party_name payee_party, dp.party_name donor_party,'
				. 'project.project_name, ldgract.ledger_account_name, ldgrsubact.ledger_sub_account_name,itm.item_name')
				->from('ledger ldgr')
				->join('party pp','ldgr.payee_party_id=pp.party_id','left')
				->join('party dp','ldgr.donor_party_id=dp.party_id','left')
				->join('ledger_account ldgract','ldgr.ledger_account_id=ldgract.ledger_account_id','left')
				->join('ledger_sub_account ldgrsubact','ldgr.ledger_sub_account_id=ldgrsubact.ledger_sub_account_id','left')
				->join('project','ldgr.project_id=project.project_id','left')
				->join('item itm','ldgr.item_id=itm.item_id','left');
		$this->db->where('ldgr.transaction_id', $journalID);
		$this->db->where('ldgr.ledger_reference_table', '2');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
}
?>
