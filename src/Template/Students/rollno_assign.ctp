<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subject[]|\Cake\Collection\CollectionInterface $subjects
 */
?>


<style type="text/css">
    .row{
        margin-bottom: 20px;
    }
</style>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <label> Add Roll No. Assign </label>
                </div> 
                <div class="box-body">
                    <?= $this->Form->create('Students',['url'=>['controller'=>'Students','action'=>'rollnoAssign']]) ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="control-label"> Medium </label>
                                <?= $this->Form->control('medium_id',['options'=>$mediums,'empty'=>'--select--','class'=>'select2','style'=>'width:100%;','label'=>false,'val'=>'']) ?>
                            </div>

                            <div class="col-sm-3">
                                <label class="control-label"> Class </label>
                                <?= $this->Form->control('student_class_id',['options'=>'','class'=>'select2','style'=>'width:100%;','label'=>false,'val'=>'']) ?>
                            </div>

                            <div class="col-sm-3">
                                <label class="control-label"> Stream </label>
                                <?= $this->Form->control('stream_id',['options'=>'','class'=>'select2','style'=>'width:100%;','label'=>false]) ?>
                            </div>
 <div class="col-sm-3">
                                <label class="control-label"> Section </label>
                                <?= $this->Form->control('section_id',['options'=>'','class'=>'select2','style'=>'width:100%;','label'=>false]) ?>
                            </div>

                            <div class="col-sm-3">
                                <?= $this->Form->submit('search',['class'=>'btn btn-default btn-primary btnClass']) ?>
                            </div>
                        </div>
                    <?= $this->Form->end() ?>
					<?php if(@$studentinfo){?>
                    <?= $this->Form->create('Students',['url'=>['controller'=>'Students','action'=>'rollnoAssigndata']]) ?>
                     <table id="example1" class="table">
                        <thead>
                            <tr>
                                <th><?= __('Sr.No') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Name') ?></th>
								<th scope="col"><?= $this->Paginator->sort('Medium') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Class') ?></th>
								
                                <th scope="col"><?= $this->Paginator->sort('Stream') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Section') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Roll Number') ?><input type="text" placeholder="" id="assign_roll_nos" class=" input-sm" style='float:right;color:black;'>
															
								</th>
								
                              
                                    
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($studentinfo as $stu): ?>
                            <tr class="main_tr">
                                <td><?php echo $i;?></td>
                                <td><?= h($stu->student->name) ?></td>
								
								<td><?= h($stu->medium->name) ?></td>
                                <td><?= h($stu->student_class->name) ?></td>
                                <td><?= h(@$stu->stream->name) ?></td>
                                <td><?= h(@$stu->section->name) ?></td>
								
								<input name="student_id[]" type='hidden' value=<?php echo @$stu->student_id;?>>
								<input name="section_id[]" type='hidden' value=<?php echo @$stu->section_id;?>>
								<input name="medium_id[]" type='hidden' value=<?php echo @$stu->medium_id;?>>
								<input name="stream_id[]" type='hidden' value=<?php echo @$stu->stream_id;?>>
								<input name="student_class_id[]" type='hidden' value=<?php echo @$stu->student_class_id;?>>
								
                                <td><?php 
                                  if(@$stu->roll_no >0)
									{
									$required = '';
									}
									else
									{
									$required = 'required';
									}
									echo $this->Form->control('roll_no[]',['id'=>'roll_no','class'=>'form-control input-sm roll_no checkValidation','placeholder'=>'Roll No','label'=>false,'autofocus',@$required,'value'=>$stu->roll_no]);

$this->Form->unlockField('student_id');									
$this->Form->unlockField('section_id');									
$this->Form->unlockField('medium_id');									
$this->Form->unlockField('stream_id');									
$this->Form->unlockField('student_class_id');									
								?></td>
                                
                                
                               
                            </tr>
                        <?php $i++; endforeach; ?>
                        </tbody>
                    </table>
					
					<div class="box-footer">
										<button type="submit" class="btn btn-primary" id="btn_rollNo">Submit</button>
									</div>
                </div>
               <?= $this->Form->end() ?>
