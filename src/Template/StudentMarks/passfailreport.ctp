<?php
ini_set('memory_limit', '-1');


 if (isset($subjects)): ?>
    <!-- find subject length -->
    <?php 
        $subjectArray = $subjects;
        $maxDepth = $Find->maxDepth($subjects); 
        $itteration = $maxDepth;
        $subjectLength = 0;
        for ($i=0; $i < $itteration; $i++) { 
    ?>
            <?php foreach ($subjects as $key => $section): ?>
                <?php if($i == ($itteration - 1) || $Find->arrayDepth($section) == 0){
                    $subjectLength++;
                } ?>
            <?php endforeach; ?>
            <?php 
                $maxDepth--;
                $subjects2 = $subjects;
                unset($subjects);
                $subjects = $Find->nextChild($subjects2);
             ?>
    <?php } $subjectLength++; ?>

    <?php 
        $examArray = $exams;
        $maxDepth = $Find->maxDepth($exams); 
        $itteration = $maxDepth;
        $examLength = 0;
    ?>
<?php endif ?>
<style type="text/css">
.mark_input{min-width: 50px;}
.total{
    color: #fff !important;
}

.table>thead>tr>th.total {
    background-color: #3d5577 !important;
}

.table>tbody>tr>td {
    white-space: nowrap;
    text-align: center !important;
}

.table>thead>tr>th {
    white-space: nowrap;
    text-align: center !important;
}

.control-label{
        display: block;
    }

