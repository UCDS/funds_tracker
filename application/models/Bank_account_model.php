<?php


class Bank_account_model extends CI_Model {
    
    private $return_size = 300;
    private $bank_account_information = array();
    
    function __construct() {
        parent::__construct();
        $post = (array)json_decode($this->security->xss_clean($this->input->raw_input_stream));

        if(key_exists('account_name', $post)){
            $this->bank_account_information['account_name'] = $post['account_name'];
        }
        if(key_exists('bank_account_id', $post)){
            $this->bank_account_information['bank_account_id'] = $post['bank_account_id'];
        }
        if(key_exists('account_id', $post)){
            $this->bank_account_information['account_id'] = key_exists('account_id', $post);
        }
        if(key_exists('bank_id', $post)){
            $this->bank_account_information['bank_id'] = $post['bank_id'];
        }
        if(key_exists('account_number', $post)){
            $this->bank_account_information['account_number'] = $post['account_number'];
        }
        if(key_exists('branch', $post)){
            $this->bank_account_information['branch'] = $post['branch'];
        }
        if(key_exists('location', $post)){
            $this->bank_account_information['location'] = $post['location'];
        }
        if(key_exists('ifsc_code', $post)){
            $this->bank_account_information['ifsc_code'] = $post['ifsc_code'];
        }
        if(key_exists('micr_code', $post)){
            $this->bank_account_information['micr_code'] = $post['micr_code'];
        }
        if(key_exists('swift_code', $post)){               // This is required for international payments
            $this->bank_account_information['swift_code'] = $post['swift_code'];
        }
        if(key_exists('party_id', $post)){
            $this->bank_account_information['party_id'] = $post['party_id'];
        }
        if(key_exists('bank_book', $post)){
            $this->bank_account_information['bank_book'] = $post['bank_book'];
        }
        
//        $this->bank_account_information['insert_date_time'] = 'Time here';
//        $this->bank_account_information['user_id'] = 'User ID here';        
    }
    
    function add_bank_account(){
		if(key_exists('bank_account_id', $this->bank_account_information)){
			$this->db->where('bank_account_id',$this->bank_account_information['bank_account_id']);
			unset($this->bank_account_information['bank_account_id']);
			$this->db->update('bank_account',$this->bank_account_information);
			return true;
		}else{
			$this->db->insert('bank_account', $this->bank_account_information);        
			return $this->db->insert_id();
		}
    }
    /*
    
    function update_bank_account(){        
        $bank_account_id = -1;                  // Non existent bank account id.
        $backup_information = array();
        //Checking for the existance of key paramter needed for the update.
        //Also getting the old record to create a edit log.
        if(key_exists('bank_account_id', $this->bank_account_information)){
            $bank_account_id = $post['bank_account_id'];
            //Get the previous record.
            $this->db->select('*')
                    ->from('bank_account')
                    ->where('bank_account_id', $bank_account_id);
            $query = $this->db->get();            
            $backup_information['trail'] = $query->result();            
            //Check for the existence of previous record.
            if(sizeof($backup_information) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }
            $backup_information['trail'] = jason_encode($backup_information['trail'][0]);
            $backup_information['table_name'] = 'bank_account';
        }else{
            return -2;                          // Flag indicating that a key parameter for the where condition is not set. In this case the bank_account_id.
        }        
        
        $this->db->trans_start();
        $this->db->where('bank_account_id', $bank_account_id);
        $this->db->
        $this->db->insert('edit_log', $backup_information);
        $this->db->trans_complete();
        
        if($this->db->trans_status === FALSE){
            return -1;          // Flag indicating that there was a database error.
        }else{
            $this->db->select('*')
                    ->from('bank_account')
                    ->where('bank_account_id', $bank_account_id);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
    }
    */
    
    function get_bank_accounts(){
        if(key_exists('bank_account_id', $this->bank_account_information)){
            $bank_account_id = $this->bank_account_information['bank_account_id'];
            
            $this->db->select('bank_account.*,party.party_name party_name, bank.bank_name bank_name')
                    ->from('bank_account')
					->join('party','bank_account.party_id=party.party_id','left')
					->join('bank','bank_account.bank_id=bank.bank_id','left')
					->order_by('account_name',"asc")
                    ->where('bank_account_id', $bank_account_id);
            $query = $this->db->get();
            $result = $query->result();            
            //Check for the existence of record.
            if(sizeof($result) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }else{
                return $result;
            }            
        }
        
        $this->db->select('bank_account.*,party.party_name party_name, bank.bank_name bank_name')
                ->from('bank_account')
				->join('party','bank_account.party_id=party.party_id','left')
				->join('bank','bank_account.bank_id=bank.bank_id','left')
        //        ->where($this->bank_account_information)
				->order_by('account_name',"asc")
                ->limit("$this->return_size");
        $query = $this->db->get();
        
        $result = $query->result();
 
        return $result;
    }
    function search_bank_accounts(){
		$bank_account_name = key_exists('account_name', $this->bank_account_information) ? $this->bank_account_information['account_name'] : "";
		$bank_account_number = key_exists('account_number', $this->bank_account_information) ? $this->bank_account_information['account_number'] : "";

		$this->db->select('bank_account.*,party.party_name party_name, bank.bank_name bank_name')
				->from('bank_account')
				->join('party','bank_account.party_id=party.party_id','left')
				->join('bank','bank_account.bank_id=bank.bank_id','left')
				->like('bank_account.account_name', $bank_account_name)
				->like('bank_account.account_number', $bank_account_number)
				->order_by('account_name',"asc");
		$query = $this->db->get();            
		$result = $query->result();            
		//Check for the existence of record.
		return $result;

	}// search_bank_accounts

