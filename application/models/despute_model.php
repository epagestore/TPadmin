<?php
class Despute_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function getDesputes($keyword='',$despute_id='',$order_product_id='',$limit='')
	{
		if($keyword!='')
		$keyword=" having (payer_name like '%".$keyword."%' or payee_name like '%".$keyword."%' or generate_by like '%".$keyword."%')";
		if($despute_id!='')
		$despute_id=" and despute_id=".$despute_id;
		if($order_product_id!='')
		$order_product_id=" and op.order_product_id=".$order_product_id;
		$query=$this->db->query("SELECT concat(admin.firstname,concat(' ',admin.lastname)) as admin_name,concat(payee.first_name,concat(' ',payee.last_name)) as payee_name,concat(payer.first_name,concat(' ',payer.last_name)) as payer_name,q.* from(SELECT NOW() as now,od.despute_id,od.payer_id,od.payee_id,od.status as despute_status,od.payer_amount,od.final_amount,od.payee_amount,od.description as despute_description,od.generate_by,date_added as despute_date_added,op.* from `order_despute` od,`order_product` op where op.order_product_id=od.order_product_id) q left join `customer` payer on payer.customer_id=q.payer_id left join `customer` payee on payee.customer_id=q.payee_id left join `user` admin on admin.user_id=q.released_by ".$keyword." order by despute_id desc ".$order_product_id.$despute_id.$limit);
		$query1=$this->db->query("SELECT concat(admin.firstname,concat(' ',admin.lastname)) as admin_name,concat(payee.first_name,concat(' ',payee.last_name)) as payee_name,concat(payer.first_name,concat(' ',payer.last_name)) as payer_name,q.* from(SELECT NOW() as now,od.despute_id,od.payer_id,od.payee_id,od.status as despute_status,od.payer_amount,od.final_amount,od.payee_amount,od.description as despute_description,od.generate_by,date_added as despute_date_added,op.* from `order_despute` od,`order_product` op where op.order_product_id=od.order_product_id) q left join `customer` payer on payer.customer_id=q.payer_id left join `customer` payee on payee.customer_id=q.payee_id left join `user` admin on admin.user_id=q.released_by ".$keyword." order by despute_id desc ".$order_product_id.$despute_id);
		return array('results'=>$query->result_array(),'num_results'=>$query1->num_rows());
	}
	public function getDesputeReasons($reason_id='')
	{
		$where='';
		if($reason_id!='')
		$where=' where reason_id='.$reason_id;
		$query=$this->db->query("SELECT * from `order_despute_reason`  ".$where." ");
		return $query->result_array();
	}
	public function updateDesputeReasons($reason_id,$data)
	{
		$this->db->query("UPDATE `order_despute_reason`  SET description='".$data['description']."',pre_delivery=".$data['pre_delivery'].", status=1 where reason_id=".$reason_id);
	}
	public function insertDesputeReasons($data)
	{
		$this->db->query("INSERT INTO `order_despute_reason`  SET description='".$data['description']."',pre_delivery=".$data['pre_delivery'].", status=1 ");
	}
	public function deleteDesputeReasons($reason_id)
	{
		$this->db->query("DELETE FROM `order_despute_reason`  where reason_id=".$reason_id);
	}
	
	public function getRemedyDiscount($reason_id='')
	{
		$where='';
		if($reason_id!='')
		$where=' where reason_id='.$reason_id;
		$query=$this->db->query("SELECT * from `order_remedy_discount`  ".$where." ");
		return $query->result_array();
	}
	public function getRemedyReplacement($reason_id='')
	{
		$where='';
		if($reason_id!='')
		$where=' where reason_id='.$reason_id;
		$query=$this->db->query("SELECT * from `order_remedy_replacement`  ".$where." ");
		return $query->result_array();
	}
	public function getRemedyCancelation($reason_id='')
	{
		$where='';
		if($reason_id!='')
		$where=' where reason_id='.$reason_id;
		$query=$this->db->query("SELECT * from `order_remedy_cancelation`  ".$where." ");
		return $query->result_array();
	}
	public function updateRemedyDiscount($reason_id,$data)
	{
		$this->db->query("UPDATE `order_remedy_discount`  SET description='".$data['description']."',discount='".$data['discount']."', status=1 where reason_id=".$reason_id);
	}
	public function insertRemedyDiscount($data)
	{
		$this->db->query("INSERT INTO `order_remedy_discount`  SET description='".$data['description']."',discount='".$data['discount']."', status=1 ");
	}
	public function deleteRemedyDiscount($reason_id)
	{
		$this->db->query("DELETE FROM `order_remedy_discount`  where reason_id=".$reason_id);
	}
	
	public function updateRemedyReplacement($reason_id,$data)
	{
		$this->db->query("UPDATE `order_remedy_replacement`  SET description='".$data['description']."', status=1 where reason_id=".$reason_id);
	}
	public function insertRemedyReplacement($data)
	{
		$this->db->query("INSERT INTO `order_remedy_replacement`  SET description='".$data['description']."', status=1 ");
	}
	public function deleteRemedyReplacement($reason_id)
	{
		$this->db->query("DELETE FROM `order_remedy_replacement`  where reason_id=".$reason_id);
	}
	
	public function updateRemedyCancelation($reason_id,$data)
	{
		$this->db->query("UPDATE `order_remedy_cancelation`  SET description='".$data['description']."', status=1 where reason_id=".$reason_id);
	}
	public function insertRemedyCancelation($data)
	{
		$this->db->query("INSERT INTO `order_remedy_cancelation`  SET description='".$data['description']."', status=1 ");
	}
	public function deleteRemedyCancelation($reason_id)
	{
		$this->db->query("DELETE FROM `order_remedy_cancelation`  where reason_id=".$reason_id);
	}
}?>