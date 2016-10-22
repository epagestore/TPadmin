<?php
class Customer_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function getCustomer($customer_id='',$supplier_name='',$page_limit=''){
		$where='';
		if($supplier_name!='')
		$where.=" and(first_name LIKE '%".$supplier_name."%' OR last_name LIKE '%".$supplier_name."%')";
		if($customer_id!='')
		$customer_id=" and customer_id =".$customer_id;
		$query =$this->db->query("SELECT cust.customer_id,cust.status as customer_status,cust.date_added,concat(first_name,concat(' ',last_name)) as customer_name,cust.first_name,cust.last_name,email FROM `customer` cust where is_company!=1 ".$where.$customer_id." ".$page_limit);
		$query1 =$this->db->query("SELECT cust.customer_id,cust.status as customer_status,cust.date_added,concat(first_name,concat(' ',last_name)) as customer_name,email FROM `customer` cust  where is_company!=1 ".$where);
		return array('results'=>$query->result_array(),'num_results'=>$query1->num_rows());
	}
	public function getCompany($customer_id='',$supplier_name='',$page_limit=''){
		$where='';
		if($supplier_name!='')
		$where.=" and(first_name LIKE '%".$supplier_name."%' OR last_name LIKE '%".$supplier_name."%')";
		if($customer_id!='')
		$customer_id=" and cust.customer_id =".$customer_id;
		$query =$this->db->query("SELECT cc.plan,cc.company_name,cc.company_website,cust.customer_id,cust.status as customer_status,cust.date_added,concat(first_name,concat(' ',last_name)) as customer_name,cust.first_name,cust.last_name,email FROM `customer` cust,`customer_company` cc where cc.customer_id=cust.customer_id and  is_company=1 ".$where.$customer_id." ".$page_limit);
		$query1 =$this->db->query("SELECT cust.customer_id,cust.status as customer_status,cust.date_added,concat(first_name,concat(' ',last_name)) as customer_name,email FROM `customer` cust,`customer_company` cc where cc.customer_id=cust.customer_id  and is_company=1 ".$where);
		return array('results'=>$query->result_array(),'num_results'=>$query1->num_rows());
	}
	public function deletecustomer($customer_id)
	{
		$this->db->query("DELETE FROM customer where customer_id = ".$customer_id);
	}
	public function updatecustomer($customer_id,$data)
	{
		$this->db->query("UPDATE customer SET first_name = '".$data['first_name']."',last_name = '".$data['last_name']."' where customer_id = ".$customer_id);
	}
	public function updatecompany($customer_id,$data)
	{
		$this->db->query("UPDATE customer SET first_name = '".$data['first_name']."',last_name = '".$data['last_name']."' where customer_id = ".$customer_id);
		$this->db->query("UPDATE customer_company SET plan=".$data['plan'].", company_name = '".$data['company_name']."',company_website = '".$data['company_website']."' where customer_id = ".$customer_id);
	}
	function emailById($customer_id)
	{
		$query =$this->db->query("SELECT email from `customer` where customer_id =".$customer_id);
		return $query->result_array();
	}
}
?>