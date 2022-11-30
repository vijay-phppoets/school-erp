<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StudentMark $studentMark
 */
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
<?php endif 
?>

<style type="text/css">
    .row{
        margin-bottom: 20px;
    }
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border" >
                    <label>Exam Time Table </label>
                </div>
                <?= $this->Form->create($timeTablePeriods,['id'=>'ServiceForm']) ?>

                <div class="box-body">
                    
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <label class="control-label"> Class <span class="required" aria-required="true"> * </span></label>
                            
                                <?php echo $this->Form->control('class_mapping_id', ['empty'=>'--- Select---','options' => $classMappings,'class'=>'select2','style'=>'width:100%','label'=>false,'val'=>'','id'=>'class_mapping_id','required'=>true]);?>
                            </div>

                            <div class="col-md-4">
                                <label class="control-label"> Exam</label>
                            
                                <?php echo $this->Form->control('exam_master_id', ['empty'=>'--- Select ---','options' => '','class'=>'select2','style'=>'width:100%','label'=>false,'val'=>'']);?>
                            </div>

                            <div class="col-md-2">
                                <!-- <button type="button" class="btn btn-primary add_row() btn-md add_button" style="margin-top: 25px;"><i>SUBMIT</i></button> -->
                                <?php echo $this->Form->button('Add',['class'=>'btn btn-primary add_row() btn-md add_button']); ?>

                            </div>
                        </div>
                    
                    <div class="form-group submit" style="display: none;">
                        <span class="help-block"></span>
                        <div class="row">
                            <fieldset><legend>Exam Time Table Schedule</legend>
                                <center>                        
                                <table style="width:100%;align:center" class="table table-bordered table-hover" id="parant_table">
                                    <thead>
                                        <tr style="background-color:#8a8a8a2e;">  
                                            <!-- <th style="text-align:center">Medium</th>
                                            <th style="text-align:center">Class</th>
                                            <th style="text-align:center">Section</th>
                                            <th style="text-align:center">Stream</th> -->
                                            <th style="text-align:center;width: 300px;">Subject</th>
                                            <th style="text-align:center">Date</th>
                                            <th style="text-align:center">Time From</th>
                                            <th style="text-align:center">Time To</th>
                                            <th colspan="2" style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="parant_table">
                                    
                                    </tbody>
                                </table>
                                </center>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="box-footer" style="display: none;">
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
<table id="sample" style="display:none;">
    <tbody>
        <tr>
    
        <tr>
           
            <td>
                
                    <?php echo $this->Form->control('subject_id[]', ['options' => [],'class'=>'classMapping','style'=>'width:100%','label'=>false,'val'=>'','required'=>true]);?>
                 
            </td>
            <td>
                <div class="bootstrap-datepicker"> 
                    <?php echo $this->Form->control('date[]',[
                    'label' => false,'class'=>'form-control datepicker','placeholder'=>'Date','type'=>'type','required'=>true]);?>
                </div> 
            </td>
            <td>
                <div class="bootstrap-timepicker"> 
                    <?php echo $this->Form->control('time_from[]',[
                    'label' => false,'class'=>'form-control timepicker time_from','placeholder'=>'Time','type'=>'type','required'=>true]);?>
                </div> 
            </td>
            <td>
                <div class="bootstrap-timepicker" > 
                    <?php echo $this->Form->control('time_to[]',[
                    'label' => false,'class'=>'form-control time_to timepicker','placeholder'=>'Time','type'=>'text','required'=>true]);?>
                </div>
            </td>
            <td align="center">
                <!-- <button type="button" onClick="add_row()" class="btn btn-primary btn-sm" style="text-align: center;"><i class="fa fa-plus"></i></button> -->
                 <?php echo $this->Form->button('<i class="fa fa-plus"></i>',['class'=>'btn btn-primary btn-sm','onClick'=>'add_row()']); ?>
            </td>
            <td align="center">
            	<!-- <button type="button"  class="btn btn-danger btn-sm remove_row"><i class="fa fa-trash-o"></i></button> -->
                <?php echo $this->Form->button('<i class="fa fa-trash-o"></i>',['class'=>'btn btn-danger btn-sm remove_row']); ?>
            </td>
        </tr>
    </tbody> 
