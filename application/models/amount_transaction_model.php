<?php
class Amount_transaction_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function getAmountTransaction($customer_name='')
	{
		if($customer_name!='')
		$customer_name=" having customer_name like '%".$customer_name."%'";
		$query=$this->db->query("SELECT ct.*,CONCAT(cus.first_name,CONCAT(' ',cus.last_name)) as customer_name FROM customer_transaction ct,customer cus where cus.customer_id=ct.customer_id and description like 'Amount deposited' or 'Amount withdraw' ".$customer_name." order by transaction_id desc");
		return $query->result_array();
	}
	public function getAmountCommission($customer_name='')
	{	
		$query=$this->db->query("select tc.*,u.username from trusted_commission tc , user u where u.user_id=tc.released_by order by commission_id desc");
		return $query->result_array();
	}
	
	public function getWithdrawRequest($customer_name='')
	{	
		$query=$this->db->query("select tc.*,tc.status as st,curr.*,cus.email,CONCAT(cus.first_name,CONCAT(' ',cus.last_name)) as customer_name from withdraw_amount tc left join customer cus on cus.customer_id = tc.customer_id left join currency curr on curr.currency_id = tc.currency_id order by withdraw_id desc");
		return $query->result_array();
	}
	public function getCustomerDetail($customer_id='')
	{	
		$query=$this->db->query("select * from customer c left join country on country_id=c.bank_country where c.customer_id='".$customer_id."' ");
		return $query->result_array();
	}
	public function withdrawAccept($customer_id,$data)
	{
		//echo $this->session->userdata('currnecy_id');exit;
		$description = 'Withdraw Request Accepted.Your amount '.$data['amount'].' Transfer in your Bank Account';
		$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$customer_id.", amount = ".$data['amount'].", description = '".$description."', date_added = NOW()");
		$transaction_id=$this->db->insert_id();
		$this->db->query("UPDATE `customer_account_balance` SET total_balance = ( total_balance - ".$data['amount']."), date_modified = NOW() where customer_id = ".$customer_id);
		$this->db->query("UPDATE `withdraw_amount` SET  transaction_id='".$transaction_id."',status='".$data['status']."', date_updated = NOW() where customer_id = ".$customer_id );
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Epagestore <info@epagestore.com>' . "\r\n";
		$message = 'TrustedPayer is accept Your withdraw Request.TrustedPayer will transfer amount '.$currency_symbol.' '.$data['amount'].' in your bank account registered in trustedpayer';
		$message .= 'To see more information click <a href="'.base_url().'index.php/history">HERE</a>';
		$flag=mail($data['email'], 'Withdraw Request', urldecode($message), $headers);
		$this->session->set_flashdata('success',"Transaction Successful!");
	}
}?>