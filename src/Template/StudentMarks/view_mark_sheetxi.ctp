
<!-- find subject length -->
<?php
//pr($infogread->toArray());die;
    $subjectArray = $scholastic_subjects;
    $subjectLength = $Find->maxDepth($scholastic_subjects); 
?>
 
<style>
.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
    padding: 1px !important;

}
.row{
    margin: 3px 0 0 0 !important;
}
.row-eq-height{
    display: flex;
}

.table-new>tbody>tr>td {
    text-align: center !important;
}

.table-new>thead>tr>th {
    text-align: center !important;
}
.a1
{height: auto; border: 1px solid; font-family: Arial, Helvetica, sans-serif;
}
.center_align { text-align:center; }
table
{
border-collapse:collapse;
height: 100%;
width: 100%;
}
div
{
border-collapse:collapse;
}
td {
    text-align:center !important;  
}
p {
    text-align:center !important;  
    margin:0 !important;  
}
 
.header_font
{
    font-weight:bold;
    font-size:14px;
}
.header_sub
{
    font-weight:bold;
}
.firstTH
{
    padding-left: 5px;
}
.extra
{
    padding-top: 3px;
    padding-bottom: 3px;
}
.main_color{ background-color:#0e4d8d !important;}
.second_color{ background-color:#e6e7e9 !important;}
td {
   
    font-weight: bold;
}
body {
    font-size: 13px !important;
    font-family: 'Nunito Sans', sans-serif !important;
    color: black;
}
@media(max-width: 768px){
    tr.mb-tb {
    display: flex;
    flex-direction: column;
    align-items: center;
        margin-top: -2em;
}
td.mb-no-width {
    width: auto;
}
.school-address {
    font-size: 9px;
}
.performance {
    font-size: 9px !important;
}
img.logo-alok {
    padding: 13px;
}
.top-css {
    margin-top: -7px !important;
}
.top-css1 {
    margin-top: -11px !important;
}
.session {
    margin-top: 3px !important;
}
td.school-top {
    margin-top: -7px;
}
}
</style>

<?php
//pr($student);die;
$totleopten=[]; 
															$totleoptentotle=[]; 
															$examid=[]; 
															 $componentData=[];	
															$url=$awsFileLoad->cdnpath();	
	?>
<div class="portlet light ">
    <div  style="background: white;"><div class="row">
	
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                </div> 
                <div class="box-body">
                    <div class="a1">
                        <div class="row">
                            <div class="col-sm-12">
                                <table width="100%" border="0" style="text-transform: uppercase;"><br>
                                    <tr class="mb-tb">
                                        <td class="mb-no-width" width="15%">
                                            <?php echo $this->Html->image('aloklogo1.JPG', array('width' => '140','height'=>140, 'class'=> 'logo-alok')); ?>
                                        </td>
                                        <td class="school-top" width="66%">
                                            <div  style="font-size:26px; word-spacing:1px; text-align:center;">
                                                <p style="font-family:Georgia; " class="school-address"><?php echo @$schooledatas->name;?></p>
                                            </div>
                                            <div  style="font-size:21px; margin-top:-6px;text-align:center;"> 
                                                <strong class="school-address"><?php echo @$schooledatas->address;?></strong>
                                            </div>
                                            <div  class="top-css" style="font-size:18px; margin-top:4px; text-align:center;">
                                                <strong class="school-address"><?php echo @$schooledatas->affiliation_no;?></strong>
                                            </div>
						<div class="top-css1" style="font-size:21px; margin-top:0px; text-align:center;">
                                                <strong class="school-address"><b class="performance" style = "font-family:Georgia; font-size:20px;">Record of Academic Performance</b> <br>
                                               <p class="session">Session : <?php echo $sy_name;?></p></strong>
                                            </div>
                                        </td>
                                        <td class="mb-no-width" width="15%">
                                             <?php echo $this->Html->image($url.'/'.$student->student_image, array('width' => '140','height'=>140,'class'=> 'logo-alok')); ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-12">
                                <table height="100" style="width:100%;margin-top:20px; font-size:14px;font weight:bold;text-transform: uppercase;" cellpadding="1" border="0" cellspacing="10">
                                    <tr align="left">
                                        <th class="firstTH">Name of Student</th>
                                        <th> : &nbsp; <strong ><?= @$student->student->name?></strong> </th>
                                        <th style="width:15%">Scholar No.</th>
                                        <th style="width:55%" align="left">: &nbsp;<?= @$student->student->scholar_no?></th>
                                    </tr>
                                    <tr align="left">
                                        <th class="firstTH">Father's Name</th>
                                        <th>: &nbsp; <strong > <?= @$student->student->father_name?></strong></th>
                                        <th>Roll No.</th>
                                        <th> : &nbsp; <?= @$student->roll_no?></th>
                                    </tr>
                                    <tr align="left">
                                        <th class="firstTH">Mother's Name</th>
                                        <th> : &nbsp; <strong ><?= @$student->student->mother_name?></strong></th>
                                        <th>Class </th>
                                        <th> : &nbsp; <?= @$student->student_class->roman_name?>
                                           <?php $componentData['stream_id'] =$student['stream_id'];
							$componentData['section_id'] =$student['section_id'];
							$componentData['student_class_id'] =$student['student_class_id'];
							$componentData['student_id'] = $student['id']; 
							$componentData['session_year_id'] = $sy_id;
							?>
                                        </th>
                                    </tr>
                                    <tr align="left">
                                        <th style="width:15%" class="firstTH">DOB</th>
                                        <th style="width:55%" align="left">: &nbsp; <?= @$student->student->dob?></th>
                                        <th style="width:15%">Section</th><?php $section=explode(" ",$student->section->name);?>
                                        <th align="left"> : &nbsp; <?= $student->has('section') ? ' '.$section[0]:''?></th>
                                    </tr>
                                  <!--  <tr align="left" >
                                        <th class="firstTH">Address</th>
                                        <th> : &nbsp; <?= @$student->parmanent_address?></th>
                                    </tr>
									-->
                                </table>
                            </div>

                            <div class="col-xs-12 table-responsive">
                                <!-- Scholastic Area -->
                               
                                <table class="table-new" cellpadding="0px" border="1" id="sample_1" style="text-transform: uppercase;margin-top: 8px;width: 100.2%;
    /* border: unset; */
    border-left: unset;">
                                    <tbody>
                                        <tr class="header_font main_color" bgcolor="#b6fdb6">
                                            <td  height="20px" colspan="100" style="padding: 4px;color: white;">Part 1 : Scholastic Area</td>
                                        </tr>
                                        <?php $maxDepth = $Find->maxDepth($exams); $itteration = $maxDepth;?>
                                        <?php $examLength=0; ?>
                                        <?php $examArray = $exams;
                                             $exams2 = $examArray;
                                              
                                                $examArray = $Find->nextChild($exams2);
										?>
										<?php for ($i=0; $i < $itteration; $i++) { ?>
										<tr class="header_font second_color">
										<?php if ($i == 0): ?>
										<th <?= $maxDepth!=0?'rowspan='.$maxDepth:'' ?> colspan="<?=$subjectLength?>"><p> Subjects</p></th>
										<?php endif ?>

										<?php foreach ($examArray as $key => $section):
										if($i!=0){
										?>

										<th><p>
										<?= $section['name'] ?><?php  }?></p>

										<?php endforeach; ?>
										<?php if ($marks_type != 'Grade'):
										if($i!=0){
										?>
										<th ><p> Total</p></th>
										<?php  }if ($marks_type != 'Number'):  if($i!=0){ ?>
										<th><p> Grade</p></th>
										<?php } endif ?>
										<?php endif ?>
										<?php 
										// $maxDepth--;
										//$exams2 = $examArray;
										// unset($examArray);
										// $examArray = $Find->nextChild($exams2);
										?>
										<?php } ?>

                                       <!-- <?php if ($marks_type != 'Grade'): ?>
                                            <tr class="header_font second_color">
                                                <th colspan="<?=$subjectLength?>"><p>Max Marks</p></th>
                                                <?php $grand_total=0; foreach ($exams2 as $key => $value) {
                                                    @$grand_total+=$value['max_marks'];
                                                    echo "<th><p>".$value['max_marks']."</p></th>";
                                                } ?>
                                                <th><p><?= $grand_total ?></p></th>
                                                <?php if ($marks_type != 'Number'): ?>
                                                    <th><!-- Grade </th>    
                                                <?php endif ?>
                                            </tr>
                                        <?php endif ?>
                                        -->
                                        <!-- Printing non elective subjects -->
                                        <?php /* $infogread=($infogread->toArray());  */
											//pr($infogread);die;
                                             
                                                $maxWidth = $Find->maxWidth($scholastic_subjects);
                                                $maxDepth = $Find->maxDepth($scholastic_subjects);
                                                foreach ($scholastic_subjects as $sub_key => $scholastic_subject):
                                                 $student_subjectparnt['name']=$scholastic_subject;
												?>
												
                                                    <?php $currentDepth =  $Find->arrayDepth($scholastic_subject);?>
                                                    <?php $colSpan = $maxDepth - $currentDepth; ?>
                                                    <tr>
                                                        <?php $a[0] = $scholastic_subject; ?>
                                                        <?php $rowspan = $Find->maxWidth($a); ?>
                                                        <th width="20%" class="subjects" rowspan="<?= $rowspan==0?'':$rowspan ?>" colspan="<?= $colSpan==0?'':$colSpan ?>"><p style="text-align: left!important;padding-left: 5px;padding: 4px;"><?= $scholastic_subject['name'] ?></p></th>
														
                                                        <?php if(!empty($scholastic_subject['children'])): 
														//pr($scholastic_subject['children']);
														?>
                                                            <?= "<tr>" ?> 
                                                            <?php 
															
															$maxWidth = $Find->maxWidth($scholastic_subject['children']);
                                                $maxDepth = $Find->maxDepth($scholastic_subject['children']);
                                                foreach ($scholastic_subject['children'] as $sub_key => $scholastic_subject): 
												//pr($scholastic_subject['name']);
												?>
												
												<?php $currentDepth =  $Find->arrayDepth($scholastic_subject);?>
                                                    <?php $colSpan = $maxDepth - $currentDepth;
                                                       
													?>
                                                    <?php $a[0] = $scholastic_subject; ?>
                                                        <?php $rowspan = $Find->maxWidth($a); ?>
                                                        <th class="subjects" colspan="<?= $colSpan==0?'':$colSpan ?>" rowspan="<?= $rowspan==0?'':$rowspan ?>"><p style="text-align: left!important;margin-left: 4px !important;  padding: 2px;"><?= $scholastic_subject['name'] ?></p></th>
                                                        <?php if(empty($scholastic_subject['children'])):?>
                                                            <?php $subject_id = $scholastic_subject['id'] ?>
                                                            <?php $subject_total = 0; ?>
                                                            <?php $total=0; $fa1mark=0;$fa1markmax=0;
															
															?>
                                                            <!-- print marks -->
                                                            <?php foreach ($scholastic_subject['exams'] as $exam_key => $exam): 
															// pr($exam);die;
															?>
                                                                <td style="font-size:14px;padding:10px">
                                                                    <?php foreach ($marks as $key => $result):

																	?>
                                                                        <?php $fail = explode(',',$result->fail); ?>
                                                                        <?php $supplementary = explode(',',$result->supplementary); ?>
                                                                       

                                                                            <?php

																			if ($result->exam_master_id == $exam['id'] && $result->subject_id == $subject_id): 
																			//pr($result);die;	
																			?>
																		
                                                                                    <?php 
                                                                                             
                                                                                           echo '<p style="padding: 5px;">'. $result->student_number;
                                                                                           echo '/'.$result->marksmax .'</p>';
                                                                                           $subject_total += $result->student_number;
                                                                                           $total += $result->marksmax;
if(strtoupper($exam['name'])=='FA I' || strtoupper($exam['name'])=='FA II' ||strtoupper($exam['name'])=='TERM-I')
									{
										
										
										 @$fa1mark+=$result->student_number;
										 @$fa1markmax+=$result->marksmax;
										
									}
if(strtoupper($exam['name'])=='TERM II')
									{
										
										
										 @$fa2mark=$result->student_number;
										 @$fa2markmax=$result->marksmax;
										
									}


                                                                                           @$totleoptens[$exam['id']]+=$result->student_number;
												                                           @$totleoptentotles[$exam['id']]+=$result->marksmax;
											                                               @$examids[$exam['id']]=1;   
										
                                                   
                                                                                     ?>  
                                                                            <?php endif ?>
                                                                       
                                                                    <?php endforeach ?>
                                                                </td>
                                                            <?php endforeach ?>
                                                            <?php if ($marks_type != 'Grade'): ?>
															<?php 
															$term1p=$subject_total*100/$total;
															$term2p=$fa2mark*100/$fa2markmax;
															if(round($term1p)>=33){
																		
																		}else{
																			@$countofsulimetri+=1;
																			@$sublimenterysubject[]=$student_subjectparnt['name']['name'];
																			
																		}
															?>
                                                            <td style="font-size:14px;"><?= $subject_total ?> / <?= $total ?></td>
                                                                <?php if ($marks_type != 'Number'): ?>
                                                                    <th style="text-align: center;font-size:14px;"><?php $subject_per = $subject_total*100/$total;
																	$subject_per1=round($subject_per);
																	?>
																	<?php foreach($infogread as $infog)
																	{
																		if(in_array($subject_per1, range($infog->min_marks, $infog->max_marks)) )
																		{
																			echo $infog->grade;
																		}
																	}
																	//die;
																	?></th>    
                                                                <?php endif ?>
                                                            <?php endif ?>

                                                        <?php endif; ?>
                                                        <tr>
                                                    <?php 
                                                        /* if(!empty($scholastic_subject['children']))
                                                        { 
                                                            def($scholastic_subject['children'],$Find,$marks,$marks_type,$infogread); 
                                                        }
                                                        else{
                                                        }  */
                                                    ?>
                                                <?php endforeach; $hello=0;
                                            ?>
											
											
                                                        <?php else: ?>
                                                            <?php $subject_id = $scholastic_subject['id'] ?>
                                                            <?php $subject_total = 0; ?>
                                                            <?php $total=0; ?>
                                                            <?php 
															
															
															?>
                                                            <!-- print marks -->
															<?php $i=1;?>
                                                            <?php   foreach ($scholastic_subject['exams'] as $exam_key => $exam): ?>
                                                                <td>
                                                                    <?php  foreach ($marks[$student->id] as $key => $result): 
																	
																	?>
                                                                        <?php $fail = explode(',',$result->fail); ?>
                                                                        <?php $supplementary = explode(',',$result->supplementary); ?>
                                                                        <?php foreach ($result['result_rows'] as $key => $result_row): ?>
                                                                             <?php //pr($result_row); die;?>
                                                                            <?php if ($result_row->exam_master_id == $exam['id'] && $result_row->subject_id == $subject_id ): ?>
                                                                                    <?php 
                                                                                        if($marks_type == 'Grade')
                                                                                            echo $result_row->grade;
                                                                                        else
                                                                                        {
																							if(empty($result_row->number_of_best))
																							{
																								
                                                                                            echo $result_row->obtain;
                                                                                            echo '/'.$result_row->total;
                                                                                           
                                                                                            @$subject_total += $result_row->obtain;
                                                                                            @$total += $result_row->total;

												@$totleopten[$exam['id']]+=$result_row->obtain;
												@$totleoptentotle[$exam['id']]+=$result_row->total;
												@$examid[$exam['id']]=1;											
																							}
																							else{
																								@$best_of_per=$result_row->obtain*100/$result_row->total;
																							@$best_of_number	=$best_of_per*$result_row->number_of_best/100;
																							echo round($best_of_number);
                                                                                           
                                                                                            echo '/'.$result_row->number_of_best;
                                                                                            @$subject_total += round($best_of_number);
                                                                                           @$total += $result_row->number_of_best;
																						   
                                                @$totleopten[$exam['id']]+=round($best_of_number);
												@$totleoptentotle[$exam['id']]+=$result_row->number_of_best;
                                                @$examid[$exam['id']]=1;
																								
																							}
                                                                                        }
                                                                                     ?>  
                                                                            <?php  endif  ?>
                                                                        <?php endforeach ?>
                                                                    <?php endforeach ?>
                                                                </td>
                                                            <?php endforeach ?>
															
                                                            <?php if ($marks_type != 'Grade'): ?>
                                                            <td><?= $subject_total ?> / <?= $total ?></td>
                                                                <?php if ($marks_type != 'Number'): ?>
                                                                    <th style="text-align: center;">
																	<?php $subject_per = $subject_total*100/$total;
																		$subject_per1=round($subject_per);
																	?>
																	<?php foreach($infogread as $infog)
																	{
																		if(in_array($subject_per1, range($infog->min_marks, $infog->max_marks)) )
																		{
																			echo $infog->grade;
																		}
																	}
																	//die;
																	?> </th>    
                                                                <?php endif ?>
                                                            <?php endif ?>
                                                        <?php endif; ?>
														
                                                    </tr>
													
                                                <?php endforeach; 
												
										
                                            
                                            
                                                 ?>
                                                    

                                            <?php /* $ccf=abc($scholastic_subjects,$Find,$marks,$marks_type,$infogread); */ ?>
                                       
                                       <!--  <tr class="header_font">
										<?php //pr($total); ?>
                                            <th colspan="<?=$subjectLength?>"><p>Total</p></th>
                                            <?php $grand_total=0; foreach ($total as $total_key => $value){ 
                                                echo "<th><p>$value</p></th>";
                                                $grand_total+= $value;
                                            } ?>
                                            <th><p><?= $grand_total ?></p></th>
                                        </tr>  
-->		

	<?php   if($marks_type !== 'Grade'){ ?>		 <tr class="header_font">
										
                                            <th colspan="<?php echo $colSpan+1;?>" ><p style="text-align: left!important;padding-left: 5px;padding: 4px;">Total</p></th>
                                            <?php $grand_total=0; if($examids) { foreach ($examids as $sub_key => $scholastic_subject){
											
												?>
												
                                                <th><p><?php @$prrj+=$totleoptens[$sub_key];@$rjpr+=$totleoptentotles[$sub_key]; echo $totleoptens[$sub_key];?>/<?php echo $totleoptentotles[$sub_key];?></p></th>
                                               <?php
                                            } }
											$OverAllTotalnum=$prrj;$OverAllTotalmax=$rjpr;
											 $componentData['marks']=$OverAllTotalnum;
											 $componentData['marksmax']=$OverAllTotalmax;
											 
											?>
                                           <th><p><?php echo @$prrj;?>/<?php echo @$rjpr; ?></p></th> 
                                           <th><p ><?php  @$totlepersent=$prrj*100/ $rjpr;
										   $componentData['percentage']=round($totlepersent,2);
                                                  @$totlepe= round($totlepersent);
                                                   foreach($infogread as $infog)
																	{
																		if(in_array($totlepe, range($infog->min_marks, $infog->max_marks)) )
																		{
																			echo $infog->grade;
																			$componentData['grade']=$infog->grade;
																		}
																	}

										   ?>
										   
										   </p></th> 
                                        </tr>  
<?php } $prrj=0;$rjpr=0;?>										
                                    </tbody>
                                </table>
                           
                            </div>
                        </div>
      <?php if($marks_type != 'Grade'){?>
                        <div class="row row-eq-height">
                            <?php if (!empty($non_scholastic_subjects)): ?>
                                <?php 
                                    $type = '';
                                    $part = 1;
                                    $length = count($non_scholastic_subjects);
                                 ?>
                                <?php foreach ($non_scholastic_subjects as $key => $subject): ?>
                                    <?php 
									//pr($non_scholastic_subjects);
                                        if ($subject['type'] != $type){
                                            $type = $subject['type'];
                                            $part++;
                                    ?>
                                        <?php if ($key > 0): ?>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                        <div class="col-xs-12">
                                            <table cellspacing="0px" cellpadding="0px" border="1" id="sample_1" style="text-transform: uppercase;margin-top: -6px;width: 100.2%;
    border-left: unset;" >
                                                <tbody>
                                                    <tr class="header_font main_color">
                                                        <th height="25" colspan="10" style="margin-left:5px;text-align:center;padding: 4px;color: white;">Part <?= $part ?> : <?= $type ?></th>
                                                    </tr>
													<th class="header_font second_color" style="width: 50%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;">Activities</th>
													<?php $prdk=count($subject['student_marks']);
													if($prdk==1)
													{
													?>
													<th class="header_font second_color" style="width: 50%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >Term  I</th>
													<?php }else{?>
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >Term  I</th>
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >Term  II</th>
													
													<?php } ?>
                                    <?php } ?>
                                        <tr>
                                            <td style="width: 50%;"><p style="text-align: left!important;padding-left: 5px;padding: 6px;"><?= $subject['name'] ?></p></td>
                                            <?php foreach ($subject['student_marks'] as $key => $markss):
                                                       
											?>
                                                <td><?php $copres=$markss['student_number']*100/$subject['exam_max_marks'][0]['max_marks'];
												 if($copres>=33 && $copres<=59.99)
											{echo "C";}
											else if($copres>=60 && $copres<=79.99)
											{echo "B";}
											else if($copres>=80 && $copres<=100)
											{echo "A";}
												?></td>
										  <?php  endforeach ?>
                                        </tr>

                                <?php endforeach ?>
                                </table></div>
                            <?php endif ?>

                        </div>
	  <?php } ?>
						

                      <div class="row">
                            <div class="col-xs-12 table-responsive">
							<table border="1"  cellspacing="0" cellpadding="0" style="width: 100.2%;border-left: unset;text-transform: uppercase;margin-bottom: 4px;margin-top: -6px;" >
                                    <tr class="header_font main_color" >
                                        <th height="25" colspan="102" style="margin-left:5px;text-align:center;padding: 4px;color: white;">Signature</th>
                                    </tr>
                                    <tr class="header_font second_color">
                                        <th height="35" style="text-align:center;">Class Teacher</th>
                                        <th style="text-align:center;">Examination</th>
                                        <th style="text-align:center;">Principal</th>
                                        <th style="text-align:center;">Parent</th>
                                        <th width="20%" rowspan="4" style="background-color:#FFF !important;text-align:center;">
                                        <?php
										/* $qrcode='ALOK SENIOR SECONDARY SCHOOL  HIRAN MAGRI, SECTOR - 11, Udaipur  CBSE, NEW DELHI, AFFILIATION NO.-1730007';

										$PNG_TEMP_DIR = WWW_ROOT.'temp'.DIRECTORY_SEPARATOR;    
										//pr($PNG_TEMP_DIR);die;
										//$PNG_WEB_DIR  = WWW_ROOT.'temp/';
										$PNG_WEB_DIR  = $this->Url->build(["controller" => "webroot/temp",'_full'=>true]).'/';
										$filename = $PNG_TEMP_DIR.'test.png';
										if(file_exists($filename))
										{
											$filename->delete();
										}
										$errorCorrectionLevel = 'L';
										$matrixPointSize = 2.3;
										if (isset($qrcode)) 
										{ 
										$filename = $PNG_TEMP_DIR.$qrcode.'.png';
										//pr($filename);die;
										QRcode::png($qrcode, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
										echo '<img height="90px" width="90px" src="'.$PNG_WEB_DIR.basename($filename).'" />'; 
										} */
									?>
									 <?php  echo $this->Html->image('ALOK SENIOR SECONDARY SCHOOL  HIRAN MAGRI, SECTOR - 11, Udaipur  CBSE, NEW DELHI, AFFILIATION NO.-1730007.png', array('width' => '115px')); ?>
                                        </th>
                                    </tr>
                                    <tr class="header_sub">
                                        <th height="46px" style="text-align:center;">
                                           <?php echo $infodata->toArray()[0]['Employees']['name'];?>
                                        </th>
                                        <th style="text-align:center;">Mr. Anil Mehta</th>
                                        <th style="text-align:center;">Mr. Shashank Taunk</th>
                                        <th style="text-align:center;">Mr. <?= @$student->student->father_name?> </th>
                                    </tr>
                                    <tr>
                                        <td height="45px"></td>
                                        <td> <?php  echo $this->Html->image('Anilji_sign (1).png', array('width' => '100px')); ?></td>
                                        <td> <?php  echo $this->Html->image('Shashank_taunk_signature.jpg', array('width' => '75px'));  ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td height="28px"><b>Date of Declaration</b></td>
                                        <td><?php echo "16-March-2022"; ?></td>
                                        <td>Date of Issue</td>
                                        <td><?php echo "16-March-2022"; ?></td>
                                    </tr>
                                </table>

								<?php if($marks_type != 'Grade'){?>
                                <table border="1"  cellspacing="0" cellpadding="0" style=" border-left: unset; width: 100.2%;text-transform: uppercase;margin-top: -6px;">
                                    <tr class="header_font main_color" >
                                        <th height="25" colspan="102" style="margin-left:5px;text-align:center;padding: 4px;color: white;">Attendance</th>
                                    </tr>
                                    <tr class="header_font second_color">
                                        <th height="35" width="22%"style="text-align:center;">Total Meetings</th>
                                        <th width="20%"style="text-align:center;">Meetings Attended</th>
                                        <th width="22%"style="text-align:center;">Percentage</th>
                                        <th style="text-align:center;">
                                        
                                
                                        
                                        
                                        Remarks</th>


                                        
                                    </tr>
                                    <tr class="header_sub">
                                        <th height="45px" style="text-align:center;">
                                          <?php echo @$att[0]->total_meeting;
										   $componentData['meeting']=@$att[0]->total_meeting;
										  ?>
                                        </th>
                                        <th style="text-align:center;"><?php echo @$att[0]->attend_meeting;
										$componentData['attend']=@$att[0]->attend_meeting;
										?></th>
										<?php  @$Percentageatt=@$att[0]->attend_meeting*100/@$att[0]->total_meeting;?>
                                        <th style="text-align:center;"><?php if($Percentageatt){echo round(@$Percentageatt,2);}?></th>
										
                                        <th style="text-align:center;"><?php 
										if($Percentageatt>=90 && $Percentageatt<=100)
										{
											echo "Excellent";
										}
										if($Percentageatt>=80 && $Percentageatt<=89.99)
										{
										   echo "Very Good";
										}
										if($Percentageatt>=75 && $Percentageatt<=79.99)
										{
										   echo "Good";
										}
										if($Percentageatt<=74.99 && $Percentageatt >=1)
										{
										   echo "Insufficient";
										}
										if(empty($Percentageatt))
										{
										   echo "";
										}
									?></th>
                                    </tr>
                                    
                                   
                                </table>
                            </div>
								</div><?php } ?>
								   <?php 
								  if($marks_type != 'Grade'){
				if($last==1){
				?>
				<table width="100%"  border="1" style="margin-top:-4px;margin-bottom: -5px;" cellspacing="0" cellpadding="0" >
					<tr>
					<td width="70%">
						<table width="100%" border="1" cellspacing="0" cellpadding="0" >
							<tr  class="header_font main_color">
								<th height="23px" colspan="3" style="text-align:center;color:white;">Final Report</th>
							</tr>
							<tr >
								<th height="30px" width="50%" style="text-align:center;">Scope for Improvement</th>
								<td height="30px" width="50%" style="text-align:center;">
								<?php 
						if(@$countofsulimetri>0 && @$countofsulimetri<=1)
									{
										
										echo implode(" , ",$sublimenterysubject);
										$componentData['remark'] = implode(" , ",$sublimenterysubject);
									}
									else{
										echo '-';
									}
							
																	  
								?>
								</td>
							</tr>
							<tr>
								<th height="35px" style="text-align:center;">Result</th>
								<td style="text-align:center;">
								<?php  
								if(@$countofsulimetri<1)
								{
									echo 'PASS';
									$componentData['status']="PASS";
								}
								elseif($countofsulimetri>0 && $countofsulimetri<2)
								{
									echo 'SUPPLEMENTARY';
										$componentData['status']="SUPPLEMENTARY";
								}
								else{
									echo 'FAIL';
									$componentData['status']="FAIL";
								}									  
								?>
								</td>
							</tr>
							<tr>
								<th height="30px" style="text-align:center;">Promotion Granted to</th>
								<td style="text-align:center;">
								
								<?php
                                  if(@$countofsulimetri<1)
								{
									 $class_to_promotion =array("Nursery",'KG','PREP', "I","II","III", "IV","V","VI","VII","VIII","IX","X","XI","XII");
						 		 $overallpass=$OverAllTotalnum*100/$OverAllTotalmax;
								if(round($overallpass)>=33){
								$bz=@$student->student_class->roman_name;$k=0;
								foreach($class_to_promotion as $key=>$ax){
								if($ax==$bz){
								$k =$key+1;
								echo $class_to_promotion[$k];

								}
								}
								}
								}
								else{
									echo '-';
								}

								$com->insertData($componentData);
								?>
								</td>
							</tr>
						</table>
					</td>
					<td width="30%">
						<table width="100%" border="1" cellspacing="0" cellpadding="0" >
							<tr class="header_font main_color">
								<th height="20px" colspan="3" style="text-align:center;color:white;">Examination Seal</th>
							</tr>
							<tr>
								<th height="100px" colspan="2" width="50%"></th>
							</tr>
							 
						</table>
					</td>
					</tr>
				</table>
				<?php }?>
								  <?php }?>
						<?php if($marks_type == 'Grade'){ ?>
					   <div class="row row-eq-height">
					   <div class="col-xs-12 table-responsive">
                                <table border="1" cellspacing="0" cellpadding="0" style="width: 100.3%;border-left: unset;text-transform: uppercase;margin-top: -6px;width: 100.2%;">
                                    <tr class="main_color">
                                        <th colspan="3" height="25px" class="header_font" style="text-align:center;padding: 4px;color: white;">
                                           PART-1 Scholastic (GRADING ON NINE POINT SCALE)
                                        </th>
                                    </tr>
                                    <tr class="header_font second_color">
                                        <td width="34%" height="25px">MARKS-RANGE</td>
                                        <td width="33%">GRADE</td> 
                                        <td width="33%">GRADE POINT</td> 
                                    </tr>
                                    <tr>
                                        <td height="15px"><b>91 - 100</b></td>
                                        <td><p style="padding: 6px;"><b>A1</b></p> </td>
                                        <td><p style="padding: 6px;"><b>10.0</b></p> </td>
                                    </tr>

                                    <tr>
                                        <td height="15px"><b>81 - 90</b></td>
                                        <td><p style="padding: 6px;"><b>A2</b> </p></td>
                                        <td><p style="padding: 6px;"><b>9.0</b> </p></td>
                                    </tr>

                                    <tr>
                                        <td height="15px"><p style="padding: 6px;"><b>71 - 80</b></p></td>
                                        <td><b>B1</b> </td>
                                        <td><b>8.0</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 6px;"><b>61 - 70</b></p></td>
                                        <td><b>B2</b> </td>
                                        <td><b>7.0</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 6px;"><b>51 - 60</b></p></td>
                                        <td><b>C1</b> </td>
                                        <td><b>6.0</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 6px;"><b>45 - 50</b></p></td>
                                        <td><b>C2</b> </td>
                                        <td><b>5.0</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 6px;"><b>40 - 44</b></p></td>
                                        <td><b>	D</b> </td>
                                        <td><b>	4.0</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 6px;"><b>21 - 39</b></p></td>
                                        <td><p><b>	E1</b></p> </td>
                                        <td><p><b>	3.0</b></p> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 6px;"><b>00 - 20</b></p></td>
                                        <td><p><b>	E2</b></p> </td>
                                        <td><p><b>	2.0</b></p> </td>
                                    </tr>
                                </table>
                            </div>
                            </div>
					  <?php }?>
					 <?php  if($marks_type == 'Grade'){?>
                        <div class="row row-eq-height">
						
                            <?php if (!empty($non_scholastic_subjects)): ?>
                                <?php 
                                    $type = '';
                                    $part = 1;
                                    $length = count($non_scholastic_subjects);
									//pr($non_scholastic_subjects);die;
									$j=0;
                                 ?>
								 
                                <?php foreach ($non_scholastic_subjects as $key => $subject): 
								
								@$ggg[$subject['parent_id']]+=1;

								//pr($key);die;
								?>
                                    <?php 
									//pr($subject);
                                        if ($subject['type'] != $type){
                                            $type = $subject['type'];
                                            $part++;
                                    ?>
                                        <?php if ($key > 0): ?>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                        <div class="col-xs-12 table-responsive">
                                            <table cellspacing="0px" cellpadding="0px" border="1" id="sample_1" style="text-transform: uppercase;margin-top: -6px;width: 100.2%;
    border-left: unset;" >
                                                <tbody>
                                                    <tr class="header_font main_color">
                                                        <th height="25" colspan="10" style="margin-left:5px;text-align:center;padding: 4px;color: white;">Part <?= $part ?> : <?= $type ?></th>
                                                    </tr>
													<?php if($subject['parentname']){?>
										<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;">Subject</th>
										<?php } ?>
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;">Activities</th>
													<?php $prdk=count($subject['student_marks']);
													if($prdk==1)
													{
													?>
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" ><?php if ($marks_type != 'Grade'){?>Term  I<?php }else{?>Report  I<?php }?></th>
													<?php }else{?>
													<th class="header_font second_color" style="width: 12%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" ><?php if ($marks_type != 'Grade'){?>Term  I<?php }else{?>Report  I<?php }?></th>
													<th class="header_font second_color" style="width: 12%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" ><?php if ($marks_type != 'Grade'){?>Term  II<?php }else{?>Report  II<?php }?></th>
													
													<?php } ?>
                                    <?php } ?>
                                        <tr>
										<?php if($subject['parentname']){ if($j==0){?>
										<td style="width: 25%;" rowspan="<?php echo $ii[$subject['parent_id']];?>"><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;"><?= $subject['parentname'] ?></p></td>
										<?php } }?>
                                            <td style="width: 50%;"><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;"><?= $subject['name'] ?></p></td>
                                            <?php foreach ($subject['student_marks'] as $key => $marksqq): 
											if($marksqq['student_info_id']==$student->id)
										  {
											?>
                                                <td><?php $copres=$marksqq['student_number']*100/$subject['exam_max_marks'][0]['max_marks'];
												 if($copres>=33 && $copres<=59.99)
											{echo "C";}
											else if($copres>=60 && $copres<=79.99)
											{echo "B";}
											else if($copres>=80 && $copres<=100)
											{echo "A";}
												?></td>
										  <?php } endforeach ?>
                                        </tr>

                                <?php $j++;						if($ii[$subject['parent_id']]==@$ggg[$subject['parent_id']]){
									$j=0;
								unset($ggg[$subject['parent_id']]);
								} endforeach ?>
                                </table></div>
                            <?php endif ?>

                        </div>
<?php }?>
<div class="row row-eq-height">
						
                            <?php if (!empty($personality_subjects)): ?>
                                <?php 
                                    $type = '';
                                    $part = 2;
                                    $length = count($personality_subjects);
									//pr($non_scholastic_subjects);die;
									$j=1;
                                 ?>
								 
                                <?php foreach ($personality_subjects as $key => $subject): 
								
								

								//pr($key);die;
								?>
                                    <?php 
									//pr($subject);
                                        if ($subject['type'] != $type){
                                            $type = $subject['type'];
                                            $part++;
                                    ?>
                                        <?php if ($key > 0): ?>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                        <div class="col-xs-12">
                                            <table cellspacing="0px" cellpadding="0px" border="1" id="sample_1" style="text-transform: uppercase;margin-top: -6px;width: 100.2%;
    border-left: unset;" >
                                                <tbody>
                                                    <tr class="header_font main_color">
                                                        <th height="25" colspan="10" style="margin-left:5px;text-align:center;padding: 4px;color: white;">Part <?= $part ?> : <?= $type ?></th>
                                                    </tr>
													
										<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;">Sr.No.</th>
										
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;">Activities</th>
													<?php $prdk=count($subject['student_marks']);
													if($prdk==1)
													{
													?>
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >Report  I</th>
													<?php }else{?>
													<th class="header_font second_color" style="width: 12%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >Report  I</th>
													<th class="header_font second_color" style="width: 12%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >Report  II</th>
													
													<?php } ?>
                                    <?php } ?>
                                        <tr>
										
										<td style="width: 25%;"><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;"><?php echo $j;?></p></td>
										
                                            <td style="width: 25%;"><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;"><?= $subject['name'] ?></p></td>
                                            <?php foreach ($subject['student_marks'] as $key => $marksss): 
											if($marksss['student_info_id']==$student->id)
										  {
											?>
                                                <td><?php $copresss=$marksss['student_number']*100/$subject['exam_max_marks'][0]['max_marks'];
												 if($copresss>=33 && $copresss<=59.99)
											{echo "C";}
											else if($copresss>=60 && $copresss<=79.99)
											{echo "B";}
											else if($copresss>=80 && $copresss<=100)
											{echo "A";}
												?></td>
										  <?php } endforeach ?>
                                        </tr>

                                <?php $j++;	endforeach ?>
                                </table></div>
                            <?php endif ?>

</div>
<!--   ATTITUDE TOWARDS-->
<div class="row row-eq-height">
						
                            <?php if (!empty($attitude_subjects)): ?>
                                <?php 
                                    $type = '';
                                    $part = 3;
                                    $length = count($attitude_subjects);
									//pr($non_scholastic_subjects);die;
									$j=1;
                                 ?>
								 
                                <?php foreach ($attitude_subjects as $key => $subject): 
								//pr($key);die;
								?>
                                    <?php 
									//pr($subject);
                                        if ($subject['type'] != $type){
                                            $type = $subject['type'];
                                            $part++;
                                    ?>
                                        <?php if ($key > 0): ?>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                        <div class="col-xs-12">
                          <table cellspacing="0px" cellpadding="0px" border="1" id="sample_1" style="text-transform: uppercase;margin-top: -5px;width: 100.2%;border-left: unset;" >
                                                <tbody>
                                                    <tr class="header_font main_color">
                                                        <th height="25" colspan="10" style="margin-left:5px;text-align:center;padding: 4px;color: white;">Part <?= $part ?> : <?= $type ?></th>
                                                    </tr>
													
										<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;">Sr.No.</th>
										
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;">Activities</th>
													<?php $prdk=count($subject['student_marks']);
													if($prdk==1)
													{
													?>
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >Report  I</th>
													<?php }else{?>
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >Report  I</th>
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >Report  II</th>
													
													<?php } ?>
                                    <?php } ?>
                                        <tr>
										
										<td style="width: 25%;" ><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;"><?php echo $j;?></p></td>
										
                                            <td style="width: 25%;"><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;"><?= $subject['name'] ?></p></td>
                                            <?php foreach ($subject['student_marks'] as $key => $markspr): 
											if($markspr['student_info_id']==$student->id)
										  {
											?>
                                                <td><?php $coprespr=$markspr['student_number']*100/$subject['exam_max_marks'][0]['max_marks'];
												 if($coprespr>=33 && $coprespr<=59.99)
											{echo "C";}
											else if($coprespr>=60 && $coprespr<=79.99)
											{echo "B";}
											else if($coprespr>=80 && $coprespr<=100)
											{echo "A";}
												?></td>
										  <?php }endforeach ?>
                                        </tr>

                                <?php $j++; endforeach ?>
                                </table></div>
                            <?php endif ?>

                        </div>
								<?php if($marks_type == 'Grade'){?>
           <table cellspacing="0px" cellpadding="0px" border="1" id="sample_1" style="text-transform: uppercase;margin-top: -3px;width: 100.2%;border-left: unset;" >
                                                <tbody>
                                                    <tr class="header_font main_color">
                                                        <th height="25" colspan="10" style="margin-left:5px;text-align:center;padding: 4px;color: white;">PART 5 - RECORD OF ATTENDANCE</th>
                                                    </tr>
													
										<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;">Sr.No.</th>
										
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;">Particulars</th>
													
													<?php $xyz=0;
													 foreach ($att as $attend_meeting){ 
											//pr($attend_meeting);die;
											if($attend_meeting['student_id']==$student->id)
						{
							$xyz+=1;
							$prdk=$xyz;
						}}
						if($prdk==1)
													{
													?>
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >RECORD  I</th>
													<?php }if($prdk==2){?>
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >RECORD  I</th>
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >RECORD  II</th>
													
													<?php }if($prdk==3){ ?>
													<th class="header_font second_color" style="width: 12%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >RECORD  I</th>
													<th class="header_font second_color" style="width: 12%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >RECORD  II</th>
													<th class="header_font second_color" style="width: 12%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >RECORD  III</th>
													
													<?php }?>
													<tr>
													  <td style="width: 25%;" ><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;">1</p></td>
										
                                            <td style="width: 25%;"><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;">Number of Meeting</p></td>
                                            <?php foreach ($att as $attend_meeting): 
											//pr($attend_meeting);die;
											if($attend_meeting['student_id']==$student->id)
										  {
											?>
											
                                                <td><?php echo $attend_meeting['total_meeting'];?></td>
                                                
												
										  <?php } endforeach ?>
                                        </tr>
										<tr>
													  <td style="width: 25%;" ><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;">2</p></td>
										
                                            <td style="width: 25%;"><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;">Meetings Attended</p></td>
                                            <?php foreach ($att as $attend_meeting): 
											//pr($attend_meeting);die;
											if($attend_meeting['student_id']==$student->id)
										  {
											?>
											
                                                <td><?php echo $attend_meeting['attend_meeting'];?></td>
                                                
												
										  <?php } endforeach ?>
                                        </tr>
										<tr>
													  <td style="width: 25%;" ><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;">3</p></td>
										
                                            <td style="width: 25%;"><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;">Percentage</p></td>
                                            <?php foreach ($att as $attend_meeting): 
											//pr($attend_meeting);die;
											if($attend_meeting['student_id']==$student->id)
										  {
											?>
											
                                                <td><?php  
												echo round(($attend_meeting['attend_meeting']*100)/$attend_meeting['total_meeting'],2);
												?></td>
                                                
												
										  <?php } endforeach ?>
                                        </tr>
										<tr>
													  <td style="width: 25%;" ><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;">4</p></td>
										
                                            <td style="width: 25%;"><p style="text-align: left!important;padding-left: 5px;padding: 6px;text-align: center !important;">Remarks</p></td>
                                            <?php foreach ($att as $attend_meeting): 
											//pr($attend_meeting);die;
											if($attend_meeting['student_id']==$student->id)
										  {
											?>
											
                                                <td><?php $per1=round(($attend_meeting['attend_meeting']*100)/$attend_meeting['total_meeting'],2);
						if($per1>=90 && $per1<=100)
						{
							echo "Excellent";
							}
						if($per1>=80 && $per1<=89.99)
						{
						   echo "Very Good";
						}
						if($per1>=75 && $per1<=79.99)
						{
						   echo "Good";
						}
						if($per1<=74.99)
						{
						   echo "Insufficient";
						} 
					?></td>
                                                
												
										  <?php }endforeach ?>
                                        </tr>
								<?php } ?>
                      <?php if($marks_type != 'Grade'){?>
                        <div class="row row-eq-height">
                            <div class="col-xs-5">
                                <table border="1" cellspacing="0" cellpadding="0" style="width: 100.3%;border-left: unset;text-transform: uppercase;margin-top: -6px;width: 100.5%;">
                                    <tr class="main_color">
                                        <th colspan="3" height="25px" class="header_font" style="text-align:center;padding: 4px;color: white;">
                                            Scholastic Area Grade Scale
                                        </th>
                                    </tr>
                                    <tr class="header_font second_color">
                                        <td width="34%" height="20px">MARKS-RANGE</td>
                                        <td width="33%">GRADE</td> 
                                    </tr>
                                    <tr>
                                        <td height="15px"><b>91 - 100</b></td>
                                        <td><p style="padding: 3px;"><b>A1</b></p> </td>
                                    </tr>

                                    <tr>
                                        <td height="15px"><b>81 - 90</b></td>
                                        <td><p style="padding: 3px;"><b>A2</b> </p></td>
                                    </tr>

                                    <tr>
                                        <td height="15px"><p style="padding: 3px;"><b>71 - 80</b></p></td>
                                        <td><b>B1</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 3px;"><b>61 - 70</b></p></td>
                                        <td><b>B2</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 3px;"><b>51 - 60</b></p></td>
                                        <td><b>C1</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 3px;"><b>41 - 50</b></p></td>
                                        <td><b>C2</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 3px;"><b>33 - 40</b></p></td>
                                        <td><b>	D</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 3px;"><b>32 - 	0</b></p></td>
                                        <td><p><b>	E (NEED IMPROVEMENT)</b></p> </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-xs-7">
                                <table border="1"  cellspacing="0" cellpadding="0" style="text-transform: uppercase;margin-top: -6px;height: 102.2%;
    width: 100.3%;" >
                                    <tr class="main_color">
                                        <th colspan="3" height="25px" class="header_font" style="text-align:center;text-transform: uppercase;padding: 4px;color: white;">
                                            Co-Scholastic Activities Grade Scale
                                        </th>
                                    </tr>
                                    <tr class="header_font second_color">
                                        <td width="33%" height="25px">GRADE</td>
                                        <td width="33%">GRADE POINT</td>
                                        <td width="33%">GRADE ACHIEVEMENTS</td>
                                    </tr>
                                    <tr>
                                        <td >A</td>
                                        <td>3</td>
                                        <td>Outstanding</td>
                                    </tr>
                                    <tr>
                                        <td >B</td>
                                        <td>2</td>
                                        <td>Very Good</td>
                                    </tr>
                                    <tr>
                                        <td >C</td>
                                        <td>1</td>
                                        <td>Fair</td>
                                    </tr>
                                </table> 
                            </div>
							
                        </div>
					  <?php }?>
					   <?php if($marks_type == 'Grade'){
						 if(!empty($non_scholastic_subjects)){
						 ?>
					 <table  width="100%" border="1" cellpadding="0" cellspacing="0"   style="font-size:14px;text-align:center ;height:30px" >
				<tr   class="main_color">
					<td height="32px" style="color:white;">
						<b>PART-2,3,4 CO-SCHOLASTIC AREAS (GRADING ON FIVE POINT SCALE )</b>	
					</td>
				</tr>
			</table>

			<table width="100%" border="1" cellpadding="0" cellspacing="0"   style="text-align:center;margin-top:0px;" >
				<tr  class="second_color" >
					<th height="28px" scope="col" style="text-align:center;">Marks</th>
					<th scope="col" style="text-align:center;">Grade</th>
				</tr>
				<tr>
					<td height="20px">91-100</td>
					<td>A+</td>
				</tr>
				<tr>
					<td height="20px">81-90</td>
					<td>A&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td height="20px">71-80</td>
					<td>B+</td>
				</tr>
				<tr>
					<td height="20px">61-70</td>
					<td>B&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td height="20px">51-60</td>
					<td>C&nbsp;&nbsp;</td>
				</tr>
			</table>
						 <?php }}?>
                    </div>
                </div>
            </div>
        </div>
		
        </div>
	
    </div>
</div>
<?php 
$js ="
$(document).ready(function(){
    
});
";
$this->Html->scriptBlock($js, ['block' => 'scriptPageBottom']);
 ?>