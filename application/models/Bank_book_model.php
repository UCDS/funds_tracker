<?php

class Bank_book_model extends CI_Model{

    private $return_size = 3000;
    private $bank_book_information = array();

    function __construct() {
        parent::__construct();
        
        if($this->input->post('account_id')){
            $this->bank_book_information['bank_account_id'] = $this->input->post('account_id');
        }
        if($this->input->post('debit_credit')){         //Values DEBIT, CREDIT
            $this->bank_book_information['debit_credit'] = $this->input->post('debit_credit');
        }
        if($this->input->post('date')){
            $this->bank_book_information['date'] = $this->input->post('date');
        }
        if($this->input->post('party_id')){             //Party table.
            $this->bank_book_information['party_id'] = $this->input->post('party_id');
        }
        if($this->input->post('narration')){
            $this->bank_book_information['narration'] = $this->input->post('narration');
        }
        if($this->input->post('instrument_id_manual')){
            $this->bank_book_information['instrument_id_manual'] = $this->input->post('instrument_id_manual');
        }
        if($this->input->post('instrument_type_id')){
            $this->bank_book_information['instrument_type_id'] = $this->input->post('instrument_type_id');
        }
        if($this->input->post('instrument_id')){
            $this->bank_book_information['instrument_id'] = $this->input->post('instrument_id');
        }
        if($this->input->post('instrument_date')){
            $this->bank_book_information['instrument_date'] = $this->input->post('instrument_date');
        }
        if($this->input->post('bank_id')){
            $this->bank_book_information['bank_id'] = $this->input->post('bank_id');
        }
        if($this->input->post('transaction_amount')|| $this->input->post('transaction_amount') == 0){
            $this->bank_book_information['transaction_amount'] = $this->input->post('transaction_amount');
        }
        if($this->input->post('clearance_status')){         // Values YES or NO
            $this->bank_book_information['clearance_status'] = $this->input->post('clearance_status');
        }else{
			
            $this->bank_book_information['clearance_status'] = 0;
		}
        if($this->input->post('clearance_date')){
            $this->bank_book_information['clearance_date'] = $this->input->post('clearance_date');
        }
        if($this->input->post('bill_recieved')){        // Values YES or NO
            $this->bank_book_information['bill_recieved'] = $this->input->post('bill_recieved');
        }else{
            $this->bank_book_information['bill_recieved'] = 0;
		}
        if($this->input->post('notes')){
            $this->bank_book_information['notes'] = $this->input->post('notes');
        }
        if($this->input->post('project_id')){
            $this->bank_book_information['project_id'] = $this->input->post('project_id');
        }
//        $this->bank_book_information['insert_date_time'] = 'Time here';
//        $this->bank_book_information['user_id'] = 'User ID here';
		if($this->input->post('transaction_id')){
			$this->bank_book_information['transaction_id'] = $this->input->post('transaction_id');
		}
    }
    
	/**
	 * To get Present statement_balance of specified account.
	 * 
	 * If $transactionTime is present, account balance before or equal to that transaction with maximum of transaction id will be returned.
	 * 
	 * 
	 * @param type $accountID
	 * @param type $transactionTime
	 * @return 
	 */
	private function get_account_balance($accountID,$transactionTime=0){
		if($accountID){
			$this->db->where('bank_account_id',$accountID);
			if($transactionTime){
				$this->db->where('date <= ',$transactionTime);
			}
			$this->db->select('bank_book.balance,bank_book.statement_balance')
			->from('bank_book')
			->order_by("bank_book.date", "desc")
			->order_by("bank_book.transaction_id", "desc")
			->limit("1");
			$query = $this->db->get();
			$result = $query->result();
            return (sizeof($result) > 0 ? $result[0] : null);
		}
		return null;
	}// get_account_balance
	