</style>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    Report
                </h3>
            </div>
            <div class="box-body padding content-scroll" style="width: 100% !important;">
                <?= $this->Form->create('studentMark') ?>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label"> Class <span class="required" aria-required="true"> * </span></label>
                        
                            <?php echo $this->Form->control('class_mapping_id', ['empty'=>'--- Select---','options' => $classMappings,'class'=>'select2','style'=>'width:100%','label'=>false,'val'=>'']);?>
                        </div>

                        <div class="col-md-3">
                            <label class="control-label"> Exam</label>
                        
                            <?php echo $this->Form->control('exam_master_id', ['empty'=>'--- Select ---','options' => '','class'=>'select2','style'=>'width:100%','label'=>false,'val'=>'']);?>
                        </div>

                        <div class="col-md-3">
                            <label class="control-label"> Subjects</label>
                        
                            <?php echo $this->Form->control('subject_id', ['options' => [],'class'=>'select2','style'=>'width:100%','label'=>false,'val'=>'']);?>
                        </div>

                        <div class="col-sm-3">
                            <?= $this->Form->submit('search',['class'=>'btn btn-primary btnClass']) ?>
                        </div>
                    </div>
                <?= $this->Form->end() ?>
                <!-- <div style="width: 4.6%; background: #4D374B; position: absolute; height: 100%"> </div> -->
                <h3><?=@$class_mapping->medium->name.','.@$class_mapping->student_class->name.' '.@$class_mapping->stream->name.' '.@$class_mapping->section->name?></h3>
                <table id="example1" class="table table-bordered table-striped" style="border-collapse:collapse;">
                    <?php if (isset($exams)): ?>
                        <thead>
                            <?php for ($i=0; $i < $itteration; $i++) { ?>
                                    <tr>
                                        <?php if ($i == 0): ?>
                                            <th rowspan="<?= $maxDepth ?>"></th>
                                            <th rowspan="<?= $maxDepth ?>"></th>
                                            <th rowspan="<?= $maxDepth ?>"></th>
                                        <?php endif ?>
                                        <?php foreach ($exams as $key => $section): ?>
                                            <?php $rowSpan = ($Find->arrayDepth($section) == 0 ? $maxDepth : 0)?>
                                            <?php $colSpan = $Find->arrayWidth($section)?>
                                            <?php $colSpan > 0?$colSpan*=$subjectLength:$colSpan=$subjectLength;?>
                                            <?php if($i == ($itteration - 1) || $Find->arrayDepth($section) == 0){
                                                $examLength++;
                                            } ?>
                                            <th <?= $rowSpan!=0?'rowspan='.$rowSpan:'' ?> <?= $colSpan > 0?'colspan='.$colSpan:'' ?>><p>
                                                <?= $section['name'] ?></p>
                                            </th>
                                        <?php endforeach; ?>
                                    </tr>

                                    <?php 
                                        $maxDepth--;
                                        $exams2 = $exams;
                                        unset($exams);
                                        $exams = $Find->nextChild($exams2);
                                     ?>
                            <?php } ?>
                            
                            <?php $maxDepth = $Find->maxDepth($subjectArray); $itteration = $maxDepth;?>
                            <?php $subjects = $subjectArray; ?>
                            
                            <?php for ($i=0; $i < $itteration; $i++) { ?>
                                <tr>
                                    <?php if ($i == 0): ?>
                                        <th rowspan="<?= $maxDepth ?>">Sr. No.</th>
                                        <th rowspan="<?= $maxDepth ?>">Student</th>
                                        <th rowspan="<?= $maxDepth ?>">Roll No.</th>
                                    <?php endif ?>
                                    <?php for ($j=0; $j < $examLength; $j++) { ?>
                                        
                                        <?php foreach ($subjects as $key => $section): ?>
                                            <?php $rowSpan = ($Find->arrayDepth($section) == 0 ? $maxDepth : 0)?>
                                            <?php $colSpan = $Find->arrayWidth($section)?>
                                            
                                            <th class= "subject<?= $section['id'].'-'.$j ?>" <?= $rowSpan!=0?'rowspan='.$rowSpan:'' ?> <?= $colSpan > 0?'colspan='.$colSpan:'' ?>><p>
                                                <?= $section['name'] ?></p>
                                            </th>
                                        <?php endforeach; ?>

                                        <?php if ($i == 0): ?>
                                            <th class="total total<?=$j?>" rowspan="<?= $maxDepth ?>">PASS</th>
                                        <?php endif ?>
                                        
                                    <?php } ?>
                                </tr>

                                <?php 
                                    $maxDepth--;
                                    $subjects2 = $subjects;
                                    unset($subjects);
                                    $subjects = $Find->nextChild($subjects2);
                                 ?>
                            <?php } ?>
                        </thead>
                    <?php endif ?>

                    <?php if (isset($students)): ?>
                        <tbody>
                            <?php $exam = $students[0]['exam']; ?>
                            <?php $sub_exam = $students[0]['sub_exam']; ?>
                            <?php @$roll = $students[0]['roll_no']; ?>
                            <?php $name = $students[0]['name']; ?>
                            <?php $total = 0; ?>
                            <?php $srno = 1; ?>
                            <tr>
                                <td><?= $srno ?></td>
                                <td><?= $name ?></td>
                                <td><?= $roll ?></td>

                            <?php $j=0; $i = 0; foreach ($students as $key => $student): $i++;?>
                                <?php $add_exam =  "subject".$student['subject_id'].'-'; ?>

                                <?php if ($name != $student['name']): ?>
                                   
                                    <?php
                                        $exam = $student['exam'];
                                        $sub_exam = $student['sub_exam'];
                                        $roll_no = $student['roll_no'];
                                        $total = 0;
                                        $j++;
                                    ?>

                                    <?php 
                                        $srno++;
                                        $name = $student['name'];
                                    ?>
                                    <tr>
                                        <td class="first-col"><?= $srno ?></td>
                                        <td class="second-col"><?= $name ?></td>
                                        <td class="third-col"><?= $roll_no ?></td>
                                <?php endif; ?>

                                <?php if ($exam != $student['exam'] || $sub_exam != $student['sub_exam']): ?>
                                    
                                    <?php
                                        $exam = $student['exam'];
                                        $sub_exam = $student['sub_exam'];
                                        $total = 0;
                                        $j++;
                                    ?>
                                <?php endif ?>
                                        <?php $add_exam.=$j; ?>
                                        <td class="marks" exam="<?= $add_exam ?>" max-mark = "<?= $student['sub_max'] ? $student['sub_max'] : $student['max_marks'] ?>">
                                                <p> <?= $student['student_number'] ?></p>
                                                <input type="hidden" name="student_info_id" value="<?= $student['student_info_id'] ?>">
                                                <input type="hidden" name="exam_master_id" value="<?= $student['id'] ?>">
                                                <input type="hidden" name="sub_exam_id" value="<?= $student['sub_exam_id'] ?>">
                                                <input type="hidden" name="subject_id" value="<?= $student['subject_id'] ?>">
                                                <input type="hidden" name="save_to" value="<?= $student['save_to'] ?>">
												
                                        </td>
										<?php $neddforpass= $student['sub_max']*33/100; ?>
										<?php if($neddforpass<=$student['student_number']){$color='background: greenyellow;';}else{$color='background:red;';}?>
										<td style="<?php echo $color;?>" class="hello<?php echo $j;?>" >
										<?php $neddforpass= $student['sub_max']*33/100; ?>
										<?php if($neddforpass<=$student['student_number']){echo 'PASS';}else{echo 'Fail';}?>
										
										<?php echo '('.$student['sub_max']*33/100 .')'; ?></td>
                                           
                            
                            <?php endforeach; ?>
                            
                        </tbody>
                    <?php endif ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->element('selectpicker');?>
