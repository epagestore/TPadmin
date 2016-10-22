
<div class="secondary-masthead">
	
		<div class="container">
		
			<ul class="breadcrumb">
				<li>
					<a href="#">Admin</a> <span class="divider">/</span>
				</li>
				<li class="active">Dashboard</li>
			</ul>
		
		</div>
	
	</div>
<div class="main-area dashboard">
	
		<div class="container">
			
			<div class="row">
			
				<div class="span12">
				
					<div class="slate clearfix">
					
						<a class="stat-column" href="<?php echo base_url();?>index.php/order_transaction">
							
							<span class="number"><?php echo $order_total?></span>
							<span>Orders</span>
							
						</a>
					
						<a class="stat-column" href="<?php echo base_url();?>index.php/customer">
							
							<span class="number"><?php echo $personal_total?></span>
							<span>Personal Members</span>
							
						</a>
					
						<a class="stat-column" href="<?php echo base_url();?>index.php/customer/company">
							
							<span class="number"><?php echo $business_total?></span>
							<span>Business Members</span>
							
						</a>
					
						<a class="stat-column" href="<?php echo base_url();?>index.php/despute">
							
							<span class="number"><?php echo $despute_total?></span>
							<span>Despute</span>
							
						</a>
					
					</div>
				
				</div>
			
			</div>
			
			<div class="row">
			
				<div class="span6">
				
					<div class="slate">
					
						<div class="page-header">
							<h2><i class="icon-signal pull-right"></i>Transaction Statistics</h2>
						</div>
                        <div style="padding:20px;"><h4>Transaction per day<h4></div>
						<div id="placeholder" style="height: 297px;padding:5px"></div>
					
					</div>
				
				</div>
			
				<div class="span6">
				
					<div class="slate">
					
						<div class="page-header">
							<h2><i class="icon-shopping-cart pull-right"></i>Latest Orders</h2>
						</div>
						
						<table class="orders-table table">
						<tbody>
                        	<?php foreach($orders as $order):?>
							<tr>
								<td><a href="<?php echo base_url();?>index.php/order_transaction/posting/<?php echo $order['order_id']?>">#<?php echo $order['order_id']?> - <?php echo $order['payer_name']?></a> <span class="label <?php if($order['order_status_id']==2){ echo "label-success";}else if($order['order_status_id']==6){ echo "label-info";}?>"><?php echo $order['status_name']?></span></td>
								<td>$112.00</td>
							</tr>
                            <?php endforeach?>
							
							<tr>
								<td colspan="2"><a href="<?php echo base_url();?>index.php/order_transaction">View more orders</a></td>
							</tr>
						</tbody>
						</table>

					</div>
				
				</div>
			
			</div>
			
			<div class="row">
			
				<div class="span6">
				
					<div class="slate">
					
						<div class="page-header">
							<h2><i class="icon-shopping-cart pull-right"></i>Latest Order Product</h2>
						</div>
						
						<table class="orders-table table">
						<tbody>
                        	<?php foreach($order_products as $order_product):?>
							<tr>
								<td><a href="<?php echo base_url();?>index.php/order_transaction/posting/<?php echo $order_product['order_id']?>">#<?php echo $order_product['order_product_id']?> - <?php echo $order_product['payer_name']?></a> <span class="label <?php if($order_product['order_product_status_id']==2){ echo "label-success";}else if($order_product['order_product_status_id']==6){ echo "label-info";}else if($order_product['order_product_status_id']==9){ echo "label-warning";}else if($order_product['order_product_status_id']==8){ echo "label-important";}?>"><?php echo $order_product['status_name']?></span></td>
								<td>$112.00</td>
							</tr>
                            <?php endforeach?>
							
							
                            
						</tbody>
						</table>

					</div>
				
				</div>
			
				<div class="span6">
				
					<div class="slate">
					
						<div class="page-header">
							<h2><i class="icon-shopping-cart pull-right"></i>Latest Order Milestone</h2>
						</div>
						
						<table class="orders-table table">
						<tbody>
                        	<?php foreach($order_milestones as $order_milestone):?>
							<tr>
								<td><a href="<?php echo base_url();?>index.php/order_transaction/posting/<?php echo $order_milestone['order_id']?>">#<?php echo $order_milestone['milestone_id']?> - <?php echo $order_milestone['payer_name']?></a> <span class="label <?php if($order_milestone['status']==2){ echo "label-success";}else if($order_milestone['status']==6){ echo "label-info";}else if($order_milestone['status']==9){ echo "label-warning";}else if($order_milestone['status']==8){ echo "label-important";}else if($order_milestone['status']==5){ echo "label-inverse";}?>"><?php echo $order_milestone['status_name']?></span></td>
								<td>$112.00</td>
							</tr>
                            <?php endforeach?>
							
							
                            
						</tbody>
						</table>

					</div>
				
				</div>
			
			</div>
						
		</div>
	
	</div>
   
    <script type="text/javascript">
	$(function () {
	    var d1 = [];
		<?php $i=0;foreach($transactioStats as $transactioStat):?>
		 d1.push([<?php echo $i;?>, <?php echo $transactioStat['total']?>]);
		<?php $i++;endforeach?>
	      
//		$.plot($("#placeholder"), [ d1 ], { xaxis: {ticks:[<?php $i=0;foreach($transactioStats as $transactioStat):?><?php if(isset( $transactioStats[$i]['add_date'])){?>[<?php echo $i;?>,'<?php echo $transactioStats[$i]['add_date'];?>'],<?php $i=$i+5;}endforeach?>]},grid: { backgroundColor: 'white', color: '#999', borderWidth: 1, borderColor: '#DDD' }, colors: ["#6ECBE2"], series: { lines: { show: true, fill: true, fillColor: "rgba(110, 203, 226, 0.5)" } } });
	    $.plot($("#placeholder"), [ d1 ], { xaxis: {ticks:[<?php $i=0;foreach($transactioStats as $transactioStat): if(($i%5)){  $i++; continue;}?>[<?php echo $i;?>,'<?php echo $transactioStat['add_date'];?>'],<?php $i++;endforeach?>]},grid: { backgroundColor: 'white', color: '#999', borderWidth: 1, borderColor: '#DDD' }, colors: ["#6ECBE2"], series: { lines: { show: true, fill: true, fillColor: "rgba(110, 203, 226, 0.5)" } } });
	});
	</script>