	function get_annual_voucher_id($time){
		if(date('m',$time) <= 3){
			$this->db->where('date between "'.(date('Y',$time)-1).'-04-01 00:00:00" and "'.date('Y',$time).'-03-31 23:59:59"');
		}else{
			$this->db->where('date between "'.date('Y',$time).'-04-01 00:00:00" and "'. (date('Y',$time)+1) .'-03-31 23:59:59"');
		}
		$this->db->select('max(`bank_annual_voucher_id`) as bank_annual_voucher_id')
			->from('bank_book');
		
		$query = $this->db->get();
		$result = $query->result();
		return (sizeof($result) > 0 ? $result[0]->bank_annual_voucher_id+1 : 0);
	}
	
	/**
	 * To get trasaction details of specified transaction id.
	 * 
	 * If $transactionID is present, account balance before that transaction will be returned.
	 * 
	 * 
	 * @param type $accountID
	 * @param type $transactionTime
	 * @return account_balance or null
	 */
	function get_transaction($transactionID){
		if($transactionID){
			$this->db->where('transaction_id',$transactionID);
			$this->db->select('bank_book.*, DATE_FORMAT(date, "%d-%b-%Y") trnx_date,round(bank_book.balance,2) as balance_ui,'
				. 'round(bank_book.statement_balance,2) as statement_balance_ui,'
				. 'round(bank_book.transaction_amount,2) as transaction_amount_ui,party.party_name party_name, bank.bank_name bank_name,'
				. 'bank_account.account_number, bank_account.account_name, instrument_type.instrument_type instrument_type,'
				. 'project.project_name project_name')
			->from('bank_book')
			->join('party','bank_book.party_id=party.party_id','left')
			->join('instrument_type','bank_book.instrument_type_id=instrument_type.instrument_type_id','left')
			->join('project','bank_book.project_id=project.project_id','left')
			->join('bank_account','bank_book.bank_account_id=bank_account.bank_account_id','left')
			->join('bank','bank_account.bank_id=bank.bank_id','left');
			$query = $this->db->get();
			$result = $query->result();
            return (sizeof($result) > 0 ? $result[0] : null);
		}
		return null;
	}// get_account_balance
	
