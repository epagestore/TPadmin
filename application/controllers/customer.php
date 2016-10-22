<?php
class Customer extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		if(!isset($this->session->userdata['is_logged_in'])) { 
				redirect('login');
		}
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('customer_model');
	}
	public function index() {
		
	
		$data='';
		$customer_name='';
		if(isset($_GET['page']))
		$page=$_GET['page'];
		else
		$page=1;
		if(isset($_GET['customer_name']))
		$customer_name=$_GET['customer_name'];
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$customer_name=$this->input->post('customer_name');
			
		}
		$limit=10;
		
		$data['customer_name']=$customer_name;
		$page_limit='LIMIT '.(($page-1)*$limit).','.$limit;
		$customers=$this->customer_model->getcustomer('',$customer_name,$page_limit);
		$data['customers']=$customers['results'];
		$data['page_total']=ceil($customers['num_results']/$limit);
		
		
		
		$this->load->view('header',$data);
		$this->load->view('customer_list',$data);
		$this->load->view('footer',$data);
	}
	public function company()
	{
		$data='';
		$customer_name='';
		if(isset($_GET['page']))
		$page=$_GET['page'];
		else
		$page=1;
		if(isset($_GET['customer_name']))
		$customer_name=$_GET['customer_name'];
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$customer_name=$this->input->post('customer_name');
			
		}
		$limit=10;
		
		$data['customer_name']=$customer_name;
		$page_limit='LIMIT '.(($page-1)*$limit).','.$limit;
		$customers=$this->customer_model->getcompany('',$customer_name,$page_limit);
		$data['customers']=$customers['results'];
		$data['page_total']=ceil($customers['num_results']/$limit);
		
		
		
		$this->load->view('header',$data);
		$this->load->view('company_list',$data);
		$this->load->view('footer',$data);
	}
	public function updateCompany($customer_id)
	{
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->customer_model->updatecompany($customer_id,$this->input->post());
			
		}
		$data='';
		$customers=$this->customer_model->getcompany($customer_id);
		$data['customers']=$customers['results'];
		$data['company']=1;
		$this->load->view('header',$data);
		$this->load->view('customer_form',$data);
		$this->load->view('footer',$data);
	}
	public function updateCustomer($customer_id)
	{
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->customer_model->updatecustomer($customer_id,$this->input->post());
			
		}
		$data='';
		$customers=$this->customer_model->getcustomer($customer_id);
		$data['customers']=$customers['results'];
		
		$this->load->view('header',$data);
		$this->load->view('customer_form',$data);
		$this->load->view('footer',$data);
	}
	public function deletecustomer($customer_id)
	{
		$customers=$this->customer_model->deletecustomer($customer_id);
		redirect("customer");
	}
}?>