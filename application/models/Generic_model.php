<?php


class Generic_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    function get_items_list(){
        
        $this->db->select('*')
                ->from('item');
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }
    function get_ledger_accounts_list(){
        $this->db->select('*')
                ->from('ledger_account');
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }
	function get_ledger_sub_accounts_list(){
		$this->db->select('*')
                ->from('ledger_sub_account');
        $query = $this->db->get();

        $result = $query->result();
        return $result;
	}
	
	function updateAnnualVoucherIDs(){
		// $db = $this->load->database('default',TRUE);
		$query = $this->db->query("call updateAnnualVoucherID()");
		//echo $db->_error_message();
		$res = $query->result_array();
		$query->next_result(); 
		$query->free_result(); 
		if (count($res) > 0) {
			  return $res;
		} else {
			  return 0;
		}
	}

	function updateAnnualJournalVoucherIDs(){
		// $db = $this->load->database('default',TRUE);
		$query = $this->db->query("call updateJournalAnnualVoucherID()");
		//echo $db->_error_message();
 		$res = $query->result_array();
		$query->next_result(); 
		$query->free_result(); 
		if (count($res) > 0) {
			  return $res;
		} else {
			  return 0;
		}
	}

	function get_ledger_opening_balance_list() 
	{
		if($this->input->post('date'))
		{
			$from_date  = $this->input->post('date');
		}else{
			$from_date = date('Y-m-d');
		}
		 
		$this->db->select('
			lob.*, 
			u.user_name, 
			u.name, 
			updated_by.user_name as updated_username,
			updated_by.name as updated_by_name,
			la.ledger_account_name, 
			la.account_type
		');
		$this->db->from('ledger_opening_balance lob');
		$this->db->join('user u', 'u.user_id = lob.insert_by', 'left');
		$this->db->join('user updated_by', 'updated_by.user_id = lob.update_by', 'left');
		$this->db->join('ledger_account la', 'la.ledger_account_id = lob.ledger_account_id', 'left');
		$this->db->where('lob.date',$from_date);
		$this->db->order_by('lob.date','DESC');
		$ledger_query = $this->db->get();
    	$ledger_results = $ledger_query->result();

		$bank_query = $this->db->select('
            lob.*, 
            u.user_name, 
            u.name, 
            updated_by.user_name as updated_username,
            updated_by.name as updated_by_name,
            ba.account_name as ledger_account_name
        ')
        ->from('ledger_opening_balance lob')
        ->join('user u', 'u.user_id = lob.insert_by', 'left')
        ->join('user updated_by', 'updated_by.user_id = lob.update_by', 'left')
        ->join('bank_account ba', 'ba.bank_account_id = (lob.ledger_account_id - 1000)', 'inner')
        ->where('lob.date', $from_date)
        ->where('lob.ledger_account_id >=', 1001)
        ->order_by('lob.date', 'DESC')
        ->get();

		$bank_results = $bank_query->result();

		foreach ($bank_results as &$bank) {
			$bank->account_type = 'Assets';
		}

		return array_merge($ledger_results, $bank_results);
	}

	function get_bank_opening_balances()
	{
		$this->db->select('lob.ledger_account_id,lob.balance,ba.account_name,lob.balance_type');
		$this->db->from('ledger_opening_balance lob');
		$this->db->join('bank_account ba', 'lob.ledger_account_id = (ba.bank_account_id + 1000)');
		
		$ledger_query = $this->db->get();
		return $ledger_query->result();
	}
}
