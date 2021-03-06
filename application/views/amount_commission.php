<div class="main-area dashboard">
	
		<div class="container">
			
			<?php if($this->session->flashdata('message')){ ?>   
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert" href="#">x</a>
                    <h4 class="alert-heading">Success:</h4>
                    <?php echo $this->session->flashdata('message'); ?>                
                    
                </div>
			<?php }?>
			
			
			
			<div class="row">
				
				
				
				<div class="span12">
				
					<div class="slate">
					
						<div class="page-header">
							<?php /*?><div class="pull-right listing-buttons">
								<a href="<?php echo base_url();?>index.php/option/insert" class="btn btn-success">INSERT</a>
                            
                                <button class="btn btn-primary" onclick="deletemulti('opt_id[]');">DELETE</button>
                            </div><?php */?>
							<h2>Commission Amount</h2>
						</div>
						<div class="content">
						<table class="orders-table table">
						<thead>
							<tr style=" width:10px;">
                             <th><input type="checkbox" value="option_all" id="all" onclick="checkall($(this),'opt_id[]');" ></th>
                          		<th>Order ID</th>
                          		<th>Transaction ID</th>                          		
                          		<th>Dispute ID</th>
                                <th>Released By</th>
								<th>Description</th>
                                <th>Amount</th>
                                <th>IP Address</th>
                                <th class="value">Added on </th>
                            
							</tr>
						</thead>
						<tbody>
                        	<?php foreach ($transactions as $transaction): ?>
                            <tr>
                             <td style=" width:10px;"><input type="checkbox" value="<?php echo $transaction['transaction_id']?>" name="opt_id[]" onclick="checkitem($(this),'all')"></td>
							  <td><?php echo $transaction['order_id']?></td>
							  <td><?php echo $transaction['transaction_id']?></td>
							  <td><?php echo $transaction['despute_id']?></td>
                              <td><?php echo $transaction['username']." [".$transaction['released_by']."]"; ?></td>
                             
                              <td><?php echo $transaction['description']?> <!--<span class="label label-info">Item Status</span>--></td>
                                <td><?php echo $transaction['amount']?></td>
                                <td><?php echo $transaction['ip_address']?></td>
                                <td class="value">
									<?php echo date("M jS Y g:i:s A",strtotime($transaction['date_added'])); ?>
								</td>
							</tr>
							
							<?php endforeach ?>
						</tbody>
						</table>
                        </div>
						<div id="pagination" class="pagination pull-left">
						</div>
					</div>
				
				</div>
				
				<div class="modal hide fade" id="removeItem">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h3>Remove Item</h3>
					</div>
					<div class="modal-body">
						<p>Are you sure you would like to remove this item?</p>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn" data-dismiss="modal">Close</a>
						<a href="#" class="btn btn-danger">Remove</a>
					</div>
				</div>
                
				 <div class="modal hide fade" id="selectItem">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h3>Information</h3>
					</div>
					<div class="modal-body">
						<p>Select atleast one Item</p>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn" data-dismiss="modal">Ok</a>
					</div>
				</div>
                
			</div>
			
		</div>
	
	</div>
<script>
function checkall($this,$name){
	
		if($this.attr('checked'))
		$("input[name='"+$name+"']").attr('checked','checked');
		else
		$("input[name='"+$name+"']").removeAttr('checked');

}
function checkitem($this,$id){

		if($this.attr('checked'))
			$this.attr('checked','checked');
		else
			$this.removeAttr('checked');
			
		if($("input[name='"+$this.attr('name')+"'][checked='checked']").length == $("input[name='"+$this.attr('name')+"']").length)
			$("#"+$id).attr('checked','checked');
		else
			$("#"+$id).removeAttr('checked');

}
function deletemulti($name){

	var option_id='';
	$i=0;
	$("input[name='"+$name+"'][checked='checked']").each(function(){
		if($i==0)
		option_id+=$(this).val();
		else
		option_id+='--'+$(this).val();
		$i++;
	});
	if(option_id!='')
	{
		$('#removeItem .btn-danger').click(function () {
			window.location.href ="<?php echo base_url();?>index.php/option/delete/"+option_id;
		});
		$('#removeItem').modal('toggle');
		
	}
	else
	$('#selectItem').modal('toggle');

}

$(document).ready(function(){
	$('a.remove-item').click(function () {
		var url = this.href;
		$('#removeItem .btn-danger').click(function () {
		  window.location.href = url;
		});
		$('#removeItem').modal('toggle');
	 });
	<?php $array = $this->uri->uri_to_assoc(2);
	if(isset($array['page']))
	$page=$array['page'];
	else
	$page=1;
	?>
		
			
	 var options = {
				currentPage: <?php echo $page;?>,
				totalPages: <?php echo $page_total?>,
				pageUrl: function(type, page, current){
	
					return "<?php echo base_url();?>index.php/option/page/"+page+"/<?php echo $option_name?>";
	
				},
				itemTexts: function (type, page, current) {
						switch (type) {
						case "first":
							return "First";
						case "prev":
							return "Previous";
						case "next":
							return "Next";
						case "last":
							return "Last";
						case "page":
							return page;
						}
					},
				shouldShowPage:function(type, page, current){
					switch(type)
					{
						case "first":
						case "last":
							return false;
						default:
							return true;
					}
				}
			}
	
	$('#pagination').bootstrapPaginator(options);
});
</script>