	/**
	 * To add and update a transaction
	 * 
	 * @return boolean
	 */
    function add_transaction(){
		$present_tran_bal = floatval($this->bank_book_information['transaction_amount']);
		///
		/// Check whether transaction_id is exist in post request or not. If present update the record if not presend insert.
		///
		if(key_exists('transaction_id', $this->bank_book_information)){
			
			
			$transactionDetails = $this->get_transaction($this->bank_book_information['transaction_id']);
			if($transactionDetails != null){
				$amountChage = false;
				$clearanceChange = false;
				$dateChange = false;
				
				///
				/// Check which fields are changed
				///
				if($this->bank_book_information['date'] != $transactionDetails->date){
					$dateChange = true;
				}
				if($this->bank_book_information['transaction_amount'] != $transactionDetails->transaction_amount){
					$amountChage = true;
				}
				if($this->bank_book_information['clearance_status'] != $transactionDetails->clearance_status){
					$clearanceChange = true;
				}
				
				$account_bal = $transactionDetails->balance;
				$account_stat_bal = $transactionDetails->statement_balance;
				
				if( $clearanceChange == true){
					if($transactionDetails->clearance_status == 0){
						// means clearance status changed from no to yes
						if($this->bank_book_information["debit_credit"] == "Credit"){
							// $account_bal = $transactionDetails->balance + $transactionDetails->transaction_amount;
							$account_stat_bal = $transactionDetails->statement_balance + $transactionDetails->transaction_amount;
						}else if($this->bank_book_information["debit_credit"] == "Debit"){
							$account_stat_bal = $transactionDetails->statement_balance - $transactionDetails->transaction_amount;
						}
					}else{
						// means clearance status changed from yes to no
						if($this->bank_book_information["debit_credit"] == "Credit"){
							// $account_bal = $transactionDetails->balance - $transactionDetails->transaction_amount;
							$account_stat_bal = $transactionDetails->statement_balance - $transactionDetails->transaction_amount;
						}else if($this->bank_book_information["debit_credit"] == "Debit"){
							$account_stat_bal = $transactionDetails->statement_balance + $transactionDetails->transaction_amount;
						}
					}
				}

				if( $amountChage == true){
					$amountdiff = 0;
					if($this->bank_book_information["debit_credit"] == "Credit"){
						$amountdiff = $transactionDetails->transaction_amount - floatval($this->bank_book_information['transaction_amount']);
						$account_bal = $account_bal - $amountdiff;
						if($this->bank_book_information['clearance_status'] == 1){
							$account_stat_bal = $account_stat_bal - $amountdiff;
						}
					}
					else if($this->bank_book_information["debit_credit"] == "Debit"){
						$amountdiff = floatval($this->bank_book_information['transaction_amount']) - $transactionDetails->transaction_amount;
						$account_bal = $account_bal - $amountdiff;
						if($this->bank_book_information['clearance_status'] == 1){
							$account_stat_bal = $account_stat_bal - $amountdiff;
						}
					}
				}

				$account_bal_diff = $account_bal - $transactionDetails->balance;
				$account_stat_bal_diff = $account_stat_bal - $transactionDetails->statement_balance;

				$this->bank_book_information["balance"] = $account_bal;
				$this->bank_book_information["statement_balance"] = $account_stat_bal;
				$this->bank_book_information["last_upate_date_time"] = date("Y-m-d H:i:s");
				$transactionID = $this->bank_book_information['transaction_id'];
				$this->db->where('transaction_id',$this->bank_book_information['transaction_id']);
				unset($this->bank_book_information['transaction_id']);
				$this->db->update('bank_book',$this->bank_book_information);
				// echo $this->db->last_query();

				/**
				* Update balances of transactions with date and time greater than updated transactionn
				*/
				if($account_bal_diff != 0 ){
					$this->db->set('balance',"`balance` + " . sprintf("%.2f",$account_bal_diff) ,false);
				}
				if($account_stat_bal_diff != 0){
					$this->db->set('statement_balance',"`statement_balance` +  ". sprintf("%.2f",$account_stat_bal_diff),false);
				}

				if($account_bal_diff != 0  || $account_stat_bal_diff != 0){
					$this->db->where('bank_account_id', $this->bank_book_information['bank_account_id']);
					$this->db->where('date > ', $this->bank_book_information['date']);
					$this->db->update('bank_book');

					/**
					 * Update transactions with same date and time with transaction id grater than updated transaction
					 */
					if($account_bal_diff != 0 ){
						$this->db->set('balance',"`balance` + ". sprintf("%.2f",$account_bal_diff),false);
					}
					if($account_stat_bal_diff != 0){
						$this->db->set('statement_balance',"`statement_balance` + ". sprintf("%.2f",$account_stat_bal_diff),false);
					}

					$this->db->where('transaction_id > ',$transactionID);
					$this->db->where('bank_account_id', $this->bank_book_information['bank_account_id']);
					$this->db->where('date = ', $this->bank_book_information['date']);
					$this->db->update('bank_book');
				}
				return $transactionID;
			}else{
				return false;
			}
		}else{
			
			///
			/// Get Present account balance from database
			///
			$account_balances = $this->get_account_balance($this->bank_book_information['bank_account_id'], $this->bank_book_information['date']);
			
			///
			/// Get Annual Voucher ID for this financial Year
			///
			$voucherID = $this->get_annual_voucher_id( strtotime($this->bank_book_information['date']) );
			$account_stat_bal = 0;
			$account_bal = 0;
			if($account_balances != null){
				$account_stat_bal = $account_balances->statement_balance;
				$account_bal = $account_balances->balance;
			}
			$balance = 0.00;
			$statement_balance = 0.00;
			

			if($this->bank_book_information["debit_credit"] == "Credit"){
				//$balance = $account_bal;
				$balance = $account_bal + $present_tran_bal;
				$statement_balance = $account_stat_bal;

				if( key_exists('clearance_status', $this->bank_book_information) && $this->bank_book_information["clearance_status"] == "1"){
					$statement_balance = $account_stat_bal + $present_tran_bal;
				}
			}else if($this->bank_book_information["debit_credit"] == "Debit"){
				$balance = $account_bal - $present_tran_bal;
				$statement_balance = $account_stat_bal;

				if( key_exists('clearance_status', $this->bank_book_information) && $this->bank_book_information["clearance_status"] == "1"){
					$statement_balance = $account_stat_bal - $present_tran_bal;
				}

			}
			$this->bank_book_information["bank_annual_voucher_id"] = $voucherID;
			$this->bank_book_information["balance"] = $balance;
			$this->bank_book_information["statement_balance"] = $statement_balance;

			$this->db->trans_start();
			///
			/// Insert record into database
			///
			$this->db->insert('bank_book', $this->bank_book_information);
			$insertID = $this->db->insert_id();

			///
			/// If prev balance and present statement_balance are not equal then update all transactions done after this transaction date
			///
			if($account_bal != $balance){
				if($this->bank_book_information["debit_credit"] == "Debit"){
					$this->db->set('balance',"`balance` -". sprintf("%.2f",$this->bank_book_information['transaction_amount']),false);
				}
				else if($this->bank_book_information["debit_credit"] == "Credit"){
					$this->db->set('balance',"`balance` +". sprintf("%.2f",$this->bank_book_information['transaction_amount']),false);
				}
			}
			if(key_exists('clearance_status', $this->bank_book_information) && $this->bank_book_information["clearance_status"] == "1" && $account_stat_bal != $statement_balance){
				if($this->bank_book_information["debit_credit"] == "Credit"){
					$this->db->set('statement_balance',"`statement_balance` +".sprintf("%.2f",$this->bank_book_information['transaction_amount']),false);
				}else if($this->bank_book_information["debit_credit"] == "Debit"){
					$this->db->set('statement_balance',"`statement_balance` -".sprintf("%.2f",$this->bank_book_information['transaction_amount']),false);
				}
			}
			
			if(( $account_bal != $balance )|| (key_exists('clearance_status', $this->bank_book_information) && $this->bank_book_information["clearance_status"] == "1" && $account_stat_bal != $statement_balance))
			{
				$this->db->where('bank_account_id', $this->bank_book_information['bank_account_id']);
				$this->db->where('date > ', $this->bank_book_information['date']);
				$this->db->update('bank_book'); 

				/**
				* Update transactions with same date and time with transaction id grater than updated transaction
				*/
				if($account_bal != $balance){
					if($this->bank_book_information["debit_credit"] == "Debit"){
						$this->db->set('balance',"`balance` -". sprintf("%.2f",$this->bank_book_information['transaction_amount']),false);
					}
					else if($this->bank_book_information["debit_credit"] == "Credit"){
						$this->db->set('balance',"`balance` +". sprintf("%.2f",$this->bank_book_information['transaction_amount']),false);
					}
				}
				if(key_exists('clearance_status', $this->bank_book_information) && $this->bank_book_information["clearance_status"] == "1" && $account_stat_bal != $statement_balance){
					if($this->bank_book_information["debit_credit"] == "Credit"){
						$this->db->set('statement_balance',"`statement_balance` +".sprintf("%.2f",$this->bank_book_information['transaction_amount']),false);
					}else if($this->bank_book_information["debit_credit"] == "Debit"){
						$this->db->set('statement_balance',"`statement_balance` -".sprintf("%.2f",$this->bank_book_information['transaction_amount']),false);
					}
				}
				$this->db->where('transaction_id > ',$insertID);
				$this->db->where('bank_account_id', $this->bank_book_information['bank_account_id']);
				$this->db->where('date = ', $this->bank_book_information['date']);
				$this->db->update('bank_book'); 
			}
			$this->db->trans_complete();
			return $insertID;
		}
    }// add_transaction
    
