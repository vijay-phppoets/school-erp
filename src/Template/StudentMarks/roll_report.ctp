<style>
@media print {
  .printdata{
         display:none;
     }
}
.class_hides{
    display: none;
}   
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                   Roll No Report
                </h3>
            </div>
            <div class="box-body padding" style="width: 100% !important;">
                <?= $this->Form->create('') ?>
                    <div class="row printdata">
                            <div class="col-md-3">
                                <label class="control-label"> Class <span class="required" aria-required="true"> * </span></label>
                            
                                <?php echo $this->Form->control('class_mapping_id', ['empty'=>'--- Select---','options' => $classMappings,'class'=>'select2 mapping','style'=>'width:100%','label'=>false]);?>
                                <?php echo $this->Form->control('class_hide', ['label'=>false,'id'=>'class_hides','class'=>'class_hides']);?>
                            </div>


                            <div class="col-md-3">
                                <label class="control-label"> Subjects</label>
                            
                                <?php echo $this->Form->control('subject_id', ['empty'=>'--- Select ---','options' => [],'class'=>'select2 subject','style'=>'width:100%','label'=>false]);?>
                                <?php echo $this->Form->control('subject_hide', ['label'=>false,'id'=>'subject_hide','class'=>'class_hides']);?>
                            </div>

                            <div class="col-md-3">
                                <label class="control-label"> Exam</label>
                            
                                <?php echo $this->Form->control('exam_master_id', ['empty'=>'--- Select ---','options' => [],'class'=>'select2 exam','style'=>'width:100%','label'=>false]);?>
                                <?php echo $this->Form->control('exam_hide', ['label'=>false,'id'=>'exam_hide','class'=>'class_hides']);?>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group" >
                            <label>Rows</label>
                            <?php
                                $rows[]=['value'=>'1','text'=>'1'];
                                $rows[]=['value'=>'2','text'=>'2'];
                                $rows[]=['value'=>'3','text'=>'3'];
                                $rows[]=['value'=>'4','text'=>'4'];
                                $rows[]=['value'=>'5','text'=>'5']; 
                                echo $this->Form->control('row',array('options' => $rows,'class'=>'form-control','empty' => '--Select--','label'=>false,'value'=>@$row,'required'=>'required')); 
                            ?>
                            </div>
                        </div>
                            <div class="col-md-2">
                                <!-- <a id="add_student" href="" class="btn btn-default btn-primary btnClass">Find</a> -->
                                 <button type="submit" class="btn btn-primary" style="margin-top: 26px;" id="">View</button>
                            </div>
                        </div>
                <?= $this->Form->end() ?>
                <?php if(!empty($studentinfos)){?>
                <div class="table-responsive" id="table1">
                    <div style="float: left;width: 100%; margin-top: 20px;">
                        <table width="100%" border="1">
                            <thead>
                                <tr>
                                    <td>
                                        <table style="text-align: center;font-size: 14px;margin-top: 12px;" width="100%" align="left">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" style="font-size: 20px;"><strong>ALOK SENIOR SECONDARY SCHOOL</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><strong>MARK-LIST</strong></h5></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><strong>SESSION : <?php echo $session_name;?></strong></h5></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><strong>EXAM :<?= @$exam_text?></strong></td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </td>
                                </tr> 
                                <tr>
                                    <td width="50%">
                                        <table style="text-align: center;font-size: 15px;" width="100%" align="left">
                                            <tbody>
                                                <tr>
                                                    <td style="padding-left: 10px;text-align: left;" width="15%">
                                                        <strong>CLASS</strong>
                                                    </td>
                                                    <td style="padding-left: 10px;text-align: left;" width="15%" id="class">
                                                        <strong><?= @$class['name']; ?></strong>
                                                    </td>
                                                    <td style="padding-left: 10px;text-align: left;" width="15%">
                                                        <strong>SECTION</strong>
                                                    </td>
                                                    <td style="padding-left: 10px;text-align: left;" width="15%">
                                                        <strong><?= @$section['name']; ?></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left: 10px;text-align: left;" width="15%">
                                                        <strong>DATE OF SUBMI</strong>
                                                    </td>
                                                    <td style="padding-left: 10px;text-align: left;" width="15%">
                                                        <strong>..../......./20...</strong>
                                                    </td>
                                                    <td style="padding-left: 10px;text-align: left;" width="15%">
                                                        <strong>MAXIMUM MARKS</strong>
                                                    </td>
                                                    <td style="padding-left: 10px;text-align: left;" width="15%">
                                                        <strong>--------</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left: 10px;text-align: left;" width="15%">
                                                        <strong>PASS MARKS</strong>
                                                    </td>
                                                    <td style="padding-left: 10px;text-align: left;" width="15%">
                                                        <strong>-</strong>
                                                    </td>
                                                    <td style="padding-left: 10px;text-align: left;" width="15%">
                                                        <strong>SUBJECT</strong>
                                                    </td>
                                                    <td style="padding-left: 10px;text-align: left;" width="15%">
                                                        <strong><?php 
														 foreach ($find_sub as $sub)
														{
															echo @$sub->parent." ".@$sub->name;
														}?></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div style="width: 100%">
                        <table style="text-align: center;font-size: 14px;" width="100%" border="1">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center">S.NO</th>
                                    <th rowspan="2" style="text-align: center">ROLL NO</th>
                                    <th rowspan="2" style="text-align: center">NAME</th>
                                    <th colspan="<?php echo $row; ?>" style="text-align:center !important;">
                                        MARKS OBTAINED
                                    </th>
                                </tr>
                                <tr>
                                    <?php 
                                    for($x=0;$x<@$row;$x++){
                                    ?>
                                        <th  style="text-align:center !important;width:12%;" height="35px" > &nbsp;
                                    <?php //echo $category_name; ?>
                                        </th>
                                    <?php } ?>
                                </tr>
                                <?php $i=1;
                                 //echo "<pre>"; print_r($studentinfos->toArray());exit;
                                foreach($studentinfos as $studentinfo)
                                {
                                ?>
                                <tr>
                                    <th  style="width:8%;">&nbsp;
                                        <?php echo $i++; ?>
                                    </th>
                                    <th style="width:10%;">&nbsp;
                                        <?php echo $studentinfo->roll_no; ?>
                                    </th>
                                    <th height="35px" style="width:22%;">&nbsp;
                                        <?php echo $studentinfo->student->name; ?>
                                    </th>
                                    <?php 
                                    for($x=0;$x<@$row;$x++){
                                    ?>
                                    <th style="text-align:center !important; width:12%">

                                    </th>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                               
                            </thead>
                        </table>
                    </div>
                    <table  style="text-align: left;font-size: 15px;margin-top: 30px;" width="100%">
                        <tbody>
                            <tr>
                                <td style="text-align: left;padding-left: 15px">
                                    <b>Passed ...........</b></td>
                                <td rowspan="3" style="padding-top: 30px;text-align: center;">
                                    <b>Signature Teacher</b></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;padding-left: 15px;">
                                    <b>Failed ...........</b></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;padding-left: 15px;">
                                    <b>Total Student 0</b></td>
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>
</div>
<?= $this->element('selectpicker');?>
<?= $this->element('loading');?>
<?= $this->element('medium class stream filter all');?>
<?php
$js="

$(document).ready(function(){

    $(document).on('change','.mapping',function()
    {
         var optionText = $('.mapping option:selected').text();
         $('#class_hides').val(optionText);
    });
     $(document).on('change','.subject',function()
    {
         var optionText = $('.subject option:selected').text();
         $('#subject_hide').val(optionText);
    });
     $(document).on('change','.exam',function()
    {
         var optionText = $('.exam option:selected').text();
         $('#exam_hide').val(optionText);
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

                var o = $('<option/>', {value: value.id, text: value.name});

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
        var url = '".$this->Url->build(['controller'=>'ExamMasters','action'=>'getExamsThreaded.json'])."';
        
        $.post(url,data,function(result){
            var response = JSON.parse(JSON.stringify(result));
            rr(response.response);
            
            $.each(arr, function (index, value) {
                var o = $('<option/>', {value: index, text: value});
                o.attr('save_to','exam_master_id');
                $('#exam-master-id').append(o);
            });

            $.each(response.sub_exams, function (key, value) {
                var optgroup = $('<optgroup/>');
                optgroup.attr('label',value.name);
                
                $.each(value.sub_exams, function (key, value2) {
                    var o = $('<option/>', {value: value2.id, text: value2.name});
                    o.attr('save_to','sub_exam_id');
                    optgroup.append(o);
                });
                if(optgroup.children().length > 0)
                    $('#exam-master-id').append(optgroup);
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
        appendExams(arrayData);
        appendSubjects(arrayData);

        //var url = '".$this->Url->build(['action'=>'getParentExams.json'])."';
        
        // $.post(url,{class_mapping_id: $(this).val()},function(result){
        //     var response = JSON.parse(JSON.stringify(result));
        //     $.each(response.response, function (index, value) {
        //         var o = $('<option/>', {value: value.id, text: value.name});
        //         o.attr('save_to','exam_master_id');
        //         $('#exam-master-id').append(o);
        //     });

        //     $('#exam-master-id').val($('#exam-master-id option:first-child').val()).trigger('change');

        //     arr = {};
        // });
    });

    $(document).on('click','#add_student',function(e){
        e.preventDefault();
        $('#table1').removeClass('hidden');

        //getting max Marks
        var URL = '".$this->Url->build(['action'=>'getMaxMarks.json'])."';
        save_to = $('#exam-master-id :selected').attr('save_to');
        var data = {};
        data['subject_id'] = $('#subject-id').val();
        data['exam_master_id'] = $('#exam-master-id').val();
        data['save_to'] = save_to;
        data = JSON.parse(JSON.stringify(data));

        $.post(URL,data,function(result){
            var response = JSON.parse(JSON.stringify(result));
            if(response.success)
            {
                var a = parseInt(response.response) || 0;
                if(a == 0)
                    $('.marks').attr('type','text');

                $('#class-mapping-id').attr('max',a);
            }
        });

        //appending students
        var arrayData = {};
        var studentInfos = {}
        var ExamMasters = {}
        save_to = $('#exam-master-id :selected').attr('save_to');
        arrayData['class_mapping_id'] = $('#class-mapping-id').val();
        arrayData[save_to] = $('#exam-master-id').val();
        arrayData['subject_id'] = $('#subject-id').val();

        var data = JSON.parse(JSON.stringify(arrayData));

        var url = '".$this->Url->build(['controller'=>'StudentMarks','action'=>'getStudentsSingle.json'])."';        
        $('#main').html('');
        $.post(url,data,function(result){
            var response = JSON.parse(JSON.stringify(result));
            var i = 0;
            $.each(response.response, function(key,value) {
                i++;
                var o = \"<tr> \\
                            <td>\"+i+\"</td>\\
                            <td>\"+value.rollno+\"</td>\\
                            <td>\"+value.name+\"</td>\";

                $('#main').append(o);
            });
        });
    });

    $(document).on('focusin', '.marks', function(){
        $(this).data('val', $(this).val());
    }).on('change','.marks', function(){
        var textbox = parseInt($(this).val());
        var max = parseInt($('#class-mapping-id').attr('max')) || 0;
        if(max == 0 && $.isNumeric($(this).val()))
        {
            alert('Either enter max marks or enter grade.');
            $(this).val($(this).data('val'));
            $(this).focus();
        }
        else
        if(textbox > max)
        {
            alert('value should be less then or equal to '+max)
            $(this).val($(this).data('val'));
            $(this).focus();
        }
        else
        {
            var arrayData = {}
            save_to = $('#exam-master-id :selected').attr('save_to');
            arrayData[save_to] = $('#exam-master-id').val();
            arrayData['subject_id'] = $('#subject-id').val();
            arrayData['student_info_id'] = $(this).parent().find('.student_info_id').val();
            arrayData['student_number'] = $(this).val();

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
    });

    $(document).on('change','select',function(){
        $('#main').html('');
    });

});";
$this->Html->scriptBlock($js,['block'=>'scriptPageBottom']);
?>

