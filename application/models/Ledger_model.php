<?php


class Ledger_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    function get_ledger_transactions($transactionID){

		$this->db->where('transaction_id',$transactionID);
        $this->db->select('*,round(amount,2) as amount,ldgr.narration,ldgract.ledger_account_name,ldgrsubact.ledger_sub_account_name, item.item_name, prjct.project_name,payer_party.party_name as payer_party_name, donor_party.party_name as donor_party_name')
				->from('ledger ldgr')
				->join('ledger_account ldgract',"ldgract.ledger_account_id=ldgr.ledger_account_id",'left')
				->join('ledger_sub_account ldgrsubact',"ldgrsubact.ledger_sub_account_id=ldgr.ledger_sub_account_id",'left')
				->join('item',"item.item_id=ldgr.item_id",'left')
				->join('project prjct',"prjct.project_id=ldgr.project_id",'left')
				->join('party payer_party',"payer_party.party_id=ldgr.payee_party_id",'left')
				->join('party donor_party',"donor_party.party_id=ldgr.donor_party_id",'left');
				
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }
	
	function delete_ledger_transaction($ledger_id){
		$this->db->where('ledger_id',$ledger_id);
		$this->db->delete('ledger');
        
	}
}