<?php } ?>
            </div>
        </div>
    </div>

<?= $this->element('selectpicker');?>
<?= $this->element('loading');?>
<?php
$js="

$(document).on('keyup', '#assign_roll_nos', function(e)
    {   
		var starting_roll_no = parseInt($(this).val()); 
	
		if(!isNaN(starting_roll_no))
		{
				
			$('.checkValidation').removeAttr('required');
							
		
			$('#example1 tbody tr.main_tr').each(function(e){ 
				
				$(this).find('.roll_no').val(starting_roll_no);

				starting_roll_no = starting_roll_no+1;
			});
		}
		else{ 
			$('#example1 tbody tr.main_tr').find('td:nth-child(7) input').val('');
			$('.checkValidation').prop('required','true');
		}
		
	});


$(document).ready(function(){

    function appendEmpty(id)
    {
        var o = $('<option/>', {value: '', text: '--Select--'});
        id.append(o);
        id.trigger('change');
    }

    $(document).on('change','#medium-id',function(){
        var URL = '".$this->Url->build(['controller'=>'ClassMappings','action'=>'getClasses.json'])."';

        $('#student-class-id').empty();
        $('#student-class-id').select2();
        appendEmpty($('#student-class-id'));

        $.post(URL,{medium_id: $(this).val()},function(result){
            var response = JSON.parse(JSON.stringify(result));
            if(response.success)
            {
                $.each(response.response, function(key,value) {
                    var o = $('<option/>', {value: key, text: value});
                    $('#student-class-id').append(o);
                });
            }
        });
    });

    $(document).on('change','#student-class-id',function(){
        var URL = '".$this->Url->build(['controller'=>'ClassMappings','action'=>'getStreams.json'])."';
        var URL2 = '".$this->Url->build(['controller'=>'ClassMappings','action'=>'getSections.json'])."';
        var id = $(this).val();

        $('#stream-id').empty();
        $('#stream-id').select2();
        appendEmpty($('#stream-id'));

        $('#section-id').empty();
        $('#section-id').select2();
        appendEmpty($('#section-id'));
        
        if(id)
        {
            $.post(URL,{student_class_id: id},function(result){
                var response = JSON.parse(JSON.stringify(result));
                if(response.success)
                {
                    $.each(response.response, function(key,value) {
                        var o = $('<option/>', {value: key, text: value});
                        $('#stream-id').append(o);
						
                    });
                }
                else
                {
                    $.post(URL2,{student_class_id: id},function(result){
                        var response = JSON.parse(JSON.stringify(result));
                        if(response.success)
                        {
                            $.each(response.response, function(key,value) {
                                var o = $('<option/>', {value: key, text: value});
                                $('#section-id').append(o);
								
                            });
                        }
                    });
                }
            });
        }
    });

	function checkValidation()
	{
		$('#loading').show();
	    $('#btn_rollNo').attr('disabled','disabled');
	    $('#btn_rollNo').text('Submiting...');
    }
    $(document).on('change','#stream-id',function(){
        var URL2 = '".$this->Url->build(['controller'=>'ClassMappings','action'=>'getSections.json'])."';
        var class_id = $('#student-class-id').val();
        var id = $(this).val();
        
        $('#section-id').empty();
        $('#section-id').select2();
        appendEmpty($('#section-id'));
        if(id)
        {
            $.post(URL2,{student_class_id: class_id, stream_id: id},function(result){
                var response = JSON.parse(JSON.stringify(result));
                if(response.success)
                {
                    $.each(response.response, function(key,value) {
                        var o = $('<option/>', {value: key, text: value});
                        $('#section-id').append(o);
                    });
                }
            });
        }
    });
});";
$this->Html->scriptBlock($js,['block'=>'scriptPageBottom']);
?>