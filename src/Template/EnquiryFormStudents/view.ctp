<style type="text/css">
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    line-height: 2;
    border-top: none;
    font-weight: 700;
}
.table{
    font-size: 16px !important;
}
.enquiry_status{
    float: right !important;
    padding: 5px 12px !important;
    color: #fff;
    font-size: 15px !important;
    margin-top: 5px !important;
    letter-spacing: 1px !important;
    border-top-left-radius: 16px !important;
    border-bottom-left-radius: 16px !important;
    margin-right: -10px !important;
}
.selectpicker
{
    float: right !important;
    padding: 5px 12px !important;
}
.Pending{
    
    background-color: #ffbc1b;
}
th {
    font-weight: 700 !important;
}
.Approved{
    
    background-color: #56c066;
}
.Hold{
    
    background-color: #13cdd4;
}
.Reject{
    
    background-color: #f94c4c;
}
</style>
   <?=$this->element('school_detail')?>
   <br>
<div class="box box-primary">
    <div class="box-header with-border">
        <div class="pull-right box-tools">
            <?= $this->Html->link('Print','javascript:window.print();',['escape'=>false,'class'=>'btn bg-maroon hide_print','style'=>'color:#fff !important;']) ?>
        </div>
      
        <h3 class="box-title" >Enquiry Details</h3>
        <?php
        /*if($enquiryFormStudent->admission_form_no > 0)
        {
            ?>
            <h3 class="box-title enquiry_status <?= h($enquiryFormStudent->enquiry_status) ?>"  ><?= h($enquiryFormStudent->enquiry_status) ?>
           </h3>
            <?php
        }
        else
        {
            ?>
            <div class="box-title selectpicker">
            <?= $this->Form->create($enquiryFormStudent,['id'=>'ServiceForm']) ?>
                <?php echo $this->Form->control('enquiry_status',[
                'label' => false,'class'=>'select2','empty'=>'','options'=>$enquiryStatuses,'required'=>true,'id'=>'enquiry_status']);?>
            <?= $this->Form->end() ?>
            </div>
            <?php
        }*/
        ?>

        
    </div>

    <div class="row">
        <div class="col-md-12"  style="padding: 8px 8px 30px 26px;" >
            <table class="table mt-5" style="border-collapse:collapse;">
                <tbody>
                    <tr>
                        <th style="width: 25%">Enquiry  No.: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->enquiry_no)?></td>
                        <th style="width: 25%">Enquiry Mode: </th>
                        <td style="font-weight: 700;width: 25%"><?= $this->Text->autoParagraph(h($enquiryFormStudent->enquiry_mode)); ?></td>
                    </tr>
                    <tr>
                        <th style="width: 25%">Name: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->name)?></td>
                        <th style="width: 25%">Gender: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->gender->name)?></td>
                    </tr>
                    <tr>
                        <th style="width: 25%">Mother Name: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->mother_name)?></td>
                        <th style="width: 25%">Mobile No: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->mobile_no)?></td>
                    </tr>
                    <tr>
                        <th style="width: 25%">Father Name: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->father_name)?></td>
                        <th style="width: 25%">Class: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->student_class->name)?></td>
                        
                    </tr>
                    <tr>
                        <th style="width: 25%">Enquiry Date: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->enquiry_date) ?></td>
                        <th style="width: 25%">Last School: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->last_school)?></td>
                        
                    </tr>
                    <tr>
                        <th style="width: 25%">Last Stream: </th>
                        <td style="font-weight: 700;width: 25%"><?= h(@$enquiryFormStudent->last_stream->name)?></td>
                        <th style="width: 25%">Percentage In Last Class: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->percentage_in_last_class) ?></td>
                    </tr>
                    <tr>
                        <th style="width: 25%">Last Class: </th>
                        <td style="font-weight: 700;width: 25%"><?= h(@$enquiryFormStudent->last_class->name)?></td>
                        <th style="width: 25%">Permanent Address: </th>
                        <td style="font-weight: 700;width: 25%"><?= $this->Text->autoParagraph(h($enquiryFormStudent->permanent_address)); ?></td>
                    </tr>
                    <tr>
                        <th style="width: 25%">Last Medium: </th>
                        <td style="font-weight: 700;width: 25%"><?= h(@$enquiryFormStudent->last_medium->name)?></td>
                        <th style="width: 25%">Board: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->board) ?></td>                        
                    </tr>
                    <tr>
                        <th style="width: 25%">Stream: </th>
                        <td style="font-weight: 700;width: 25%"><?= h(@$enquiryFormStudent->stream->name)?></td>
                        <th style="width: 25%">Mediums: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->medium->name)?></td>                       
                    </tr>
                    <tr>
                        <th style="width: 25%">Email: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->email) ?></td>
                        <th style="width: 25%">RTE: </th>
                        <td style="font-weight: 700;width: 25%"><?= h($enquiryFormStudent->rte)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->element('selectpicker') ?>
<?php
$js="
$(document).ready(function(){
    $(document).on('change', '#enquiry_status', function(e){
        $('#ServiceForm').submit();
    });
});";
$this->Html->scriptBlock($js,['block'=>'block_js']);
?>