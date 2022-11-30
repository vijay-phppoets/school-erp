<?php
/**
 * @Author: PHP Poets IT Solutions Pvt. Ltd.
 */
$this->set('title', 'Student List');
?>
<div class="portlet light ">
	<div class="portlet-title" style="margin-bottom: 0;">
	<div class="box-header">
            <h3 class="box-title">
               Result Hold Report
            </h3>
        </div>
	</div>
	<div class="box-body padding content-scroll" style="width: 100% !important;">
		<?= $this->Form->create('') ?>
			<div class="row printdata">
				<div class="col-md-4">
                    <label class="control-label"> Class <span class="required" aria-required="true"> * </span></label>
                
                    <?php echo $this->Form->control('class_mapping_id', ['empty'=>'--- Select---','options' => $classMappings,'class'=>'select2 mapping form-control','style'=>'width:100%','label'=>false]);?>
                </div>
				<div class="col-md-2" >
					<div class="form-group" > 
						<button type="submit" class="btn  btn-primary" style="margin-top: 25px;"> Search</button>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
		<?php if(!empty($student_infos)){?>
			<table class="table table-bordered table-hover table-condensed">
				<thead>
					<tr style="background:#005B9E;color:#ffffff;">
						<th scope="col" class="actions"><?= __('Sr') ?></th>
						<th scope="col">Name</th>
						<th scope="col">Scholar No</th>
						<th scope="col">Roll No</th>
						<th scope="col">Class</th>
						<th scope="col" class="actions"><?= __('Actions') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; foreach ($student_infos as $info){
					?>
					<tr>
						<td><?= ++$i;?></td>
						<td><?= h($info->student->name) ?></td>
						<td><?= h($info->student->scholar_no) ?></td>
						<td><?= h($info->roll_no) ?></td>
						<td><?= $info->student_class->name.' '.$info->section->name ?></td>
						<td class="actions">
							<?php if ($info->result_hold =="Hold"): ?>
								<button student_id="<?= $info->id ?>" class="btn btn-sm btn-success result">Unhold</button>
							<?php else: ?>
								<button student_id="<?= $info->id ?>" class="btn btn-sm btn-warning result">Hold</button>
							<?php endif ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } ?>
	</div>
</div>

<?= $this->element('loading') ?>
<?php
$js="

$(document).ready(function(){

    $(document).on('click','.result',function()
    {
        var btn = $(this);
		var text = $(this).text();
		var student_id = $(this).attr('student_id');

		$.get(
			'".$this->Url->build(['action'=>'holdStatus'])."/'+text+'/'+student_id,
			function(res){
				if(res)
				{
					if(text == 'Hold')
					{
						btn.text('Unlod');
						btn.removeClass('btn-warning');
						btn.addClass('btn-success');
					}
					else
					{
						btn.text('Hold');
						btn.addClass('btn-warning');
						btn.removeClass('btn-success');
					}
				}
			});
    });
    

});";
$this->Html->scriptBlock($js,['block'=>'scriptPageBottom']);
?>

