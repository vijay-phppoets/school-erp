
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
                    Exam Attendance Report
                </h3>
            </div>
            <div class="box-body padding content-scroll" style="width: 100% !important;">
                <?= $this->Form->create('studentMark') ?>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label"> Class <span class="required" aria-required="true"> * </span></label>
                        
                            <?php echo $this->Form->control('class_mapping_id', ['empty'=>'--- Select---','options' => $classMappings,'class'=>'select2','style'=>'width:100%','label'=>false,'val'=>@$class_mapping_id]);?>
                        </div>

                        <div class="col-md-3">
                            <label class="control-label"> Exam</label>
                        
                            <?php echo $this->Form->control('exam_master_id', ['empty'=>'--- Select ---','options' => '','class'=>'select2 exam','style'=>'width:100%','label'=>false,'val'=>@$exam_id,'required']);?>
                        </div>

                        <div class="col-sm-3">
                            <?= $this->Form->submit('search',['class'=>'btn btn-primary btnClass']) ?>
                        </div>
                    </div>
                <?= $this->Form->end() ?>
                <div class="portlet-body form">
            <?php if(!empty(@$exam_id)){?>
                <div class="row">
                            <div class="col-md-12">
                                <div id="table-container">
                                    <table class="table table-bordered" id="main_tble" style="margin-top: 20px;">
                                        <thead>
                                            <tr>
                                                <td>Sr No</td>
                                                <td>Roll No</td>
                                                <td>Scholar No</td>
                                                <td>Student Name</td>
                                                <td>Total Meeting</td>
                                                <td>Meeting Attend</td>
                                                <td>Percentage</td>
                                            </tr>   
                                        </thead>

<!-- @coder-kabir 08-03-2022 ---------------------------------------------------------------------------------->

<tbody>
<?php if(!empty($getStudents)){ ?>
    <?php foreach($getStudents as $idx => $student_infos){ ?>
    <tr>
        <td student_id="<?= $student_infos->id ;?>" section_id="<?php echo $section_id; ?>" class_id="<?php echo $class_id; ?>" stream_id="<?php echo $stream_id; ?>" medium_id="<?php echo $medium_id; ?>" exam_id="<?php echo $exam_id; ?>"><?= h($idx + 1)?></td>
        <td width="10%"><?= $student_infos->roll_no; ?></td>
        <td width="10%"><?= $student_infos->student->scholar_no; ?></td>
        <td width="40%"><?= $student_infos->student->name; ?></td>
        <td>
            <?php echo @$this->Form->control(
                'total_meetings',['id'=>'TotalMeeting','class'=>'form-control input-sm Attendence','placeholder'=>'Total Meeting','label'=>false,'autofocus','required'=>'required',
                'value'=>@$totalMeetingArr[$student_infos->id][@$medium_id][@$stream_id][@$class_id][@$section_id][@$exam_id]]); ?>    
        </td>
        <td><?php echo @$this->Form->control('meetings_attended',['id'=>'MeetingsAttended','class'=>'form-control input-sm Attendence ','placeholder'=>'Meetings Attended','label'=>false,'autofocus','required'=>'required', 'value'=>@$meetingsAttendedArr[$student_infos->id][@$medium_id][@$stream_id][@$class_id][@$section_id][@$exam_id]]); ?></td>
            <?php if((!empty(@$meetingsAttendedArr[$student_infos->id][@$medium_id][@$stream_id][@$class_id][@$section_id][@$exam_id]))&&(@$totalMeetingArr[$student_infos->id][@$medium_id][@$stream_id][@$class_id][@$section_id][@$exam_id]))  {?>
                <td>
                <?= round((@$meetingsAttendedArr[$student_infos->id][@$medium_id][@$stream_id][@$class_id][@$section_id][@$exam_id] * 100)/@$totalMeetingArr[$student_infos->id][@$medium_id][@$stream_id][@$class_id][@$section_id][@$exam_id]).'%'?>
                </td>
            <?php } else { ?>  <td>-</td>  <?php } ?>
        </tr>   
    <?php } } else { ?>
        <tr>
            <td colspan="4">Record not found.</td>
        </tr>
    <?php } ?>
</tbody>

</table>

<!-- done :) ---------------------------------------------------------------------------------->


                                    
                                    <div id="bottom_anchor"></div>
                                    
                                </div>
                            </div>   
                        </div>
            <?php } ?>
            </div>
            </div>
        </div>
    </div>
</div>
<?= $this->element('selectpicker');?>
<?= $this->element('loading');?>
<?= $this->element('medium class stream filter all');?>

