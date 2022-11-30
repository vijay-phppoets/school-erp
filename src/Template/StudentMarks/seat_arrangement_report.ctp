<style>
@media print {
  .printdata{
         display:none;
     }
}
.hide{
    display: none;
}
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                   Seat Arrangement
                </h3>

            </div>
           
            <div class="box-body padding" style="width: 100% !important;">
                 <?= $this->Form->create('studentMark') ?> 
                    <div class="row printdata">
                            <div class="col-md-3">
                                <label class="control-label"> Class <span class="required" aria-required="true"> * </span></label>
                            
                                <?php echo $this->Form->control('class_mapping_id', ['empty'=>'--- Select---','options' => $classMappings,'class'=>'select2','style'=>'width:100%','label'=>false]);?>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label"> Exam</label>
                            
                                <?php echo $this->Form->control('exam_master_id', ['empty'=>'--- Select ---','options' => [],'class'=>'selectClass1 select2 seatArrange','style'=>'width:100%','label'=>false,'value'=>@$exam_master,'id'=>'exam-master-id']);?>
                                <?php echo $this->Form->control('exam_hide', ['class'=>'form-control hide','style'=>'width:100%','id'=>'exam_hides','type'=>'text','label'=>false]);?>

                            </div>
                            <div class="col-md-3">
                                <label class="control-label"> Room No.</label>
                            
                                <?php echo $this->Form->control('room_no', ['class'=>'form-control seatArrange','style'=>'width:100%','label'=>false]);?>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">Student Capacity</label>
                            
                                <?php echo $this->Form->control('student_capacity', ['class'=>'form-control seatArrange','style'=>'width:100%','label'=>false,'id'=>'student_capacity']);?>
                            </div>
                        </div>
                        <div class="row printdata">
                            <div class="col-md-3">
                                <div class="form-group">
                                     <label class="control-label">No of Rows</label>
                                <?php
                                    $rows[]=['value'=>'1','text'=>'1'];
                                    $rows[]=['value'=>'2','text'=>'2'];
                                    $rows[]=['value'=>'3','text'=>'3'];
                                    $rows[]=['value'=>'4','text'=>'4'];
                                    $rows[]=['value'=>'5','text'=>'5'];
                                    echo $this->Form->control('row',array('options' => @$rows,'class'=>'form-control input-sm selectClass','empty' => '--Select Row--','label'=>false)); 
                                ?>
                                </div>
                            </div>

                            <!-- <div class="col-md-3">
                                <button type="submit" class="btn btn-default btn-primary btnClass">View</button>
                            </div> -->
                        </div>
                <?php if(!empty($exam_master)){?>
                <div class="portlet-body printdata">
                    <table style="border:none;width:100%;border: 1px solid #E5E5E5;" >
                        <tr>
                        <td style="width:12%;vertical-align:center; padding:0 2% 0.5% 2%;"><b>Exam Date<b></td>
                        <?php $j=0;
                        for($i=1;$i<=10;$i++)
                        {
                        ?>
                            <td style="padding:0 2% 0.5% 2%;">
                            <b>Day  <?php echo $i;?></b> 
                                <?php echo $this->Form->control('Examdate[]',['type'=>'text','class'=>'form-control input-sm  datepicker hello'.$j.'','placeholder'=>'dd-mm-yyyy','data-date-format'=>"dd-mm-yyyy",'label'=>false,'autofocus', 'autocomplete'=>'off','value'=>@$Examdatess[$j]]); ?>
                            </td>
			<td><a href="#" onclick='session_ex(<?php echo $j;?>);'>Unset Date</a></td>
                        <?php 
                        if($i==5)
                        {
                            echo '</tr><tr><td style="width:12%;vertical-align:center; padding:0 2% 0.5% 2%;"><b>Exam Date<b></td>';
                        } $j++;
                        } ?>
                        </tr>
                    </table>
                </div>
                <?php } ?>
                <?php 
                    if(!empty($row)){
                ?>
                <div class="table" id="table1">
                    <h3 style="text-align: center;"><strong>SEATING ARRANGEMENT</strong></h3>
                    <div class="row" align="center">
					
                       <?= $this->Form->button('' . __(' Print Attendence List'),['class'=>'btn btn-primary hide_print','id' =>'submitbtn','formtarget'=>'_blank','formaction'=>'printattendanceLists?room_no='.$room_no.'&&exam_hide='.urlencode(trim($exam_hide)).'&&section_id='.$section_id.'&&exam_id='.$exam_master,'align'=>'right']); ?>
                         <?= $this->Form->button('' . __(' Print Admit Card'),['class'=>'btn btn-primary hide_print','id' =>'submitbtn','formtarget'=>'_blank','formaction'=>'admitCard/'.$room_no.'/'.$exam_hide.'/'.$exammain->toArray()[0]['exam_master_id'],'align'=>'right']); ?>
                        <button type="button" class="btn btn-primary hide_print" onclick="window.print()" align="right" >Print </button>
                                
                    </div>
                    <div style="width:100%;margin-top:10px; text-align:center;" align="center">
                    <table align="center" class="table-bordered table-hover" width="35%">
                        <tbody><tr>
                            <th height="30px" width="15%">&nbsp; Term : &nbsp; </th>
                            <th height="30px" width="15%" id="exams">&nbsp;<?= @$exam_hide?>&nbsp; </th>
                        </tr>
                        <tr>
                            <th height="30px">&nbsp;<strong>Room No. :</strong> &nbsp; </th>
                            <th height="30px">&nbsp; <strong><?= @$room_no ?></strong> &nbsp; </th>
                        </tr>
                        <tr>
                            <th height="30px">&nbsp; <strong>Total Student</strong> : &nbsp; </th>
                            <th height="30px">&nbsp; <strong><?= @$student_capacity ?></strong> &nbsp; </th>
                        </tr>
                    </tbody></table>
                    <table class="table-bordered table" width="100%" style="margin-top:1%;" id="main_table">
                        <thead>
                            <tr>
                                <th style="width:15%;">
                                    Roll. No. &rarr; 
                                </th> 
                                <?php
                                for($a=1;$a<=@$row;$a++)
                                {
                                ?>
                                <th style="text-Align:center;width:15%;">
                                    <?php echo $this->Form->input('rollno',array('class'=>'form-control input-sm','label'=>false,'id'=>'rollnoId','row_no'=>$a,'no'=>1,'style'=>'float: left;width: 49%;margin-right: 1px;')); ?>
                                    <?php echo $this->Form->input('rollno',array('class'=>'form-control input-sm','label'=>false,'id'=>'rollnoId','row_no'=>$a,'no'=>2,'style'=>'float: right;width: 49%;margin-left: 1px;')); ?>
                                </th> 
                                <?php } ?>
                            </tr>
                            <tr>
                                <th tyle="width:15%;">
                                    Column &rarr;
                                </th>
                                <?php
                                for($b=1;$b<=@$row;$b++)
                                {
                                ?>
                                <th rowspan="2" style="text-Align:center;vertical-align:top;width:15%;">
                                    <?php echo $b;?>
                                </th> 
                                <?php } ?>
                            </tr>
                            <tr>
                                <th>
                                    Rows &darr;
                                </th>
                            </tr>
                        </thead>
                        <tbody id="main_tbody">
                            <?php
                            @$coulmn_dubb     = @$row*2;
                            @$coulmn_dubb_inc = $coulmn_dubb+1;
                            @$rowscc          = $student_capacity/$coulmn_dubb;
                            @$rowNo           = $rowscc+1;
                            for($c=1;$c<=$rowNo;$c++)
                            {
                            ?>
                            <tr class="main_tr">
                                <td><?php echo @$c;?></td>
                                <?php
                                for($b=1;$b<=@$row;$b++)
                                {
                                ?>
                                <td style="width:15%;">
                                    <?php echo $this->Form->input('rollno[]',array('class'=>'form-control input-sm Assignrollno_'.$b.'_1','label'=>false,'style'=>'float: left;width: 49%;margin-right: 1px;')); ?>
                                    <?php echo $this->Form->input('rollno[]',array('class'=>'form-control input-sm Assignrollno_'.$b.'_2','label'=>false,'style'=>'float: right;width: 49%;margin-left: 1px;')); ?>
                                </td> 
                                <?php } ?>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
                </div>
            <?php } ?>
            </div>
            </form>
        </div>
    </div>
</div>
<?= $this->element('selectpicker');?>
<?= $this->element('loading');?>
<?= $this->element('daterangepicker') ?>
<?= $this->element('datepicker') ?> 
<?= $this->element('medium class stream filter all');?>
<?php
$js="

$(document).ready(function(){

    $(document).on('change','#exam-master-id',function()
    {
     var optionText = $('#exam-master-id option:selected').text();
     $('#exam_hides').val(optionText);
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

    // function appendSubjects(arrayData)
    // {
    //     $('#subject-id').empty();
    //     $('#subject-id').select2();
    //     var data2 = JSON.parse(JSON.stringify(arrayData));
    //     var url = '".$this->Url->build(['controller'=>'FacultyClassMappings','action'=>'getSubjects.json'])."';
        
    //     $.post(url,data2,function(result){
    //         var response = JSON.parse(JSON.stringify(result));
    //         var og = null;
    //         var optgroup = $();
    //         $.each(response.response, function (index, value) {
    //             if(value.parent != og)
    //             {
    //                 og = value.parent;
    //                 if(optgroup.children().length > 0)
    //                     $('#subject-id').append(optgroup);

    //                 optgroup = $('<optgroup/>');
    //                 optgroup.attr('label',value.parent);
    //             }

    //             var o = $('<option/>', {value: value.id, text: value.name});

    //             if(optgroup.attr('label') !== null && optgroup.attr('label') !== undefined)
    //                 optgroup.append(o);
    //             else
    //                 $('#subject-id').append(o);
    //         });

    //         if(optgroup.children().length > 0)
    //             $('#subject-id').append(optgroup);
    //     });
    // }

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

    // $(document).on('click','#add_student',function(e){
    //     e.preventDefault();
    //     $('#table1').removeClass('hidden');

    //     //getting max Marks
    //     var URL = '".$this->Url->build(['action'=>'getMaxMarks.json'])."';
    //     save_to = $('#exam-master-id :selected').attr('save_to');
    //     var data = {};
    //     data['subject_id'] = $('#subject-id').val();
    //     data['exam_master_id'] = $('#exam-master-id').val();
    //     data['save_to'] = save_to;
    //     data = JSON.parse(JSON.stringify(data));

    //     $.post(URL,data,function(result){
    //         var response = JSON.parse(JSON.stringify(result));
    //         if(response.success)
    //         {
    //             var a = parseInt(response.response) || 0;
    //             if(a == 0)
    //                 $('.marks').attr('type','text');

    //             $('#class-mapping-id').attr('max',a);
    //         }
    //     });

    //     //appending students
    //     var arrayData = {};
    //     var studentInfos = {}
    //     var ExamMasters = {}
    //     save_to = $('#exam-master-id :selected').attr('save_to');
    //     arrayData['class_mapping_id'] = $('#class-mapping-id').val();
    //     arrayData[save_to] = $('#exam-master-id').val();
    //     arrayData['subject_id'] = $('#subject-id').val();

    //     var data = JSON.parse(JSON.stringify(arrayData));

    //     var url = '".$this->Url->build(['controller'=>'StudentMarks','action'=>'getStudentsSingle.json'])."';        
    //     $('#main').html('');
    //     $.post(url,data,function(result){
    //         var response = JSON.parse(JSON.stringify(result));
    //         var i = 0;
    //         $.each(response.response, function(key,value) {
    //             i++;
    //             var o = \"<tr> \\
    //                         <td>\"+i+\"</td>\\
    //                         <td>\"+value.rollno+\"</td>\\
    //                         <td>\"+value.name+\"</td>\\
    //                         <td></td>\\
    //                         <td></td>\\
    //                         <td></td>\\
    //                     </tr>\";

    //             $('#main').append(o);
    //         });
    //     });
    // });

    // $(document).on('focusin', '.marks', function(){
    //     $(this).data('val', $(this).val());
    // }).on('change','.marks', function(){
    //     var textbox = parseInt($(this).val());
    //     var max = parseInt($('#class-mapping-id').attr('max')) || 0;
    //     if(max == 0 && $.isNumeric($(this).val()))
    //     {
    //         alert('Either enter max marks or enter grade.');
    //         $(this).val($(this).data('val'));
    //         $(this).focus();
    //     }
    //     else
    //     if(textbox > max)
    //     {
    //         alert('value should be less then or equal to '+max)
    //         $(this).val($(this).data('val'));
    //         $(this).focus();
    //     }
    //     else
    //     {
    //         var arrayData = {}
    //         save_to = $('#exam-master-id :selected').attr('save_to');
    //         arrayData[save_to] = $('#exam-master-id').val();
    //         arrayData['subject_id'] = $('#subject-id').val();
    //         arrayData['student_info_id'] = $(this).parent().find('.student_info_id').val();
    //         arrayData['student_number'] = $(this).val();

    //         var data = JSON.parse(JSON.stringify(arrayData));

    //         var url = '".$this->Url->build(['action'=>'saveMarks.json'])."';        
            
    //         $.ajax({
    //             type: 'POST',
    //             url: url,
    //             data: data,
    //             success: function(result){
    //                 var response = JSON.parse(JSON.stringify(result));
    //                 if(response.success)
    //                 {
    //                     toastr.options.closeButton = true;
    //                     toastr.options.timeOut = 900;
    //                     toastr.success('Saved');
    //                 }
    //                 else
    //                 {
    //                     toastr.options.closeButton = true;
    //                     toastr.options.timeOut = 900;
    //                     toastr.error('Unabel to save');
    //                     $(this).val($(this).data('val'));
    //                     $(this).focus();
    //                 }
    //             },
    //             global: false
    //         });
    //     }
    // });

    $(document).on('change','select',function(){
        $('#main').html('');
    });
    $(document).on('change','.selectClass',function(e){
        seat_arrangement();
    });
    $(document).on('blur','.seatArrange',function(e){
        seat_arrangement();
    });
    
    $(document).on('keyup','#rollnoId',function(e){
        var row_no  = $(this).attr('row_no');
        var no  = $(this).attr('no');
        var roll_no_val = $(this).val();
        var x = parseInt(row_no)+1; 
        
        $('#main_table tbody#main_tbody tr.main_tr').each(function(){ 
            if(roll_no_val=='')
            {
                $(this).find('td:nth-child('+x+') input.Assignrollno_'+row_no+'_'+no).val('');
            }
            else{
                $(this).find('td:nth-child('+x+') input.Assignrollno_'+row_no+'_'+no).val(roll_no_val);
                var rn=roll_no_val++;

            }         

            
        });
        
    });
    function seat_arrangement()
    {
        var section_id         = $('select[name=section_id]').find('option:selected').val();
        var exam_master_id    = $('.selectClass1').find('option:selected').val();
        var exam_hide         = $('#exam-master-id').find('option:selected').text();
        var row             = $('#row').find('option:selected').val();
        var room_no         = $('input[name=room_no]').val();
        var student_capacity   = $('#student_capacity').val();
        if(exam_master_id!='' & row!='' & room_no!='' & student_capacity!='')
        {
            window.location.href = window.location.pathname+'?'+$.param({'exam_master_id':exam_master_id})+'&'+$.param({'row':row})+'&'+$.param({'exam_hide':exam_hide})+'&'+$.param({'room_no':room_no})+'&'+$.param({'student_capacity':student_capacity});
        }
    }

});
function session_ex(id)
	 {
		 $('.hello'+id).val('');
		  
	 }
";
$this->Html->scriptBlock($js,['block'=>'scriptPageBottom']);
?>

