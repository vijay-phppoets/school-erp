<style>
.class_hides{
    display: none;
} 
@media print {
  .printdata{
		 display:none;
	 }
}  
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header printdata">
               <h3 class="box-title">
                   <i class="icon-bar-chart font-green-sharp hide"></i>
                 <span class="caption-subject font-green-sharp bold " style="font-size: 16px;">Cross Class Report</span>
                </h3>
            </div>
            <div class="box-body padding " style="width: 100% !important;">
                <?= $this->Form->create('studentMark') ?>
                    <div class="row">
                        <div class="col-md-3 printdata">
                            <label class="control-label"> Class <span class="required" aria-required="true"> * </span></label>
                        
                            <?php echo $this->Form->control('class_mapping_id', ['empty'=>'--- Select---','options' => $classMappings,'class'=>'select2 mapping','style'=>'width:100%','label'=>false]);?>
                             <?php echo $this->Form->control('class_hide', ['label'=>false,'id'=>'class_hides','class'=>'class_hides']);?>
                        </div>

                        <div class="col-md-3 printdata">
                            <button type="submit" class="btn btn-primary" style="margin-top: 26px;">View</button>
                        </div>
                    </div>
                <?= $this->Form->end();
                 if(!empty($alldeta)){
                ?>
				<div align="right"  class="printdata"><button type="button" onClick="print()" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>	
			</div>
                <div class="table-responsive" id="table1">
                    <h3 style="text-align:center;margin-top: 50px;">ALOK SENIOR SECONDARY SCHOOL</h3>
                    <h5 style="text-align:center">HIRAN MAGRI, SECTOR - 11, Udaipur</h5>
                    <h5 style="text-align:center">CBSE, NEW DELHI, AFFILIATION NO.-1730007</h5>
                    <h5 style="text-align:center; font-size:18px;"><b>Attendence Report of <?= @$classname->name ?></b></h5>
                    <div style="width: 100%;">
                        <table style="text-align: center;font-size: 14px;margin-top: 60px;" width="100%" border="1">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center">S.NO</th>
                                    <th rowspan="2" style="text-align: center">Scholar NO</th>
                                    <th rowspan="2" style="text-align: center">Roll No</th>
                                    <th rowspan="2" style="text-align: center">Student Name</th>
                                    <th rowspan="2" style="text-align: center">Father's Name</th>
                                    <th colspan="2" style="text-align: center">Attendance</th>
                                    <th rowspan="2" style="text-align: center">Marks</th>
                                    <th rowspan="2" style="text-align: center">Percentage</th>
                                    <th rowspan="2" style="text-align: center">Grade</th>
                                    <th rowspan="2" style="text-align: center">Remarks</th>
                                </tr>
                                <tr>
                                   <th style="text-align: center">Total Meeting   </th>
                                    <th style="text-align: center">Attendance Meeting   </th>
                                </tr>
                               
                            </thead>
                             <tbody id="main">
                                <?php
                                    $i=1;
									$total_meeting=0;
									$attend_meeting=0;
                                    foreach (@$alldeta as $dt) {
										//pr($dt);die;
										?>
                                    <tr>
                                        <td><?= $i;$i++; ?></td>
                                        <td><?= $dt->student_info->student->scholar_no ?></td>
                                        <td><?= $dt->student_info->roll_no ?></td>
                                        <td><?= $dt->student_info->student->name ?></td>
                                        <td><?= $dt->student_info->student->father_name ?></td>
                                        <td><?= $dt->meeting?></td>
                                        <td><?= $dt->attend ?></td>
                                        <td><?= $dt->marks ?></td>
                                        <td><?= $dt->percentage ?></td>
                                        <td><?= $dt->grade?></td>
                                        <td><?= $dt->status ?></td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>
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

});

";
$this->Html->scriptBlock($js,['block'=>'scriptPageBottom']);
?>