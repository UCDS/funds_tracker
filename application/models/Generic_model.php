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
}