<?php echo $this->Html->css('/assets/global/plugins/clockface/css/clockface.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
    <?php echo $this->Html->css('/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
    <?php echo $this->Html->css('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
    <?php echo $this->Html->css('/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
    <?php echo $this->Html->css('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
    <?php echo $this->Html->css('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
    <!-- END COMPONENTS PICKERS -->

    <!-- BEGIN COMPONENTS DROPDOWNS -->
    <?php echo $this->Html->css('/assets/global/plugins/bootstrap-select/bootstrap-select.min.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
    <?php echo $this->Html->css('/assets/global/plugins/select2/select2.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
    <?php echo $this->Html->css('/assets/global/plugins/jquery-multi-select/css/multi-select.css', ['block' => 'PAGE_LEVEL_CSS']); ?>
    <!-- END COMPONENTS DROPDOWNS -->
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- BEGIN COMPONENTS PICKERS -->
    <?php echo $this->Html->script('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
    <?php echo $this->Html->script('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
    <?php echo $this->Html->script('/assets/global/plugins/clockface/js/clockface.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
    <?php echo $this->Html->script('/assets/global/plugins/bootstrap-daterangepicker/moment.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
    <?php echo $this->Html->script('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
    <?php echo $this->Html->script('/assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
    <?php echo $this->Html->script('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
    <!-- END COMPONENTS PICKERS -->
    
    <!-- BEGIN COMPONENTS DROPDOWNS -->
    <?php echo $this->Html->script('/assets/global/plugins/bootstrap-select/bootstrap-select.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
    <?php echo $this->Html->script('/assets/global/plugins/select2/select2.min.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
    <?php echo $this->Html->script('/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js', ['block' => 'PAGE_LEVEL_PLUGINS_JS']); ?>
    <!-- END COMPONENTS DROPDOWNS -->
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
    <!-- BEGIN COMPONENTS PICKERS -->
    <?php echo $this->Html->script('/assets/admin/pages/scripts/components-pickers.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
    <!-- END COMPONENTS PICKERS -->

    <!-- BEGIN COMPONENTS DROPDOWNS -->
    <?php echo $this->Html->script('/assets/global/scripts/metronic.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
    <?php echo $this->Html->script('/assets/admin/layout/scripts/layout.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
    <?php echo $this->Html->script('/assets/admin/layout/scripts/quick-sidebar.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
    <?php echo $this->Html->script('/assets/admin/layout/scripts/demo.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>
    <?php echo $this->Html->script('/assets/admin/pages/scripts/components-dropdowns.js', ['block' => 'PAGE_LEVEL_SCRIPTS_JS']); ?>

<?php 
$js = "
$(document).ready(function() {
        
       

    $(document).on('blur', '.Attendence', function(e)
    { 
        var student_id            = $(this).closest('tr').find('td:nth-child(1)').attr('student_id'); 
        var section_id            = $(this).closest('tr').find('td:nth-child(1)').attr('section_id'); 
        var class_id            = $(this).closest('tr').find('td:nth-child(1)').attr('class_id'); 
        var stream_id            = $(this).closest('tr').find('td:nth-child(1)').attr('stream_id'); 
        var medium_id            = $(this).closest('tr').find('td:nth-child(1)').attr('medium_id'); 
        var exam_id               = $(this).closest('tr').find('td:nth-child(1)').attr('exam_id'); 

        var TotalMeeting          = $(this).closest('tr').find('td:nth-child(5) input').val();
        var MeetingsAttended      = $(this).closest('tr').find('td:nth-child(6) input').val();
        if ((student_id!='' && TotalMeeting!='') || (student_id!='' && MeetingsAttended!='')) 
        { 
            if(TotalMeeting=='')
            {
                TotalMeeting=0;
            }
            if(MeetingsAttended=='')
            {
                MeetingsAttended=0;
            }
            var url='".$this->Url->build(["controller" => "Students", "action" => "saveExamWiseAttendance"])."';
            url=url+'/'+student_id+'/'+class_id+'/'+stream_id+'/'+medium_id+'/'+section_id+'/'+TotalMeeting+'/'+MeetingsAttended+'/'+exam_id;
            $.ajax({
                url: url,
                type: 'GET'
            }).done(function(response) { 
                $('.successMsg').show();
                setTimeout(explode, 1000);
            }); 
        }
    });
    
    $(document).on('click', '#uplodeBtn', function(e)
    {
        $('.showUplode').slideToggle();
    });
    function explode()
    { 
        $('.successMsg').hide();
    }
    function checkValidation()
    {
            $('.submit').attr('disabled','disabled');
            $('.submit').text('Submiting...');
    }
    
    function moveScroll(){ 
    var scroll = $(window).scrollTop();
    var anchor_top = $('#main_tble').offset().top;
    var anchor_bottom = $('#bottom_anchor').offset().top;
    if (scroll>anchor_top && scroll<anchor_bottom) {
    clone_table = $('#clone');
    if(clone_table.length == 0){
        clone_table = $('#main_tble').clone();
        clone_table.attr('id', 'clone');
        clone_table.css({position:'fixed',
                 'pointer-events': 'none',
                 top:48});
        clone_table.width($('#main_tble').width());
        $('#table-container').append(clone_table);
        $('#clone').css({visibility:'hidden'});
        $('#clone thead').css({visibility:'visible'});
    }
    } else {
    $('#clone').remove();
    }
    }
    $(window).scroll(moveScroll);


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
    });
});
";
$this->Html->scriptBlock($js, ['block' => 'scriptPageBottom']);
 ?>