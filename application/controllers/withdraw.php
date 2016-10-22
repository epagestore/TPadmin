<?php
 class Withdraw extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
			$this->load->helper('form');
		$this->load->library('form_validation');
		if(!isset($this->session->userdata['is_logged_in'])) { 
				redirect('login');
		}
		$this->load->model('amount_transaction_model');
	}
	public function index() {
		
		$customer_name='';
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			//print_r($this->input->post());exit;
			$customer_name=$this->input->post('customer_name');
			$this->amount_transaction_model->withdrawAccept($this->input->post('customer_id'),$this->input->post());
		}
		
		$data='';
		$data['customer_name']=$customer_name;
		$data['transactions']=$this->amount_transaction_model->getWithdrawRequest();
		$this->load->view('header');
		$this->load->view('withdraw',$data);
		$this->load->view('footer');
	}
	public function getCustomer($c_id)
	{
		//$c_id=$this->input->post('customer_id');
		$data=$this->amount_transaction_model->getCustomerDetail($c_id);
		echo json_encode($data);
	}
	
}?>