	function get_bank_book_accounts(){

		$this->db->select('bank_account.*,party.party_name party_name, bank.bank_name bank_name')
				->from('bank_account')
				->join('party','bank_account.party_id=party.party_id','left')
				->join('bank','bank_account.bank_id=bank.bank_id','left')
				->order_by('account_name')
				->where('bank_book', 1);
		$query = $this->db->get();            
        $result = $query->result();
		return $result;
	}
	
//	function get_bank_book_accounts_details(){
//
//		$query = $this->db->query("select bankacnt.bank_account_id,bankacnt.party_id,bankacnt.account_number,bankacnt.account_name,tempparty.party_name party_name, tempbank.bank_name bank_name,
//
//(select round(balance,2) from bank_book where bank_account_id = bankacnt.bank_account_id  order by bank_book.date desc limit 1 ) as bankbookbalane,
//(select max(last_upate_date_time) from bank_book where bank_account_id = bankacnt.bank_account_id ) as lastupatedatetime,
//
//(select round(statement_balance,2) from bank_book where bank_account_id = bankacnt.bank_account_id  order by bank_book.date desc limit 1 ) as bankbookstatementbalane,
//
//(select count(*) from bank_book where bank_account_id = bankacnt.bank_account_id and clearance_status = 0 and debit_credit = 'Debit' ) as debit_non_cleared_cnt,
//
//
//(select cast(sum(transaction_amount) as decimal(10,2)) from bank_book where bank_account_id = bankacnt.bank_account_id and clearance_status = 0 and debit_credit = 'Debit' ) as debit_non_cleared_amonut,
//
//(select count(*) from bank_book where bank_account_id = bankacnt.bank_account_id and clearance_status = 0 and debit_credit = 'Credit' ) as credit_non_cleared_amonut,
//
//
//(select cast(sum(transaction_amount) as decimal(10,2)) from bank_book where bank_account_id = bankacnt.bank_account_id and clearance_status = 0 and debit_credit = 'Credit' ) as credit_non_cleared_amonut
//
//from
//
//(select * from bank_account /*whr cls*/) bankacnt
//left join party tempparty on tempparty.party_id = bankacnt.party_id
//left join bank tempbank on tempbank.bank_id= bankacnt.bank_id");
//		
//	/*$this->db->select('bank_account.account_name, bank_account.account_number'
//				. ',bank_account.bank_account_id,bank_account.bank_id'
//				. ',party.party_name party_name, bank.bank_name bank_name, bank_book.balance, bank_book.statement_balance,'
//				. 'bank_book.transaction_amount,bank_book.clearance_status, '
//				. 'SUM(CASE WHEN clearance_status=0 AND debit_credit="Debit" THEN transaction_amount ELSE 0 END) as total_debits,'
//				. 'SUM(CASE WHEN clearance_status=0 AND debit_credit="Debit" THEN 1 ELSE 0 END) as count_debits,'
//				. 'SUM(CASE WHEN clearance_status=0 AND debit_credit="Credit" THEN transaction_amount ELSE 0 END) as total_credits,'
//				. 'SUM(CASE WHEN clearance_status=0 AND debit_credit="Credit" THEN 1 ELSE 0 END) as count_credits,'
//				. 'MAX(date)')
//				->from('bank_account')
//				->join('party','bank_account.party_id=party.party_id','left')
//				->join('bank', 'bank_account.bank_id=bank.bank_id','left')
//				->join('bank_book','bank_account.bank_account_id=bank_book.bank_account_id','left')
//				->group_by('bank_book.bank_account_id')
//				->order_by('account_name')
//				->where('bank_book', 1);
////	*/	
////		$query = $this->db->get();
//        $result = $query->result();
//		return $result;
//	}
    
	
	function get_bank_book_accounts_details(){

		$this->db->select('bank_account.account_name, bank_account.account_number'
				. ',bank_account.bank_account_id,bank_account.bank_id'
				. ',party.party_name party_name, bank.bank_name bank_name,'
				. 'bb.transaction_amount,bb.clearance_status, '
				. 'ROUND(SUM(CASE WHEN clearance_status=0 AND debit_credit="Debit" THEN transaction_amount ELSE 0 END),2) as total_debits,'
				. 'SUM(CASE WHEN clearance_status=0 AND debit_credit="Debit" THEN 1 ELSE 0 END) as count_debits,'
				. 'ROUND(SUM(CASE WHEN clearance_status=0 AND debit_credit="Credit" THEN transaction_amount ELSE 0 END),2) as total_credits,'
                . 'SUM(CASE WHEN clearance_status=0 AND debit_credit="Credit" THEN 1 ELSE 0 END) as count_credits,'
                . 'SUM(CASE WHEN debit_credit="Credit" THEN transaction_amount ELSE transaction_amount*-1 END) as balance,'
                . 'SUM(CASE WHEN clearance_status=1 AND debit_credit="Credit" THEN transaction_amount 
                    WHEN clearance_status=1 and debit_credit="Debit" THEN transaction_amount*-1  END) as statement_balance,'
				. 'DATE_FORMAT( MAX(bb.last_upate_date_time), "%d-%b-%Y %H:%i:%S" ) lastupatedatetime')
				->from('bank_account')
				->join('party','bank_account.party_id=party.party_id','left')
				->join('bank', 'bank_account.bank_id=bank.bank_id','left')
				->join('bank_book bb','bank_account.bank_account_id=bb.bank_account_id','left')
				->group_by('bank_account.bank_account_id')
//				->having('')
				->order_by('account_name')
				->where('bank_book', 1);
		$query = $this->db->get();
		// echo $this->db->last_query();
        $result = $query->result();
		return $result;
	}

}

?>