<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StudentElectiveSubject[]|\Cake\Collection\CollectionInterface $studentElectiveSubjects
 */
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border" >
               
                  <label > Upload Student Image </label>
               
            </div>
            <div class="box-body">
                <div class="form-group">    
                    <?= $this->Form->create($studentMark,['id'=>'ServiceForm','autocomplete'=>false]) ?>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label">Class <span class="required" aria-required="true"> * </span></label>
                            <?php echo $this->Form->control('class_mapping_id', ['options' => $classMappings,'empty'=>'--Select--','label'=>false,'class'=>'select2','style'=>'width:100%;','val'=>'']);?>
                        </div>
                  
                        <div class="col-md-4">
                            <?php echo $this->Form->button('Submit',['class'=>'btn button btnClass','id'=>'submit_member']); ?>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
                <div class="row">
				<h4 style="margin-left:17px;"><b><?= @$class_mapping->medium->name?> <?= @$class_mapping->student_class->name?> <?= @$class_mapping->stream->name?> <?= @$class_mapping->section->name?><b></h4>
                    <div class="col-md-12">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <th>Sr. No.</th>
                                <th>Student</th>
                                <th>Scoller No.</th>
                                <th>Roll No.</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="main">
							 <?php 
								 //$url="http://13.232.166.138/mumkins/img/";
								  $url=$awsFileLoad->cdnpath();
								 // echo ($response_data);exit;
								  ?> 
                                <?php if (isset($students)): ?>
                                    <?php foreach ($students as $key => $student): ?>
                                        <tr>
                                            <td><?= $key+1 ?></td>
                                            <td><?= $student->name?></td>
                                            <td><?= $student->scholer_no?></td>
                                            <td><?= $student->roll_no?></td>
                                            <td>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $this->Html->image($url.'/'.$student->student_image,['style'=>'width:50px; height:50px;']); ?>
												<input type="hidden" class="upld" value="<?= $student->id ?>">
												<input type="hidden" class="mapping_id" value="<?= $class_mapping_id ?>">
												<a href="#" role="button" class="btn btn-xs green pull-left plus" style="margin-top: 26px;" >Upload</a>
                                            </td>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->element('loading') ?>
<?= $this->element('selectpicker') ?>
<?= $this->element('validate') ?>

<?php 
$js = "
$(document).ready(function(){

    var arr = {};

    function rr(obj)
    {
        $.each(obj, function(key,value) {
            if(value.children == '')
            {
                arr[value.id] = value.name;
            }
            else
            {
                var response = JSON.parse(JSON.stringify(value.children));
                rr(response);
            }
        });
    }
	
		$('.plus').on('click',function() {
			
				$('#customer').modal('show');
				var student_id=$(this).closest('tr').find('.upld').val();
				var mapping_id=$(this).closest('tr').find('.mapping_id').val();
				$('.std_id').val(student_id);
				$('.class_mapping').val(mapping_id);
				$('label.error').hide();
				$('.error').removeClass('error');
		});


	  
});
";
$this->Html->scriptBlock($js,['block'=>'scriptPageBottom']);
?>

<div class="modal fade y" id="customer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Upload Image</h4>
			</div>
			 <?= $this->Form->create('',['id'=>'form2','enctype'=>'multipart/form-data']) ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<label class=" control-label">Upload</label>
							<?php echo $this->Form->control('std_id',['class'=>'std_id hidden','label'=>false,'type'=>'text']); ?>
							<?php echo $this->Form->control('class_mapping_id',['class'=>'class_mapping hidden','label'=>false,'type'=>'text']); ?>
							<?php echo $this->Form->input('student_image',['class'=>'form-control input-sm image','label'=>false,'type'=>'file']); ?>
						</div>
					</div>
				</div>	
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success btnsave">Save changes</button>
				</div>
			 <?= $this->Form->end() ?>
		</div>
	</div>
</div>