<style>
.class_hides{
    display: none;
}   
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                   Print Attendance List
                </h3>
            </div>
            <div class="box-body padding" style="width: 100% !important;">
                <div class="table-responsive" id="table1">
                    <div style="float: left;width: 100%; margin-top: 20px;">
                                        <div style="text-align: center;font-size: 14px;margin-top: 12px;" width="100%" align="left">
                                                    <h3 style="font-size: 20px;"><strong>ALOK SENIOR SECONDARY SCHOOL</strong></h3>
                                                <h4><strong>SESSION : 2021-2022</strong></h4>
                                                <h4> <strong>Room No : <?= @$room_no ?></strong></h4>
												<h4> <strong>Exam : <?= @$exam_hide ?></strong></h4>
                                        </div>
                    </div>
                    <div style="width: 100%">
                        <table style="text-align: center;font-size: 14px;" width="100%" border="1">
                            <thead>
                                <tr>
                                    <th  style="text-align: center">S.NO</th>
                                    <th  style="text-align: center">ROLL NO</th>
                                    <th  style="text-align: center">NAME</th>
                                    <th  style="text-align: center">Class</th>
                                    <th  style="text-align: center">Section</th>
                                    <?php
                                        if(!empty($examDate)){
                                        foreach($examDate as $examDate1){
                                        if(!empty($examDate1)){
                                        ?>
                                        <th style="width:9%;text-align: center;"><?php echo date("d-m-Y",strtotime($examDate1));?></th>
                                        <?php } }} ?>
                                    
                                </tr>
                                
                               
                            </thead>
                            <tbody>
                                <?php $i=0;//foreach($examSubjectDetails as $examSubjectDetail){
                                    if($i==0){
                                //foreach($examSubjectDetail->section->student_infos as $student_info)
                                if(!empty($examSubjectDetails))
                                {
                                foreach($examSubjectDetails as $student_info)
                                {
                                ?>  
                                <tr>
                                    <td><?= h(++$i) ?></td>
                                    <td><?= h(@$student_info->roll_no) ?></td>
                                    <td><?= h(@$student_info->student->name) ?></td>
                                    <td><?= h(@$student_info->student_class->name) ?></td>
                                    <td><?= h(@$student_info->section->name) ?></td>
                                    <?php foreach($examDate as $examDate1){
                                        if(!empty($examDate1)){
                                        ?>
                                        <td style="width:9%;"></td>
                                        <?php } } ?>
                                </tr>
                                <?php }}} //}?> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

