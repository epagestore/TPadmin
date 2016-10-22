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
							<h2>Withdraw Request</h2>
						</div>
						<div class="content">
						<table class="orders-table table">
						<thead>
							<tr style=" width:10px;">
                             <th><input type="checkbox" value="option_all" id="all" onclick="checkall($(this),'opt_id[]');" ></th>
                          		<th>Withdraw ID</th>
                          		<th>Transaction ID</th>
                          		<th>Customer Name</th>
								<th>Description</th>
                                <th>Amount</th>
                                <th>IP Address</th>
                                <th class="value">Added on </th>
                                <th colspan="2">Action</th>
                            
							</tr>
						</thead>
						<tbody>
                        	<?php foreach ($transactions as $transaction): ?>
							
                            <tr>
                             <td style=" width:10px;"><input type="checkbox" value="<?php echo $transaction['transaction_id']?>" name="opt_id[]" onclick="checkitem($(this),'all')"></td>
							  <td><?php echo $transaction['withdraw_id'];?></td>
							  <td><?php echo $transaction['transaction_id'];?></td>
							  <td><?php echo $transaction['customer_name']; ?></td>
                              <td><?php echo $transaction['description'];?> <!--<span class="label label-info">Item Status</span>--></td>
                                <td><?php echo number_format($transaction['amount']*$transaction['value']);?></td>
                                <td><?php echo $transaction['ip_address'];?></td>
                                <td class="value">
									<?php echo date("M jS Y g:i:s A",strtotime($transaction['date_added'])); ?>
								</td>
								<td colspan="2" >
									<a style="font-size:25px;" class="btn btn-success btn-xs detail"  data-toggle="modal" data-target="#myModal" data="<?php echo $transaction['customer_id'];?>" id="detail"><i class="icon-eye-open"></i></a>
									<?php if($transaction['status']=='0'){?>
									<form class="" name="" method="post">
									<input type="hidden" name="amount" value="<?php echo $transaction['amount']*$transaction['value'];?>">
									<input type="hidden" name="customer_id" value="<?php echo $transaction['customer_id'];?>">
									<input type="hidden" name="status" value="1">
									<input type="hidden" name="currency_symbol" value="<?php echo $transaction['symbol'];?>">
									<input type="hidden" name="email" value="<?php echo $transaction['email'];?>">
									<button type="submit" class="btn btn-warning btn-xs" >Accept</button>
									</form>
									<?php }elseif($transaction['status']=='1'){?>
										<a class="bg-success ">Accepted</a>
									<?php }?>
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
				
				<!-- Modal -->
				<div id="myModal" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Customer Bank Detail</h4>
					  </div>
					  <div class="modal-body">
							
					  </div>
					</div>

				  </div>
				</div>
                
			</div>
			
		</div>
	
	</div>
<script>
$(document).ready(function(){
	
	$(".detail").click(function(){
		var da= $(this).attr('data');
		
		$.post( "<?php base_url();?>withdraw/getCustomer/"+da, function( data ) {
			$('.modal-body').empty();
			var html='<div class="table responsive "><table style="width:100%" ><tr><th colspan="2">Bank Information</th></tr>';
			$.each($.parseJSON(data), function(key, value) {
				 html+="<tr><td>Bank Name</td><td>"+value.bank_name+"</td></tr><tr><td>Routing No</td><td>"+value.routing_no+"</td></tr><tr><td>Bank Address</td><td>"+value.bank_address+"</td></tr><tr><td>Acount No</td><td>"+value.bank_ac+"</td></tr><tr><td>Bank Country</td><td>"+value.name+"</td></tr><tr><td>Account Type</td><td>"+value.bank_ac_type+"</td></tr><tr><td>Account Name</td><td>"+value.bank_ac_name+"</td></tr><tr><td>Address Line1</td><td>"+value.bank_ac_address1+"</td></tr><tr><td>Address Line2</td><td>"+value.bank_ac_address2+"</td></tr>"  
			});
			 html+='</table></table>';
			
			$('.modal-body').append(html);
		  //alert( "Data Loaded: " + data.fisrtname );
		});
		
	})
	
});

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


</script>