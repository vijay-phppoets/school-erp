<style type="text/css">
    th {
    font-weight: 700 !important;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border" >
                <label >Attendance Student Details</label>
            </div>
            <div class="box-body">
                    <div class="pull-right box-tools">
                        <?= $this->Html->link('Print','javascript:window.print();',['escape'=>false,'class'=>'btn bg-maroon hide_print','style'=>'color:#fff !important;']) ?>
                    </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <?php if($status=="Firstpresent"){
                                            echo "<h3>Morning Present Students Report of ".date('d-m-Y',strtotime($date))."</h3>";}

                                            if($status=="Firstabsent"){
                                            echo "<h3>Morning Absent Students Report of ".date('d-m-Y',strtotime($date))."</h3>";}

                                            if($status=="Secondpresent"){
                                            echo "<h3>Evening Present Students Report of ".date('d-m-Y',strtotime($date))."</h3>";}

                                            if($status=="Secondabsent"){
                                            echo "<h3>Evening Absent Students Report of ".date('d-m-Y',strtotime($date))."</h3>";}
                                        ?>
                                    </center>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Student Name</th>
                                                <th>Class</th>
                                                <th>Sections</th>
                                                <th>Class Teacher</th>
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                                 <?php 
                                                        $i=1;
                                                        foreach (@$attendances as $attendance) {?>
                                                <tr>
                                                   
                                                    <?php 
                                                        $class_id=$attendance->student_info->student_class_id;
                                                        $section_id=$attendance->student_info->section_id;
                                                    ?>

                                                        <td><?= $i;$i++; ?></td><td><?= @$attendance->student_info->student->name?></td>
                                                        
                                                        <td><?= @$attendance->student_info->student_class->name ?></td>
                                                        <td><?= @$attendance->student_info->section->name ?></td>
                                                        <td><?= @$attendance->class_mapping->employee->name ?></td>
                                                        
                                                       
                                                         
                                                </tr>

                                                    <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
 <?= $this->element('daterangepicker') ?>
<?= $this->element('datepicker') ?> 
<?= $this->element('data_table') ?>
<?= $this->element('icheck') ?>