    function update_transaction(){
        $transaction_id = -1;                  // Non existent transaction id.
        $backup_information = array();
		///
        ///Checking for the existance of key paramter needed for the update.
        ///Also getting the old record to create a edit log.
		///
        if(key_exists('transaction_id', $this->bank_book_information)){
            $transaction_id = $post['transaction_id'];
            //Get the previous record.
            $this->db->select('*')
                    ->from('bank_book')
                    ->where('transaction_id', $transaction_id);
            $query = $this->db->get();            
            $backup_information['trail'] = $query->result();            
            //Check for the existence of previous record.
            if(sizeof($backup_information) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }
            $backup_information['trail'] = jason_encode($backup_information['trail'][0]);
            $backup_information['table_name'] = 'bank_book';
        }else{
            return -2;                          // Flag indicating that a key parameter for the where condition is not set. In this case the bank_account_id.
        }
        
        $this->db->trans_start();
        $this->db->where('bank_book', $this->bank_book_information);
        $this->db->insert('edit_log', $backup_information);
        $this->db->trans_complete();
        
        if($this->db->trans_status === FALSE){
            return -1;          // Flag indicating that there was a database error.
        }else{
            $this->db->select('*')
                    ->from('bank_book')
                    ->where('transaction_id', $transaction_id);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
    }// update_transaction
    
	/**
	 * 
	 * To get transactions of a specified account between two dates
	 * 
	 * @param type $account_id_get
	 * @return 
	 */
	function search_bank_books($account_id_get){
		if($account_id_get)
			$this->db->where('bank_book.bank_account_id', $account_id_get);
		if($this->input->post('fromdate'))
			$this->db->where('bank_book.date >=', $this->input->post('fromdate')." 00:00:00");
		if($this->input->post('todate'))
			$this->db->where('bank_book.date <=', $this->input->post('todate')." 23:59:59");
		if($this->input->post('clearancestatus') || $this->input->post('clearancestatus') == '0'){
			$this->db->where('bank_book.clearance_status', $this->input->post('clearancestatus'));
			if($this->input->post('TranxType'))
				$this->db->where('bank_book.debit_credit', $this->input->post('TranxType'));
		}

		$this->db->select('bank_book.*,round(bank_book.balance,2) as balance_ui,'
				. 'round(bank_book.statement_balance,2) as statement_balance_ui,'
				. 'round(bank_book.transaction_amount,2) as transaction_amount_ui,party.party_name party_name, bank.bank_name bank_name,'
					. 'instrument_type.instrument_type instrument_type,'
					. 'project.project_name project_name, bank_account.account_number')
                ->from('bank_book')
				->join('party','bank_book.party_id=party.party_id','left')
				->join('instrument_type','bank_book.instrument_type_id=instrument_type.instrument_type_id','left')
				->join('project','bank_book.project_id=project.project_id','left')
				->join('bank','bank_book.bank_id=bank.bank_id','left')
				->join('bank_account','bank_book.bank_account_id=bank_account.bank_account_id','left')
				->order_by("bank_book.date", "desc")
				->order_by("bank_book.transaction_id", "desc")
		        ->limit("$this->return_size");
		
		
		if($account_id_get){
		}else{
			if($this->input->post('TranxType'))
				$this->db->where("bank_book.debit_credit", $this->input->post('TranxType'));
			else
				$this->db->where("bank_book.debit_credit", "Debit");
//			$this->db->order_by("bank_book.date")
//				->order_by("bank_book.transaction_id");
		}
        $query = $this->db->get();
        // echo $this->db->last_query();
        $result = $query->result();


		/**
		* Update balance and statement balance on the fly. dont use balances in db.
		*/
		if($account_id_get){
			if(sizeof($result) > 0){
				$leastdate =  $result[sizeof($result)-1]->date;

				/**
				* Get account Book balance and bank balance before fromdate
				*/
				$this->db->select('SUM(CASE WHEN debit_credit="Credit" THEN transaction_amount ELSE transaction_amount*-1 END) as balance,'
                . 'SUM(CASE WHEN clearance_status=1 AND debit_credit="Credit" THEN transaction_amount 
                    WHEN clearance_status=1 and debit_credit="Debit" THEN transaction_amount*-1  END) as statement_balance')
				->from('bank_book')
				->where('bank_book.date < ', $leastdate)
				->where('bank_book.bank_account_id', $account_id_get);

				$query = $this->db->get();
				// echo $this->db->last_query();
				$balances = $query->result();

				$balance_before_searched_tranx = $balances[0]->balance;
				$statement_balance_before_searched_tranx = $balances[0]->statement_balance;
				if(true || $balance_before_searched_tranx != 0 || $statement_balance_before_searched_tranx != 0) {
					$index = count($result);
					while($index) {
						$present_index = --$index;
						if($result[$present_index]->debit_credit == "Credit"){
							$balance_before_searched_tranx += $result[$present_index]->transaction_amount;

							if($result[$present_index]->clearance_status==1){
								$statement_balance_before_searched_tranx += $result[$present_index]->transaction_amount;
							}

						}else{
							$balance_before_searched_tranx -= $result[$present_index]->transaction_amount;
							if($result[$present_index]->clearance_status==1){
								$statement_balance_before_searched_tranx -= $result[$present_index]->transaction_amount;
							}
						}
						$result[$present_index]->balance = $balance_before_searched_tranx;
						$result[$present_index]->balance_ui = $balance_before_searched_tranx;
						$result[$present_index]->statement_balance = $statement_balance_before_searched_tranx;
						$result[$present_index]->statement_balance_ui = $statement_balance_before_searched_tranx;
					}
				}

			}
		}
        return $result;
	}// search_bank_books
	
    function get_bank_books($account_id_get){
        if(key_exists('transaction_id', $this->bank_book_information)){
            $transaction_id = $this->bank_book_information['transaction_id'];            
            $this->db->select('bank_book.*, round(bank_book.balance,2) as balance_ui,'
				. 'round(bank_book.statement_balance,2) as statement_balance_ui,'
					. 'round(bank_book.transaction_amount,2) as transaction_amount_ui, party.party_name party_name, bank.bank_name bank_name,'
					. 'instrument_type.instrument_type instrument_type,'
					. 'project.project_name project_name')
                    ->from('bank_book')
					->join('party','bank_book.party_id=party.party_id','left')
					->join('instrument_type','bank_book.instrument_type_id=instrument_type.instrument_type_id','left')
					->join('project','bank_book.project_id=project.project_id','left')
					->join('bank','bank_book.bank_id=bank.bank_id','left')
					->order_by("bank_book.date", "desc")
                    ->where('transaction_id', $transaction_id);
            $query = $this->db->get();           
            $result = $query->result();  
            //Check for the existence of record.
            if(sizeof($result) == 0){
                return -3;                      //Record does not exist, probably illegal access.
            }else{
                return $result;
            }            
        }    
        $account_id='';
        if($this->input->post('account_id')){
            $account_id = $this->input->post('account_id');
            $this->db->where('bank_account_id', $account_id);
        }else if($account_id_get){
            $this->db->where('bank_book.bank_account_id', $account_id_get);
        }
        $this->db->select('bank_book.*,round(bank_book.balance,2) as balance_ui,'
				. 'round(bank_book.statement_balance,2) as statement_balance_ui,'
				. 'round(bank_book.transaction_amount,2) as transaction_amount_ui,party.party_name party_name, bank.bank_name bank_name,'
					. 'instrument_type.instrument_type instrument_type,'
					. 'project.project_name project_name')
                ->from('bank_book')
				->join('party','bank_book.party_id=party.party_id','left')
				->join('instrument_type','bank_book.instrument_type_id=instrument_type.instrument_type_id','left')
				->join('project','bank_book.project_id=project.project_id','left')
				->join('bank','bank_book.bank_id=bank.bank_id','left')
        //        ->where($this->bank_book_information)
				->order_by("bank_book.date", "desc")
				->order_by("bank_book.transaction_id", "desc")
                ->limit("$this->return_size");
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }// get_bank_books
}
?>
