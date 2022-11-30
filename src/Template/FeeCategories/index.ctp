<div class="row">
	<div class="col-md-5">
		<div class="box box-primary">
			<div class="box-header with-border" >
				<?php if(!empty($id)){ ?>
				<label > Edit Fee Category </label>
				<?php }else{ ?>
				<label> Add Fee Category </label>
				<?php } ?>
			</div>
			<div class="box-body">
				<div class="form-group">    
					<?= $this->Form->create($feeCategory,['id'=>'ServiceForm']) ?>
					<div class="row">
						<div class="col-md-4">
							<label class="control-label"> Name <span class="required" aria-required="true"> * </span></label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-11">
							<?php 
							$options['Form Fee']='Form Fee';
							$options['Admission Fee']='Admission Fee';
							$options['Annual Fee']='Annual Fee';
							$options['Monthly Fee']='Monthly Fee';
							$options['Adhoc Fee']='Adhoc Fee';
							$options['Hostel Fee']='Hostel Fee';
							?>
							<?= $this->Form->control('name',array('empty'=>'---Select Category---','options' => $options,'class'=>'select2','label'=>false,'style'=>'width:100%')) ?>
						</div>
					</div>
					<?php
					if($feeCategory->name=='Monthly Fee')
					{
						?>
						<div class="row">
							<div class="col-md-4">
								<label class="control-label"> Fee Collection <span class="required" aria-required="true"> * </span></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-11">
								<?php 
								$optionss['Merge']='Merge';
								$optionss['Individual']='Individual';
								?>
								<?= $this->Form->control('fee_collection',array('empty'=>'---Select Collection---','options' => $optionss,'class'=>'select2','label'=>false,'style'=>'width:100%')) ?>
							</div>
						</div>
						<?php
					}
					?>
					
					<?php if(!empty($id)){ ?>
					<br>
					<div class="row">
						<div class="col-md-4">
							<label class="control-label"> Status </label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-11">
							<div class="form-group">
								<?= $this->Form->control('is_deleted',array('options' => $status,'class'=>'select2','label'=>false,'style'=>'width:100%')) ?>
							</div>
						</div>
					</div>
					<?php } ?>
					<span class="help-block"></span>
					<div class="box-footer">
						<div class="row">
							<center>
								<div class="col-md-12">
									<div class="col-md-offset-3 col-md-6">  
										<?php echo $this->Form->button('Submit',['class'=>'btn button','id'=>'submit_member']); ?>
									</div>
								</div>
							</center>       
						</div>
					</div>
					<?= $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="box box-primary">
			<div class="box-header with-border">
				<label> View List </label>
			</div> 
			<div class="box-body">
				<?php $page_no=$this->Paginator->current('sections'); $page_no=($page_no-1)*10; ?>
				 <table id="example1" class="table">
					<thead>
						<tr>
							<th scope="col"><?= __('Sr.No') ?></th>
							<th scope="col"><?= __('Name ') ?></th>
							<th scope="col"><?= __('Fee Collection ') ?></th>
							<th scope="col"><?= __('Status ') ?></th>
							<th scope="col" class="actions" style="text-align:center;"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; foreach ($feeCategories as $feeCategory): ?>
						<tr>
							<td><?php echo ++$page_no;?></td>
							<td><?php echo $feeCategory->name;?></td>
							<td><?php echo $feeCategory->fee_collection;?></td>
							<td>
							<?php
							if($feeCategory->is_deleted=='Y')
							{
								echo 'Deactive';
							}
							else{
								echo 'Active';
							}
							?>
							</td>
							<td class="actions" align="center">
								<?= $this->Html->link(__('<i class="fa fa-pencil"></i> '), ['action' => 'index', $EncryptingDecrypting->encryptData($feeCategory->id)],['class'=>'btn btn-info btn-xs editbtn','escape'=>false, 'data-widget'=>'Edit Fee Category', 'data-toggle'=>'tooltip', 'data-original-title'=>'Edit Fee Category']) ?>
							</td>
						</tr>
					<?php $i++; endforeach; ?>
					</tbody>
			</table>
			<div class="box-footer">
				<?= $this->element('pagination') ?> 
			</div>
			</div>
		</div>
	</div>
</div>

<?= $this->element('validate') ?> 
<?php
$js="
$(document).ready(function(){

    $('#ServiceForm').validate({ 
        rules: {
            name: {
                required: true
            },
            fee_collection: {
                required: true
            }
        },
        submitHandler: function () {
            $('#loading').show();
            $('#submit_member').attr('disabled','disabled');
            form.submit();
        }
    });

});";
$this->Html->scriptBlock($js,['block'=>'block_js']);
?>
<?= $this->element('selectpicker') ?> 