</table>
<?= $this->element('validate') ?>
<?= $this->element('timepicker') ?>
<?= $this->element('datepicker') ?>
<?= $this->element('selectpicker') ?>  
<?php
$js="

$(document).ready(function(){
    add_row();
	//$('.select2').select2();
    
    $('#ServiceForm').validate({ 
        rules: {
            class_mapping_id: {
                required: true
            },
            subject_id: {
                required: true
            }, 
            medium_id: {
                required: true
            },
            class_id: {
                required: true
            }, 
            
            description: {
                required: true
            },
            document:{
                required: true
            },
            students:{
                required: true
            },
        },
        submitHandler: function () {
            $('#loading').show();
            $('#submit_member').attr('disabled','disabled');
            form.submit();
        }
    });

});";

 
$js .= "


    function appendSubjects(arrayData)
    {
        // alert('0');
        // $('#subject-id').empty();
      //  $('#subject-id').select2();
        $('.classMapping').css('color','#756e6e');
        var data2 = JSON.parse(JSON.stringify(arrayData));
        var url = '".$this->Url->build(['controller'=>'FacultyClassMappings','action'=>'getSubjects.json'])."';
        
        $.post(url,data2,function(result){
            // alert();
            var response = JSON.parse(JSON.stringify(result));
            var og = null;
            var optgroup = $();
            $.each(response.response, function (index, value) {
                if(value.parent != og)
                {   
                    // alert('1');
                    og = value.parent;
                    if(optgroup.children().length > 0)
                        $('.classMapping').append(optgroup);
                        //$('#subject-id').append(optgroup);

                    optgroup = $('<optgroup/>');
                    optgroup.attr('label',value.parent);
                }

                var o = $('<option/>', {value: value.id, text:value.parent+' > '+ value.name});

                if(optgroup.attr('label') !== null && optgroup.attr('label') !== undefined)
                {
                    // alert('2');
                    optgroup.append(o);
                }
                else{
                    // alert('3');
                    $('.classMapping').append(o);
                    //$('.subject-id').append(o);
                }
            });

            if(optgroup.children().length > 0){
                // alert('4');
                $('.classMapping').append(optgroup);
            }
        });
    }

    function appendExams(arrayData)
    {
        // alert();
        $('#exam-master-id').empty();
        $('#exam-master-id').select2();
        var data = JSON.parse(JSON.stringify(arrayData));
        // alert(data);
        var url = '".$this->Url->build(['controller'=>'StudentMarks','action'=>'getParentExams.json'])."';
        // alert(url);
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
    $('#class_mapping_id').on('change',function(){
        var arrayData = {}
        arrayData['class_mapping_id'] = $(this).val();
        window.getdata = arrayData['class_mapping_id'];
        //alert(window.getdata);
        appendExams(arrayData);
        appendSubjects(arrayData);
    });
    // $(document).on('change','#class-mapping-id',function()
    // {
    //     var arrayData = {}
    //     arrayData['class_mapping_id'] = $(this).val();
    //     alert('hello');
    //     appendExams(arrayData);
    //     appendSubjects(arrayData);
    // });

";

$js.='

    $(".add_button").on("click",function(){
        
        var books = $("#class_mapping_id");
            if (books.val() === "") {
                alert("Please Select Class!");
            }
            else{
                $(this).hide();
                $(".box-footer").show();
                $(".submit").slideDown("slow");
            }
    });

$(document).on("click", ".remove_row", function(){
    $(this).closest("#parant_table tr").remove();
});
function add_row(){    
    var new_line=$("#sample tbody").html();
    $("#parant_table tbody.parant_table").append(new_line);
    // $(".parant_table>tr:last").find(".day").select2();
    // $(".parant_table>tr:last").find(".employee_id").select2();
    $(".timepicker").timepicker({
      showInputs: false
    });$(".datepicker").datepicker({
      showInputs: false
    });
}
';
$this->Html->scriptBlock($js,['block'=>'scriptPageBottom']);
?>
