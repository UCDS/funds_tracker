<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }    
    
    public function index()
    {
        $this->load->helper('form');
        if($this->session->logged_in == "YES"){
            $this->load->view('nav_bars/header');
            $this->load->view('nav_bars/left_nav');
            $this->load->view('pages/bank_pages/bank_accounts_template');
            $this->load->view('nav_bars/footer');
        }else if($this->input->post('user_name') && $this->input->post('password')){
            $login_data = $this->user_model->login();
            if(sizeof($login_data) > 0){
                $user_functions = $this->user_model->get_user_functions();
                $user_data = array(
                    'user_name' => $login_data[0]->user_name,
                    'user_id' => $login_data[0]->user_id,               
                    'user_functions' => $user_functions,
                    'logged_in' => 'YES'
                );
                $this->session->set_userdata($user_data);
                $this->load->view('nav_bars/header');
                $this->load->view('nav_bars/left_nav');
                $this->load->view('pages/bank_pages/bank_accounts_template');
                $this->load->view('nav_bars/footer');
            }else{
                $this->data['InvalidLogin'] = true;
                $this->load->view('login_page',$this->data);
            }
        }else{
            $this->load->view('login_page');
        }        
    }
    
    function logout(){
        $this->session->sess_destroy();
//		echo base_url();
        redirect(base_url()+"/");
    }
}
