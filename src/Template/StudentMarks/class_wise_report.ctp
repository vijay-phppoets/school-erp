
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                   <i class="icon-bar-chart font-green-sharp hide"></i>
                 <span class="caption-subject font-green-sharp bold " style="font-size: 16px;">Class Wise Report</span>
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
                                <label class="control-label"> Exam</label>
                            
                                <?php echo $this->Form->control('exam_master_id', ['empty'=>'--- Select ---','options' => [],'class'=>'select2','style'=>'width:100%','label'=>false]);?>
                            </div>

                            <div class="col-md-3">
                               <!--  <a id="add_student" href="" class="btn btn-default btn-primary btnClass"> Find Student</a> -->
                                <button type="submit" class="btn btn-primary" style="margin-top: 26px;">View</button>
                            </div>
                        </div>
                <?= $this->Form->end() ?>
                <div class="table-responsive" id="table1">
                    <div style="width: 100%">
                        <table style="text-align: center;font-size: 14px;margin-top: 40px;" width="100%" border="1">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center"><strong>S.No</strong></th>
                                    <th rowspan="2" style="text-align: center"><b>Scholor Number</b></th>
                                    <th rowspan="2" style="text-align: center"><b>NAME</b></th>
                                    <th style="text-align: center"><b>English > Reading Skill  </b></th>
                                    <th style="text-align: center"><b>English > Writing Skill</b></th>
                                    <th style="text-align: center"><b>English > Listening And Speaking Skill</b></th>
                                    <th style="text-align: center"><b>English > Activity</b></th>
                                    <th style="text-align: center"><b>Hindi > Reading Skill </b></th>
                                    <th style="text-align: center"><b>Hindi > Writing Skill </b></th>
                                    <th style="text-align: center"><b>Hindi > Listening And Speaking Skill</b></th>
                                    <th style="text-align: center"><b>Hindi > Activity</b></th>
                                    <th style="text-align: center"><b>Maths > Activity</b></th>
                                    <th style="text-align: center"><b>Maths > Formal Maths</b></th>
                                </tr>
                                <tr>
                                    <th  style="text-align: center"><b>Evaluation I</b></th>
                                    <th  style="text-align: center"><b>Evaluation I</b></th>
                                    <th  style="text-align: center"><b>Evaluation I</b></th>
                                    <th  style="text-align: center"><b>Evaluation I</b></th>
                                    <th  style="text-align: center"><b>Evaluation I</b></th>
                                    <th  style="text-align: center"><b>Evaluation I</b></th>
                                    <th  style="text-align: center"><b>Evaluation I</b></th>
                                    <th  style="text-align: center"><b>Evaluation I</b></th>
                                    <th  style="text-align: center"><b>Evaluation I</b></th>
                                    <th  style="text-align: center"><b>Evaluation I</b></th>
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

