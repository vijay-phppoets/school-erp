<div class="box box-primary">
	<div class="box-header"> 
		<div class="pull-right box-tools">
	        <?= $this->Html->link('Print','javascript:window.print();',['escape'=>false,'class'=>'btn bg-maroon hide_print','style'=>'color:#fff !important;']) ?>
	    </div>
		
	</div>
	<h3 style="color:#7A8FC7;text-align:center;">Purchase Returns</h3>
	<div style=" /*border-bottom: solid 1px #CCC;*/ padding: 13px 30px; line-height: 22px;">
		<table width="100%">
			<tr>
				<td>
					<span style="color: #606062;">Vandor Name &nbsp;&nbsp;&nbsp; :   </span>
					<span style="margin-left: 10px;">&nbsp;<?php echo $purchaseReturns->vendor->name; ?></span>
				</td>
				<td align="right">
					<span style="color: #606062;">Date &nbsp;&nbsp;&nbsp; : </span>
					<span style="margin-left: 10px;"><?php echo $purchaseReturns->transaction_date;
					?> </span>
				</td>
			</tr>
			<tr>
				<td>
					<span style="color: #606062;">Vandor Address  : </span>
					<span style="margin-left: 10px;"><?php echo $purchaseReturns->vendor->address; ?> </span>
				</td>
				<td align="right">
					<span style="color: #606062;margin-right: 60px;">Voucher No &nbsp;&nbsp;&nbsp;  : </span>
					<span style="margin-left: 10px;"><?php echo $purchaseReturns->voucher_no;
					?> </span>
				</td>
			</tr>
			
		</table>
	</div>
	<div class="row">
		<div class="col-sm-12" style="margin-top:10px;padding: 0px 33px 0px 33px;" id="main">
			<table class="table table-bordered" id="main_table">	
				<thead class="bg_color">
					<tr align="center">
						<th rowspan="2" style="text-align:left;">Sr</th>
						<th rowspan="2" style="text-align:left;">Item</th>
						<th rowspan="2" style="text-align:left;">Quantity</th>
						<th rowspan="2" style="text-align:left;">Rate</th>
						<th rowspan="2" style="text-align:left;">Total </th>
						
					</tr>
				</thead>
				<tbody id="main_tbody">
					<tbody>
						<?php $x=0; 
							foreach ($purchaseReturns->purchase_return_rows as $PurchaseReturnRows)	{ 
							?>
								<tr class="main_tr">
									<td style="vertical-align: top !important;"><?= ++$x; ?></td>
									<td><?=h ($PurchaseReturnRows->item->name)?></td>
									<td><?=h ($PurchaseReturnRows->quantity)?></td>
									<td><?=h ($PurchaseReturnRows->rate)?></td>		
									<td><?=h ($PurchaseReturnRows->amount)?></td>
								</tr>
						<?php 
							}
						?>
					</tbody>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"></td>
						<td  colspan="2" style ="text-align:right; font-weight:bold;">Grand Total</td>
						<td><?php echo $purchaseReturns->grand_total; ?></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>