<?= $this->element('loading');?>
<?= $this->element('medium class stream filter all');?>

<?php 
$js = "
$(document).ready(function() {
    var tt=0;
    $('tbody>tr:first>td').each(function(){
        var max = $(this).attr('max-mark');

        if(!isNaN(max) && max > 0)
        {
            tt += parseInt(max);
            str = '<span class=\'control-label\'>'+parseInt(max)+'</span>';
        }
        else
            str = '<span class=\'control-label\'></span>';

        var exam = $(this).attr('exam');
        var total = $(this).attr('tt');
        if(total)
        {
            if(tt)
                $('.'+total).append('<span class=\'control-label total\'>'+tt+'</span>');
            else
                $('.'+total).append('<span class=\'control-label total\'></span>');
            tt = 0;
        }
        else
        {
            $('.'+exam).append(str);
        }
    });

    $(document).on('dblclick','td.marks',function(){
        if($('body').hasClass('processing'))
            return 0;
        else
            $('body').addClass('processing');
        var p = $(this).find('p');
        p.html('<input type=text name=student_number class=\'form-control mark_input text-uppercase\' value='+p.html()+'>');
        $('.mark_input').focus();
        p.parent().removeClass('marks');
    });

    $(document).on('focusin', '.mark_input', function(){
        $(this).data('val', $(this).val());
    }).on('focusout','.mark_input', function(){

        var p = $(this).parent();
        var max = p.parent().attr('max-mark');
           
         
		   
        var textbox = $.isNumeric($(this).val()) ? parseInt($(this).val()) : $(this).val().toUpperCase();
		
        var max = parseInt(p.parent().attr('max-mark')) || 0;
        if(max == 0 && $.isNumeric($(this).val()))
        {
            alert('Either enter max marks or enter grade.');
            $(this).val($(this).data('val'));
            $('.mark_input').focus();
        }
        else
        if(textbox > max)
        {
            alert('value should be less then or equal to '+max)
            $(this).val($(this).data('val'));
            $('.mark_input').focus();
        }
        else
        if($(this).val() != $(this).data('val'))
        {
            var total_td = $('.hello'+p.parent().attr('exam').split('-').pop());
            var total = parseInt(total_td.html() - $(this).data('val')) + parseInt($(this).val());
			
              var passmarskss=max*33/100;
			
			  if(passmarskss<=textbox){
				  var passfile='PASS('+passmarskss+')';
				  var bgcolor='greenyellow';
			  }else{
				 var passfile= 'Fail('+passmarskss+')';
				   var bgcolor='red';
			  }
            var arrayData = {}
            save_to = p.parent().find('input[name=save_to]').val();

            arrayData['subject_id'] = p.parent().find('input[name=subject_id]').val();
            arrayData['student_info_id'] = p.parent().find('input[name=student_info_id]').val();
            if(save_to == 1)
                arrayData['sub_exam_id'] = p.parent().find('input[name=sub_exam_id]').val();
            else
                arrayData['exam_master_id'] = p.parent().find('input[name=exam_master_id]').val();
            arrayData['student_number'] = textbox;

            var data = JSON.parse(JSON.stringify(arrayData));
            var url = '".$this->Url->build(['action'=>'saveMarks.json'])."';        
            
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function(result){
                    var response = JSON.parse(JSON.stringify(result));
                    if(response.success)
                    {
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 900;
                        toastr.success('Saved');
						
                        total_td.html(passfile);
						total_td.css('background-color', ''+bgcolor+'');
                        var p = $('.mark_input').parent();
                        p.html(textbox);
                        p.parent().addClass('marks');
                        $('body').removeClass('processing');
                    }
                    else
                    {
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 900;
                        toastr.error('Unabel to save');
                        $(this).val($(this).data('val'));
                        $(this).focus();
                    }
                },
                global: false
            });
        }
        else
        {
            var p = $('.mark_input').parent();
            p.html($(this).val());
            p.parent().addClass('marks');
            $('body').removeClass('processing');
        }
    });

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

    function appendSubjects(arrayData)
    {
        $('#subject-id').empty();
        $('#subject-id').select2();
        var data2 = JSON.parse(JSON.stringify(arrayData));
        var url = '".$this->Url->build(['controller'=>'FacultyClassMappings','action'=>'getSubjects.json'])."';
        
        $.post(url,data2,function(result){
            var response = JSON.parse(JSON.stringify(result));
            var og = null;
            var optgroup = $();
            $.each(response.response, function (index, value) {
                if(value.parent != og)
                {
                    og = value.parent;
                    if(optgroup.children().length > 0)
                        $('#subject-id').append(optgroup);

                    optgroup = $('<optgroup/>');
                    optgroup.attr('label',value.parent);
                }

                var o = $('<option/>', {value: value.id, text:value.parent+' > '+ value.name});

                if(optgroup.attr('label') !== null && optgroup.attr('label') !== undefined)
                    optgroup.append(o);
                else
                    $('#subject-id').append(o);
            });

            if(optgroup.children().length > 0)
                $('#subject-id').append(optgroup);
        });
    }

    function appendExams(arrayData)
    {
        $('#exam-master-id').empty();
        $('#exam-master-id').select2();
        var data = JSON.parse(JSON.stringify(arrayData));

        var url = '".$this->Url->build(['action'=>'getParentExams.json'])."';
        $.post(url,data,function(result){
            var response = JSON.parse(JSON.stringify(result));
            $.each(response.response, function (index, value) {
                var o = $('<option/>', {value: value.id, text: value.name});
                o.attr('save_to','exam_master_id');
                $('#exam-master-id').append(o);
            });

            $('#exam-master-id').val($('#exam-master-id option:first-child').val()).trigger('change');

            arr = {};
        });
    }

    function appendEmpty(id)
    {
        var o = $('<option/>', {value: '', text: '--Select--'});
        id.append(o);
        id.trigger('change');
    }

    $(document).on('change','#class-mapping-id',function()
    {
        var arrayData = {}
        arrayData['class_mapping_id'] = $(this).val();
        //alert('hello');
        appendExams(arrayData);
        appendSubjects(arrayData);
    });
});
";
$this->Html->scriptBlock($js, ['block' => 'scriptPageBottom']);
 ?>