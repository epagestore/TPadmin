<?php class despute extends CI_Controller{
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
		$this->load->model('despute_model');
	}
	public function index() {
		$keyword='';
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$keyword=$this->input->post('keyword');
		}
		
		$data='';
		if(isset($_GET['keyword']))
		$keyword=$_GET['keyword'];
		$data['keyword']=$keyword;
		if(isset($_GET['page']))
		$page=$_GET['page'];
		else
		$page=1;
		$limit=10;
		$data['page']=$page;
		$page_limit='LIMIT '.(($page-1)*$limit).','.$limit;
		$desputes=$this->despute_model->getDesputes($keyword,'','',$page_limit);
		$data['desputes']=$desputes['results'];
		$data['page_total']=ceil($desputes['num_results']/$limit);
		$this->load->view('header');
		$this->load->view('despute_list',$data);
		$this->load->view('footer');
	}
	public function reasons() {
		$data="";
		$this->load->model('despute_model');
		$data['DesputeReasons']=$this->despute_model->getDesputeReasons();
		$this->load->view('header',$data);
		$this->load->view('desputeReason_list',$data);
		$this->load->view('footer',$data);
	}
	public function reasons_insert() {
		$data="";
		$this->load->model('despute_model');
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->despute_model->insertDesputeReasons($this->input->post());
			redirect('despute/reasons');
		}
		$DesputeReasons=array('description'=>'','pre_delivery'=>'');
		$data['DesputeReasons']=$DesputeReasons;
		$this->load->view('header',$data);
		$this->load->view('desputeReason_from',$data);
		$this->load->view('footer',$data);
	}
	public function reasons_delete($reason_id) {
		$this->load->model('despute_model');
		$opt_id=explode('--',$reason_id);
		foreach($opt_id as $id){
			$this->despute_model->deleteDesputeReasons($id);
		}
		
		redirect('despute/reasons');
	}
	public function reasons_form($reason_id) {
		$data="";
		$this->load->model('despute_model');
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->despute_model->updateDesputeReasons($reason_id,$this->input->post());
			redirect('despute/reasons');
		}
		$DesputeReasons=$this->despute_model->getDesputeReasons($reason_id);
		$data['DesputeReasons']=$DesputeReasons[0];
		$this->load->view('header',$data);
		$this->load->view('desputeReason_from',$data);
		$this->load->view('footer',$data);
	}
	
	public function remedy_discount() {
		$data="";
		$this->load->model('despute_model');
		$data['DesputeRemedy']=$this->despute_model->getRemedyDiscount();
		$this->load->view('header',$data);
		$this->load->view('remedyDiscount_list',$data);
		$this->load->view('footer',$data);
	}
	public function remedy_replacement() {
		$data="";
		$this->load->model('despute_model');
		$data['DesputeRemedy']=$this->despute_model->getRemedyReplacement();
		$this->load->view('header',$data);
		$this->load->view('remedyReplacement_list',$data);
		$this->load->view('footer',$data);
	}
	public function remedy_cancelation() {
		$data="";
		$this->load->model('despute_model');
		$data['DesputeRemedy']=$this->despute_model->getRemedyCancelation();
		$this->load->view('header',$data);
		$this->load->view('remedyCancelation_list',$data);
		$this->load->view('footer',$data);
	}
	
	
	public function discount_remedy_insert() {
		$data="";
		$this->load->model('despute_model');
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->despute_model->insertRemedyDiscount($this->input->post());
			redirect('despute/remedy_discount');
		}
		$DesputeRemedy=array('description'=>'','discount'=>'');
		$data['DesputeRemedy']=$DesputeRemedy;
		$this->load->view('header',$data);
		$this->load->view('remedyDiscount_from',$data);
		$this->load->view('footer',$data);
	}
	public function discount_remedy_delete($Remedy_id) {
		$this->load->model('despute_model');
		$opt_id=explode('--',$Remedy_id);
		foreach($opt_id as $id){
			$this->despute_model->deleteRemedyDiscount($id);
		}
		
		redirect('despute/remedy_discount');
	}
	
	
	public function replacement_remedy_insert() {
		$data="";
		$this->load->model('despute_model');
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->despute_model->insertRemedyReplacement($this->input->post());
			redirect('despute/remedy_replacemnt');
		}
		$DesputeRemedy=array('description'=>'');
		$data['DesputeRemedy']=$DesputeRemedy;
		$this->load->view('header',$data);
		$this->load->view('remedyReplacement_from',$data);
		$this->load->view('footer',$data);
	}
	public function replacement_remedy_delete($Remedy_id) {
		$this->load->model('despute_model');
		$opt_id=explode('--',$Remedy_id);
		foreach($opt_id as $id){
			$this->despute_model->deleteRemedyReplacement($id);
		}
		
		redirect('despute/remedy_replacement');
	}
	
	
	public function cancelation_remedy_insert() {
		$data="";
		$this->load->model('despute_model');
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->despute_model->insertRemedyCancelation($this->input->post());
			redirect('despute/remedy_cancelation');
		}
		$DesputeRemedy=array('description'=>'');
		$data['DesputeRemedy']=$DesputeRemedy;
		$this->load->view('header',$data);
		$this->load->view('remedyCancelation_from',$data);
		$this->load->view('footer',$data);
	}
	public function cancelation_remedy_delete($Remedy_id) {
		$this->load->model('despute_model');
		$opt_id=explode('--',$Remedy_id);
		foreach($opt_id as $id){
			$this->despute_model->deleteRemedyCancelation($id);
		}
		
		redirect('despute/remedy_cancelation');
	}
	
	
	public function discount_remedy_form($Remedy_id) {
		$data="";
		$this->load->model('despute_model');
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->despute_model->updateRemedyDiscount($Remedy_id,$this->input->post());
			redirect('despute/remedy_discount');
		}
		$DesputeRemedy=$this->despute_model->getRemedyDiscount($Remedy_id);
		$data['DesputeRemedy']=$DesputeRemedy[0];
		$this->load->view('header',$data);
		$this->load->view('remedyDiscount_from',$data);
		$this->load->view('footer',$data);
	}
	public function cancelation_remedy_form($Remedy_id) {
		$data="";
		$this->load->model('despute_model');
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->despute_model->insertRemedyCancelation($Remedy_id,$this->input->post());
			redirect('despute/remedy_cancelation');
		}
		$DesputeRemedy=$this->despute_model->getRemedyCancelation($Remedy_id);
		$data['DesputeRemedy']=$DesputeRemedy[0];
		$this->load->view('header',$data);
		$this->load->view('remedyCancelation_from',$data);
		$this->load->view('footer',$data);
	}
	public function replacement_remedy_form($Remedy_id) {
		$data="";
		$this->load->model('despute_model');
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->despute_model->updateRemedyReplacement($Remedy_id,$this->input->post());
			redirect('despute/remedy_replacement');
		}
		$DesputeRemedy=$this->despute_model->getRemedyReplacement($Remedy_id);
		$data['DesputeRemedy']=$DesputeRemedy[0];
		$this->load->view('header',$data);
		$this->load->view('remedyReplacement_from',$data);
		$this->load->view('footer',$data);
	}
}?>