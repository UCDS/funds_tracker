<?php

class Report extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('report_model');
        $this->load->model('bank_model');
        $this->load->model('bank_account_model');
        $this->load->library('session');
        $this->load->model('generic_model');
        $this->load->model('party_model'); 
        $this->load->model('project_model'); 
        $this->load->model('instrument_type_model');
        $this->load->helper('form');
        error_reporting(0);
    }
    
    function index(){
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $this->load->view('pages/reports/party');
        $this->load->view('nav_bars/footer');
    }
    
    function party(){
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $this->data['bank_account_id'] = $this->input->post('bank_account_id');
        $this->data['bank'] = $this->input->post('bank');
        $this->data['account_name'] = $this->input->post('account_name');
        $this->data['account_number'] = $this->input->post('account_number');
        $this->data['TrnxType'] = $this->input->post('TrnxType');
        $this->data['ClearanceStatus'] = $this->input->post('ClearanceStatus');
        $this->data['PartyID'] = $this->input->post('PartyID');
        $this->data['PartyName'] = $this->input->post('PartyName');
        $this->data['FromDate'] = $this->input->post('FromDate');
        $this->data['ToDate'] = $this->input->post('ToDate');
        $this->load->view('pages/reports/party',$this->data);
        $this->load->view('nav_bars/footer');
    }
	
	function ledger(){
		$this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
		$this->load->model('party_model');
		$this->load->model('project_model');
		$this->load->model('generic_model');
        $this->data['parties'] = $this->party_model->get_party();
		$this->data['projects'] = $this->project_model->get_projects();
		$this->data['ledger_accounts'] = $this->generic_model->get_ledger_accounts_list();
		$this->data['ledger_sub_accounts'] = $this->generic_model->get_ledger_sub_accounts_list();
        $this->data['items'] = $this->generic_model->get_items_list();
        $this->data['bankaccounts'] = $this->bank_account_model->get_bank_book_accounts();
		
		$this->data['bank_account_id'] = $this->input->post('bank_account_id');
        $this->data['bank'] = $this->input->post('bank');
        $this->data['account_name'] = $this->input->post('account_name');
        $this->data['account_number'] = $this->input->post('account_number');
        $this->data['ledger_reference_table'] = $this->input->post('ledger_reference_table');
        $this->data['TrnxType'] = $this->input->post('TrnxType');
        $this->data['ClearanceStatus'] = $this->input->post('ClearanceStatus');
        $this->data['PartyID'] = $this->input->post('PartyID');
        $this->data['PartyName'] = $this->input->post('PartyName');
        $this->data['FromDate'] = $this->input->post('FromDate');
        $this->data['ToDate'] = $this->input->post('ToDate');
        $this->data['searchID'] = $this->input->post('searchID');
        $this->data['searchBy'] = $this->input->post('searchBy');
        $this->data['project_id'] = $this->input->post('project_id');
        
		
		$this->load->view('pages/reports/ledger',$this->data);
        $this->load->view('nav_bars/footer');
		
	}
	
	function payments(){
		$this->load->view('nav_bars/header');
		$this->load->view('nav_bars/left_nav');
		$this->load->view('pages/reports/payments');
		$this->load->view('nav_bars/footer');
	}
	function receipts(){
		$this->load->view('nav_bars/header');
		$this->load->view('nav_bars/left_nav');
		$this->load->view('pages/reports/receipts');
		$this->load->view('nav_bars/footer');
	}

	function getPartyData(){
        // echo "test".$this->input->post('partyID');
        $result =  $this->report_model->getPartyBasedTrnxData($this->input->post('partyID'),$this->input->post('startDate'),$this->input->post('endDate'));
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }

    function getPartyDetailsData(){
        $result =  $this->report_model->getPartyBasedTrnxDetails();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }

    function partyDetailsPage(){
        $this->load->view('pages/reports/party_details');
    }

	function getLedgerData(){
        $result =  $this->report_model->getLedgerBasedTrnxData($this->input->post('searchBy'),$this->input->post('searchID'),$this->input->post('startDate'),$this->input->post('endDate'), $this->input->post('bankAccount'));
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }

    function getLedgerDetailsData(){
        $result =  $this->report_model->getLedgerBasedTrnxDetails();
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }

	function ledgerDetailsPage(){
        $this->load->view('pages/reports/ledger_details');
    }

    function bank_book_edit_report(){
		$this->load->view('nav_bars/header');
		$this->load->view('nav_bars/left_nav');
		$this->load->view('pages/reports/bank_book_edit_report');
		$this->load->view('nav_bars/footer');
	}

    // function get_bank_book_edits()
    // {
    //     $this->load->view('nav_bars/header');
	// 	$this->load->view('nav_bars/left_nav');
    //     $this->data['instrument_types'] = $this->instrument_type_model->get_instrument_type();
    //     $this->data['banks'] = $this->bank_model->get_banks();
    //     $this->data['ledger_account']=$this->generic_model->get_ledger_accounts_list();
    //     $this->data['ledger_sub_account']=$this->generic_model->get_ledger_sub_accounts_list();
    //     $this->data['parties'] = $this->party_model->get_party();
    //     $this->data['item']=$this->generic_model->get_items_list();
    //     $this->data['projects'] = $this->project_model->get_projects();
    //     $this->data['get_edit_history'] = $this->report_model->get_all_bank_edit_history();
    //     $this->load->view('pages/reports/bank_book_edit_report',$this->data);
    //     $this->load->view('nav_bars/footer');
    // }
    function get_bank_book_edits()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');

        $from_date = $this->input->post('from_date') ? $this->input->post('from_date') : $this->session->userdata('from_date');
        $to_date = $this->input->post('to_date') ? $this->input->post('to_date') : $this->session->userdata('to_date');
        
        if ($from_date && $to_date) {
            $this->session->set_userdata('from_date', $from_date);
            $this->session->set_userdata('to_date', $to_date);
        }
        $this->data['instrument_types'] = $this->instrument_type_model->get_instrument_type();
        $this->data['banks'] = $this->bank_model->get_banks();
        $this->data['ledger_account'] = $this->generic_model->get_ledger_accounts_list();
        $this->data['ledger_sub_account'] = $this->generic_model->get_ledger_sub_accounts_list();
        $this->data['parties'] = $this->party_model->get_party();
        $this->data['item'] = $this->generic_model->get_items_list();
        $this->data['projects'] = $this->project_model->get_projects();
        $get_edit_history = $this->report_model->get_all_bank_edit_history();

        $per_page = 10;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $per_page;
        $total = count($get_edit_history);
        $total_pages = ceil($total / $per_page);
        $paged_history = array_slice($get_edit_history, $offset, $per_page);

        $instrument_types = $this->instrument_type_model->get_instrument_type();
        $type_map = [];
        foreach ($instrument_types as $type) {
            $type_map[$type->instrument_type_id] = $type->instrument_type;
        }
        $banks = $this->bank_model->get_banks();
        $bank_map = [];
        foreach ($banks as $bank) {
            $bank_map[$bank->bank_id] = $bank->bank_name;
        }
        $ledger_map = [];
        foreach ($this->data['ledger_account'] as $ledger_account) {
            $ledger_map[$ledger_account->ledger_account_id] = $ledger_account->ledger_account_name;
        }
        $ledger_sub_account_map = [];
        foreach ($this->data['ledger_sub_account'] as $ledger_sub_account) {
            $ledger_sub_account_map[$ledger_sub_account->ledger_sub_account_id] = $ledger_sub_account->ledger_sub_account_name;
        }
        $party_map = [];
        foreach ($this->data['parties'] as $party) {
            $party_map[$party->party_id] = $party->party_name;
        }
        $item_map = [];
        foreach ($this->data['item'] as $item) {
            $item_map[$item->item_id] = $item->item_name;
        }
        $project_map = [];
        foreach ($this->data['projects'] as $project) {
            $project_map[$project->project_id] = $project->project_name;
        }
        foreach ($paged_history as &$entry) {
            switch ($entry->field_name) {
                case 'Instrument Type':
                    $entry->previous_value = isset($type_map[$entry->previous_value]) ? $type_map[$entry->previous_value] : $entry->previous_value;
                    $entry->new_value = isset($type_map[$entry->new_value]) ? $type_map[$entry->new_value] : $entry->new_value;
                    break;
                case 'Bank':
                    $entry->previous_value = isset($bank_map[$entry->previous_value]) ? $bank_map[$entry->previous_value] : $entry->previous_value;
                    $entry->new_value = isset($bank_map[$entry->new_value]) ? $bank_map[$entry->new_value] : $entry->new_value;
                    break;
                case 'Ledger Account':
                    $entry->previous_value = isset($ledger_map[$entry->previous_value]) ? $ledger_map[$entry->previous_value] : $entry->previous_value;
                    $entry->new_value = isset($ledger_map[$entry->new_value]) ? $ledger_map[$entry->new_value] : $entry->new_value;
                    break;
                case 'Ledger Sub Account':
                    $entry->previous_value = isset($ledger_sub_account_map[$entry->previous_value]) ? $ledger_sub_account_map[$entry->previous_value] : $entry->previous_value;
                    $entry->new_value = isset($ledger_sub_account_map[$entry->new_value]) ? $ledger_sub_account_map[$entry->new_value] : $entry->new_value;
                    break;
                case 'Payee Party':
                    $entry->previous_value = isset($party_map[$entry->previous_value]) ? $party_map[$entry->previous_value] : $entry->previous_value;
                    $entry->new_value = isset($party_map[$entry->new_value]) ? $party_map[$entry->new_value] : $entry->new_value;
                    break;
                case 'Item':
                    $entry->previous_value = isset($item_map[$entry->previous_value]) ? $item_map[$entry->previous_value] : $entry->previous_value;
                    $entry->new_value = isset($item_map[$entry->new_value]) ? $item_map[$entry->new_value] : $entry->new_value;
                    break;
                case 'Project':
                    $entry->previous_value = isset($project_map[$entry->previous_value]) ? $project_map[$entry->previous_value] : $entry->previous_value;
                    $entry->new_value = isset($project_map[$entry->new_value]) ? $project_map[$entry->new_value] : $entry->new_value;
                    break;
                case 'Donor Party':
                    $entry->previous_value = isset($party_map[$entry->previous_value]) ? $party_map[$entry->previous_value] : $entry->previous_value;
                    $entry->new_value = isset($party_map[$entry->new_value]) ? $party_map[$entry->new_value] : $entry->new_value;
                    break;
            }
        }
        $this->data['get_edit_history'] = $paged_history;
        $this->data['current_page'] = $page;
        $this->data['total_pages'] = $total_pages;
        
        $this->load->view('pages/reports/bank_book_edit_report', $this->data);
        $this->load->view('nav_bars/footer');
    }

    function add_upd_opening_balance($record_id='')
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $all_opening_balances = $this->generic_model->get_ledger_opening_balance_list();
        $this->data['ledger_opening_balance'] = $all_opening_balances;
        
        $per_page = 10;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $per_page;
        $total = count($all_opening_balances);
        $total_pages = ceil($total / $per_page);
        $paged_history = array_slice($all_opening_balances, $offset, $per_page);

        $this->data['ledger_account'] = $this->generic_model->get_ledger_accounts_list();
        $this->data['edit_ledger_opening_balance'] = $this->generic_model->get_ledger_opening_balance_by_id($record_id);
        
        $this->data['paged_history'] = $paged_history;
        $this->data['current_page'] = $page;
        $this->data['total_pages'] = $total_pages;
        
        $this->load->view('pages/party_pages/add_update_opening_bal', $this->data);
        $this->load->view('nav_bars/footer');
    }

    public function insert_opening_balance() 
    {    
        date_default_timezone_set('Asia/Kolkata');
        $this->load->library('session');

        $date              = $this->input->post('date');
        $ledger_account_id = $this->input->post('ledger_account_id');
        $amount            = $this->input->post('amount');

        if (empty($date) || empty($ledger_account_id) || empty($amount)) {
            $this->data['error'] = 'All fields are required.';
        } else {

            $exists = $this->report_model->check_duplicate_opening_balance($date, $ledger_account_id, $amount);

            if ($exists) {
                $this->data['error'] = 'Opening balance for the selected ledger, date, and amount already exists.';
            }else if (!is_numeric($amount)) {
                $this->data['error'] = 'Please use only numbers for the amount.';
            } else {
                // Insert record
                $insert_data = [
                    'date'              => $date,
                    'ledger_account_id' => $ledger_account_id,
                    'balance'           => $amount,
                    'insert_by'         => $this->session->userdata('user_id'),
                    'insert_time'       => date('Y-m-d H:i:s'),
                    'update_by'         => 0,
                    'update_time'       => null
                ];

                if ($this->report_model->insert_opening_balance($insert_data)) {
                    $this->data['success'] = 'Opening balance added successfully.';
                } else {
                    $this->data['error'] = 'Failed to add opening balance.';
                }
            }
        }
        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');

        $all_opening_balances = $this->generic_model->get_ledger_opening_balance_list();
        $this->data['ledger_opening_balance'] = $all_opening_balances;
        
        $per_page = 10;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $per_page;
        $total = count($all_opening_balances);
        $total_pages = ceil($total / $per_page);
        $paged_history = array_slice($all_opening_balances, $offset, $per_page);
        $this->data['paged_history'] = $paged_history;
        $this->data['current_page'] = $page;
        $this->data['total_pages'] = $total_pages;

        $this->data['ledger_account'] = $this->generic_model->get_ledger_accounts_list();
        $this->load->view('pages/party_pages/add_update_opening_bal', $this->data);
        $this->load->view('nav_bars/footer');
    }

    public function update_opening_balance() 
    {
        date_default_timezone_set('Asia/Kolkata');
        $update_record_id   = $this->input->post('record_id');
        $date               = $this->input->post('date');
        $ledger_account_id  = $this->input->post('ledger_account_id');
        $amount             = $this->input->post('amount');

        if (empty($update_record_id) || empty($date) || empty($ledger_account_id) || empty($amount)) {
            $this->data['error'] = 'All fields are required.';
        } else if (!is_numeric($amount)) {
            $this->data['error'] = 'Please use only numbers for the amount.';
        } else {

            $exists = $this->report_model->check_duplicate_opening_balance_exclude_current($date, $ledger_account_id, $amount, $update_record_id);
            if ($exists) {
                $this->data['error'] = 'Another opening balance with the same ledger, date, and amount already exists.';
            } else {
                $update_data = [
                    'date'         => $date,
                    'ledger_account_id' => $ledger_account_id,
                    'balance'      => $amount,
                    'update_by'    => $this->session->userdata('user_id'),
                    'update_time'  => date('Y-m-d H:i:s'),
                ];

                $updated = $this->report_model->update_opening_balance($update_record_id, $update_data);

                if ($updated) {
                    $this->data['success'] = 'Opening balance updated successfully.';
                } else {
                    $this->data['error'] = 'Failed to update opening balance.';
                }
            }
        }

        $this->load->view('nav_bars/header');
        $this->load->view('nav_bars/left_nav');
        $all_opening_balances = $this->generic_model->get_ledger_opening_balance_list();
        $this->data['ledger_opening_balance'] = $all_opening_balances;
        
        $per_page = 10;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $per_page;
        $total = count($all_opening_balances);
        $total_pages = ceil($total / $per_page);
        $paged_history = array_slice($all_opening_balances, $offset, $per_page);
        $this->data['paged_history'] = $paged_history;
        $this->data['current_page'] = $page;
        $this->data['total_pages'] = $total_pages;
        $this->data['ledger_account'] = $this->generic_model->get_ledger_accounts_list();
        $this->load->view('pages/party_pages/add_update_opening_bal', $this->data);
        $this->load->view('nav_bars/footer');
    }

    public function get_available_amount($ledger_account_id)
    {
        $amount = $this->generic_model->get_latest_amount($ledger_account_id);
        if ($amount !== null) {
            echo json_encode(['success' => true, 'amount' => $amount]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    
}

?>