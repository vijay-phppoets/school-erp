<style type="text/css">
    th {
    font-weight: 700 !important;
}
</style>
<?php // @$no_month=cal_days_in_month(CAL_GREGORIAN,$student_months,2019);
//pr($no_month);exit; ?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border" >
            <div class="pull-right box-tools">
                        <?= $this->Html->link('Print','javascript:window.print();',['escape'=>false,'class'=>'btn bg-maroon hide_print','style'=>'color:#fff !important;']) ?>
                    </div>
                <label >Attendance List </label>
            </div>
            <div class="box-body">
               <?= $this->Form->create('attendance') ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                                <label class="control-label"> Medium</label>
                                <?php echo $this->Form->control('medium_id',[
                                'label' => false,'class'=>'form-control','empty'=>'---Select Medium---','options'=>$mediums,'id'=>'medium_id','required']);?>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label"> Class</label>
                            <?php echo $this->Form->control('student_class_id',[
                            'label' => false,'class'=>'form-control class','empty'=>'---Select Class---','id'=>'student_class_id','options'=>$classes,'required']);?>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label"> Section</label>
                            <?php echo $this->Form->control('section_id',[
                            'label' => false,'class'=>'form-control','empty'=>'---Select Section---','options'=>$sections,'id'=>'section_id','required']);?>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Month</label>
                           <?php 
                           /*  $months=[];
                            $months[]=['text'=>'January','value'=>'01'];
                            $months[]=['text'=>'February','value'=>'02'];
                            $months[]=['text'=>'March','value'=>'03'];
                            $months[]=['text'=>'April','value'=>'04'];
                            $months[]=['text'=>'May','value'=>'05'];
                            $months[]=['text'=>'June','value'=>'06'];
                            $months[]=['text'=>'July','value'=>'07'];
                            $months[]=['text'=>'August','value'=>'08'];
                            $months[]=['text'=>'September','value'=>'09'];
                            $months[]=['text'=>'October','value'=>'10'];
                            $months[]=['text'=>'November','value'=>'11'];
                            $months[]=['text'=>'December','value'=>'12'];
                            ?>
                            <?php echo $this->Form->control('student_months',[
                            'label' => false,'class'=>'form-control','empty'=>'---Select Section---','options'=>$months,'id'=>'section_id']); */
							echo $this->Form->control('student_months',[
                                    'label' => false,'class'=>'form-control datepicker','placeholder'=>'Date','type'=>'text','data-date-format'=>'yyyy-mm','required']);?>
                           
                        </div>
                    </div>
                    <div  class="row"><br>
                        <center>
                            <?php echo $this->Form->button('View',['class'=>'btn button','id'=>'submit_member']); ?>
                        </center>
                    </div>
                </div>
                <?= $this->Form->end() ?>
                    <?php if(!empty($attendances)) {?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12" style="height: 400px; overflow-y: scroll;">
                                    <center>
                                        <h3>Attendance List Report</h3>
                                    </center>
                                    <div class="table-responsive">
                                        <h4 style="color: blue;"><?php 


                                            $a="a";
                                           $b="b";
                                         //   $dateObj = DateTime::createFromFormat('!m', $student_months); 
  
                                            // Store the month name to variable 
                                           // $monthName = $dateObj->format('F'); 
                                              
                                            // Display output 
                                            foreach ($attendances as $attend) {
                                                
                                                if($a != $b)
                                                {

                                                    echo $attend->student_info->medium->name." ".$attend->student_info->student_class->name." ".$attend->student_info->section->name." ";//.$monthName; 
                                                }
                                                $a=$attend->student_info->medium->name." ".$attend->student_info->student_class->name." ".$attend->student_info->section->name." ";//.$monthName;
                                                $b=$attend->student_info->medium->name." ".$attend->student_info->student_class->name." ".$attend->student_info->section->name." ";//.$monthName;
                                        }
                                        ?></h4>
                                        <table class="table table-bordered" id="sample_2" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Scholar No.</th>
                                                <th>Name</th>
                                                <th>Father's Name</th>
                                                <!-- <?php 
                                                    for ($a = 1; $a <= $no_month; $a++) {?>
                                                        <th><?= $a ?></th>
                                                <?php    }
                                                ?> -->
                                                <?php
                                                    while (strtotime($first_date) <= strtotime($last_date)) {
                                                    $show_date=date('d-M',strtotime($first_date));
                                                    echo '<th scope="col"style="width:10%;">'.$show_date.'</th>';
                                                    $first_date = date ("Y-m-d", strtotime("+1 day", strtotime($first_date)));
                                                    }
                                                ?>
												<th> </th>
                                                <th>Present  Total</th>
                                                <th>Absent  Total</th>
                                                <th>Leave  Total</th>
                                                
                                                <th>Sunday Total</th>
                                                <th>Holidays  Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                 <?php 
                                                        $i=1;
                                                        foreach (@$studenlist as $key=>$data) {
                                                        $first_date=date('Y-m-d',strtotime($F_date));
                                                          $last_date=date('Y-m-t',strtotime($F_date));
                                                            ?>
                                                <tr>
                                                   

                                                        <td><?= $i;$i++; ?></td>
                                                        <td><?= @$data['scoler_no']?></td>
                                                        <td><?= @$data['student_name'] ?></td>
                                                        <td><?= @$data['father_name'] ?></td>
                                                       <?php
                                                    $total_P=0;
                                                    $total_HD=0;
                                                    $total_AB=0;
                                                    $total_O=0;
                                                    $total_SUN=0;
                                                    $total_HOL=0;
                                                    $total_absent=0;
                                                    $totle_hafdayabs=0;
                                                    $totle_hafdaylev=0;
                                                    while (strtotime($first_date) <= strtotime($last_date)) {
                                                        //$show_date=strtotime($first_date);
														$show_date=date('d-m-y',strtotime($first_date));
                                                        $status = @$AttendancesFirstHalf[$key][$show_date];
                                                        $show_Lable='';
                                                        
                                                        $show_dates=strtotime($last_date);
                                                        $last_status = @$AttendancesSecondHalf[$key][$show_date];


                                                        if(($status==0.5)&&($last_status==0.0)){
                                                            $total_HD++;
                                                            $totle_hafdayabs++;
                                                            $show_Lable='H';
															 $colors='#FF6468';
															 $colorss='';
                                                        }
                                                        if(($status==0.0)&&($last_status==0.5)){
                                                            $total_HD++;
															 $totle_hafdayabs++;
                                                            $show_Lable='H';
															 $colors='#FF6468';
															 $colorss='';
                                                        }
                                                        if(($status==0.5)&&($last_status==0.5)){
                                                            $total_P++;
                                                            $show_Lable='P';
                                                            $colors='greenyellow';
															$colorss='';
                                                        }
                                                         if(($status==0.5)&&($last_status==1.0)){
                                                            $total_HD++;
                                                            $totle_hafdaylev++;
                                                            $show_Lable='H';
															 $colors='#FF6468';
															 $colorss='';
                                                        }
                                                        if(($status==1.0)&&($last_status==0.5)){
                                                            $total_HD++;
                                                            $totle_hafdaylev++;
                                                            $show_Lable='H';
															 $colors='#FF6468';
															 $colorss='';
                                                        }
                                                        if(($status==0.0)&&($last_status==1.0)){
                                                           $total_O++;
                                                            $show_Lable='L';
															 $colors='lightblue';
															 $colorss='';
                                                        }
                                                        if(($status==0.0)&&($last_status==0.0)){
                                                           $total_AB++;
                                                            $show_Lable='A';
															$colors='red';
															$colorss='white !important;';
                                                        }
                                                         if(($status==1.0)&&($last_status==0.0)){
                                                           $total_O++;
                                                            $show_Lable='L';
															 $colors='lightblue';
															 $colorss='';
                                                        }
                                                         if(($status==1.0)&&($last_status==1.0)){
                                                            $total_O++;
                                                            $show_Lable='L';
															 $colors='lightblue';
															 $colorss='';
                                                        }
                                                       foreach($holidays as $holidayss){
															$datess=date('Y-m-d',strtotime($holidayss['date']));
															//pr($datess);
															//pr($first_date);
															if($first_date==$datess)
															{
																
																//pr($show_Lable);
																if($holidayss['holidays_name']=='sunday')
																{
																	$total_AB--;
																	$total_SUN++;
																	 $colors='orange';
																	 $colorss='white !important;';
																	 $show_Lable='SUN';
																}
																if($holidayss['holidays_name']=='holiday')
																{
																	$total_AB--;
																	$total_HOL++;
																	$show_Lable='HOL';
																	 $colors='yellow';
																	 $colorss='';
																}
															}
															
														}
                                                        // die;

                                                       echo '<td scope="col"style="width:10%;background:'.$colors.';color:'.$colorss.'">'.$show_Lable.'</td>';
                                                        $first_date = date ("Y-m-d", strtotime("+1 day", strtotime($first_date)));
                                                    }
                                                    ?> 
													  <td> </td>
                                                       <?php $hafdays= $total_HD/2;?>
                                                       <?php $hafdaysabs= $totle_hafdayabs/2;?>
                                                       <?php $hafdaylev= $totle_hafdaylev/2;?>
                                                        <td><?php echo $total_P+$hafdays;?></td>
                                                        <td><?php echo $total_AB+$hafdaysabs;?> </td>
                                                        <td><?php echo $total_O+$hafdaylev;?></td>
                                                      
														 <td><?php echo $total_SUN;?> </td>
														 <td><?php echo $total_HOL;?></td>
                                                </tr>

                                                    <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
            </div>
        </div>
    </div>
</div>
 <?= $this->element('daterangepicker') ?>
<?= $this->element('data_table') ?>
<?= $this->element('icheck') ?>
<?= $this->element('datepicker') ?> 
