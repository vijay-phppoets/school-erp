
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                   <i class="icon-bar-chart font-green-sharp hide"></i>
                 <span class="caption-subject font-green-sharp bold " style="font-size: 16px;">Class Wise Topper Report</span>
                </h3>
            </div>
            <div class="box-body padding content-scroll" style="width: 100% !important;">
                <?= $this->Form->create('studentMark') ?>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label"> Class <span class="required" aria-required="true"> * </span></label>
                        
                            <?php echo $this->Form->control('class_mapping_id', ['empty'=>'--- Select---','options' => [],'class'=>'select2','style'=>'width:100%','label'=>false]);?>
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary" style="margin-top: 26px;">View</button>
                        </div>
                    </div>
                <?= $this->Form->end() ?>
                <div class="table-responsive" id="table1">
                    <h3 style="text-align:center;margin-top: 50px;">ALOK SENIOR SECONDARY SCHOOL</h3>
                    <h5 style="text-align:center">HIRAN MAGRI, SECTOR - 11, Udaipur</h5>
                    <h5 style="text-align:center">CBSE, NEW DELHI, AFFILIATION NO.-1730007</h5>
                    <h5 style="text-align:center; font-size:18px;"><b>Attendence Report of Term-III &gt; Evaluation III</b></h5>
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
                                </tr>
                                <tr>
                                    <th style="text-align: center">Total Meeting   </th>
                                    <th style="text-align: center">Attendance Meeting   </th>
                                </tr>
                               
                            </thead>
                            <tbody id="main">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->element('selectpicker');?>
<?= $this->element('loading');?>
<?= $this->element('medium class stream filter all');?>
