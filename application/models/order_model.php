<?php
class order_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function getOrderTotal()
	{
		$query=$this->db->query("SELECT count(*) as total from `order`");		
		return $query->result_array();
	}
	public function getPersonalTotal()
	{
		$query=$this->db->query("SELECT count(*) as total from `customer` where is_company=0");		
		return $query->result_array();
	}
	public function getBusinessTotal()
	{
		$query=$this->db->query("SELECT count(*) as total from `customer` where is_company=1");		
		return $query->result_array();
	}
	public function getTransactionStat()
	{
		$query=$this->db->query("SELECT count(*) as total,date(date_added) as add_date FROM `customer_transaction` ct group by date(date_added)");
		return $query->result_array();
	}
	public function getDesputeTotal()
	{
		$query=$this->db->query("SELECT count(*) as total FROM `order_despute`");
		return $query->result_array();
	}
	
	public function getOrder()
	{
		$query=$this->db->query("SELECT concat(cus.first_name,concat(' ',cus.last_name)) as payer_name,ordr.*,os.name as status_name FROM `order` ordr left join `order_status` os on ordr.order_status_id=os.order_status_id left join `customer` cus on ordr.payer_id =cus.customer_id order by order_id desc limit 0,7");		
		return $query->result_array();
	}
	public function getOrderProduct()
	{
		$query=$this->db->query("SELECT concat(cus.first_name,concat(' ',cus.last_name)) as payer_name,ordrp.*,os.name as status_name FROM `order_product` ordrp left join `order_status` os on ordrp.order_product_status_id=os.order_status_id left join `order` ordr on ordr.order_id=ordrp.order_id left join `customer` cus on ordr.payer_id =cus.customer_id order by order_id desc limit 0,7");		
		return $query->result_array();
	}
	public function getOrderMilestone()
	{
		$query=$this->db->query("SELECT concat(cus.first_name,concat(' ',cus.last_name)) as payer_name,ordrm.*,os.name as status_name FROM `order_milestone` ordrm left join `order_status` os on ordrm.status=os.order_status_id left join `order` ordr on ordr.order_id=ordrm.order_id left join `customer` cus on ordr.payer_id =cus.customer_id order by order_id desc limit 0,7");		
		return $query->result_array();
	}
}?>