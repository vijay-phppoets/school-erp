
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
{height: auto; border: 1px solid; font-family: Arial, Helvetica, sans-serif; page-break-after:always;
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
</style>
<?php
//pr($student);die;
$totleopten=[]; 
															$totleoptentotle=[]; 
															$examid=[]; 
								$term_wice_passnumber=[];$term_wice_passtotole=[]; 		
								 $countofsulimetri=0; 
   $sublimenterysubject=[]; 
 $url=$awsFileLoad->cdnpath();								
	?>
<div class="portlet light ">
    <div  style="background: white;"><div class="row">
	
        <div class="col-md-12 >
            <div class="box box-primary">
                <div class="box-header with-border">
                </div> 
                <div class="box-body">
                    <div class="a1">
                        <div class="row">
                            <div class="col-sm-12">
                                <table width="100%" border="0" style="text-transform: uppercase;"><br>
                                    <tr>
                                        <td width="15%">
                                            <?php echo $this->Html->image('aloklogo1.JPG', array('width' => '140','height'=>140)); ?>
                                        </td>
                                        <td width="66%">
                                            <div  style="font-size:26px; word-spacing:1px; text-align:center;">
                                                <p style="font-family:Georgia; "><?php echo @$schooledatas->name;?></p>
                                            </div>
                                            <div  style="font-size:21px; margin-top:-6px;text-align:center;"> 
                                                <strong><?php echo @$schooledatas->address;?></strong>
                                            </div>
                                            <div  style="font-size:18px; margin-top:4px; text-align:center;">
                                                <strong><?php echo @$schooledatas->affiliation_no;?></strong>
                                            </div>
						<div  style="font-size:21px; margin-top:0px; text-align:center;">
                                                <strong><b style = "font-family:Georgia; font-size:20px;">Record of Academic Performance</b> <br>
                                               Session : <?php echo $sy_name;?></strong>
                                            </div>
                                        </td>
                                        <td width="15%">
                                            <?php echo $this->Html->image($url.'/'.$student->student_image, array('width' => '140','height'=>140)); ?>
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
											
                                        </th>
                                    </tr>
                                    <tr align="left">
                                        <th style="width:15%" class="firstTH">DOB</th>
                                        <th style="width:55%" align="left">: &nbsp; <?= @$student->student->dob?></th>
                                        <th style="width:15%">Section</th>
                                        <th align="left"> : &nbsp; <?= $student->has('section') ? ' '.$student->section->name :''?></th>
                                    </tr>
                                  <!--  <tr align="left" >
                                        <th class="firstTH">Address</th>
                                        <th> : &nbsp; <?= @$student->parmanent_address?></th>
                                    </tr>
									-->
                                </table>
                            </div>

                            <div class="col-xs-12">
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
                                        <?php $examArray = $exams; ?>
                                        <?php for ($i=0; $i < $itteration; $i++) { ?>
                                            <tr class="header_font second_color">
                                                <?php if ($i == 0): ?>
                                                    <th <?= $maxDepth!=0?'rowspan='.$maxDepth:'' ?> colspan="<?=$subjectLength?>"><p> Subjects</p></th>
                                                <?php endif ?>

                                                <?php foreach ($examArray as $key => $section): ?>
                                                    <?php $rowSpan = ($Find->arrayDepth($section) == 0 ? $maxDepth : 0)?>
                                                    <?php $colSpan = $Find->arrayWidth($section)?>
                                                    
                                                    <?php if($i == ($itteration - 1) || $Find->arrayDepth($section) == 0){
                                                        $examLength++;
                                                    } ?>
                                                    <th <?= $rowSpan!=0?'rowspan='.$rowSpan:'' ?> <?= $colSpan > 0?'colspan='.$colSpan:'' ?> height="15px"  <?php if($last==0){?>width="15%"<?php }else{?>width="8%"<?php }?>><p>
                                                        <?= $section['name'] ?></p>
														
                                                    </th>
													
                                                <?php endforeach; ?>
                                                <?php if ($i == 0 && $marks_type != 'Grade'): ?>
                                                    <th rowspan="<?= $maxDepth ?>"><p> Total</p></th>
                                                    <?php if ($marks_type != 'Number'): ?>
                                                        <th rowspan="<?= $maxDepth ?>"><p> Grade</p></th>
                                                    <?php endif ?>
                                                <?php endif ?>
                                            <?php 
                                                $maxDepth--;
                                                $exams2 = $examArray;
                                                unset($examArray);
                                                $examArray = $Find->nextChild($exams2);
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
                                                foreach ($scholastic_subjects as $sub_key => $scholastic_subject): ?>
												
                                                    <?php $currentDepth =  $Find->arrayDepth($scholastic_subject);?>
                                                    <?php $colSpan = $maxDepth - $currentDepth; ?>
                                                    <tr>
                                                        <?php $a[0] = $scholastic_subject; ?>
                                                        <?php $rowspan = $Find->maxWidth($a); ?>
                                                        <th width="20%" class="subjects" rowspan="<?= $rowspan==0?'':$rowspan ?>" colspan="<?= $colSpan==0?'':$colSpan ?>"><p style="text-align: left!important;padding-left: 5px;padding: 10px 4px;"><?= $scholastic_subject['name'] ?></p></th>
														
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
                                                    <?php $colSpan = $maxDepth - $currentDepth; ?>
                                                    <?php $a[0] = $scholastic_subject; ?>
                                                        <?php $rowspan = $Find->maxWidth($a); ?>
                                                        <th class="subjects" colspan="<?= $colSpan==0?'':$colSpan ?>" rowspan="<?= $rowspan==0?'':$rowspan ?>"><p style="text-align: left!important;margin-left: 4px !important;  padding: 10px 0;"><?= $scholastic_subject['name'] ?></p></th>
                                                        <?php if(empty($scholastic_subject['children'])):?>
                                                            <?php $subject_id = $scholastic_subject['id'] ?>
                                                            <?php $subject_total = 0; ?>
                                                            <?php $total=0; ?>
                                                            <!-- print marks -->
                                                            <?php foreach ($scholastic_subject['exams'] as $exam_key => $exam):
                                                         //    pr($marks->toArray());die;
															?>
                                                                <td>
                                                                    <?php foreach ($marks as $key => $result): ?>
                                                                        <?php $fail = explode(',',$result->fail); ?>
                                                                        <?php $supplementary = explode(',',$result->supplementary); ?>
                                                                        <?php foreach ($result['result_rows'] as $key => $result_row): ?>

                                                                            <?php if ($result_row->exam_master_id == $exam['id'] && $result_row->subject_id == $subject_id): ?>
                                                                                    <?php 
                                                                                        if($marks_type == 'Grade')
																						{
                                                                                          //  echo $result_row->grade;
																					   	 $result_row->obtain;
                                                                                             '/'.$result_row->total;
                                                                                            $subject_total = $result_row->obtain;
                                                                                            $total = $result_row->total;
																							@$term_wice_passtotole[$exam['id']]+=$total;
																							@$term_wice_passnumber[$exam['id']]+=$subject_total;
																							$subject_per = $subject_total*100/$total;
																	                        $subject_per1=round($subject_per);
																							 foreach($infogread as $infog)
																	{
																		if(in_array($subject_per1, range($infog->min_marks, $infog->max_marks)) )
																		{
																			echo $infog->grade;
																			//echo $subject_total;
																			//echo $total;
																		}
																	}
																	$neaddforpasspasstotole=array_sum ($term_wice_passtotole);
																	$neaddforpasspassnumber=array_sum ($term_wice_passnumber);
																						}
                                                                                        else
                                                                                        {
                                                                                            echo $result_row->obtain;
                                                                                            echo '/'.$result_row->total;
                                                                                            $subject_total += $result_row->obtain;
                                                                                            $total += $result_row->total;
                                                                                        }
                                                                                     ?>  
                                                                            <?php endif ?>
                                                                        <?php endforeach ?>
                                                                    <?php endforeach ?>
                                                                </td>
                                                            <?php endforeach ?>
                                                            <?php if ($marks_type != 'Grade'): ?>
                                                            <td><?= $subject_total ?> / <?= $total ?></td>
                                                                <?php if ($marks_type != 'Number'): ?>
                                                                    <th><?php $subject_per = $subject_total*100/$total;
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
                                                <?php endforeach; 
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
                                                                    <?php  foreach ($marks as $key => $result): 
																	 //pr($result);die;
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
																		if($subject_per1>=33){
																			
																		}else{
																			 $countofsulimetri+=1;
																			 $sublimenterysubject[]=$scholastic_subject['name'];
																		}
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
										
                                            <th ><p style="text-align: left!important;padding-left: 5px;padding: 10px 0;">Total</p></th>
                                            <?php $grand_total=0; if($examid) { foreach ($examid as $sub_key => $scholastic_subject){
												?>
												
                                                <th><p><?php @$prrj+=$totleopten[$sub_key];@$rjpr+=$totleoptentotle[$sub_key]; echo $totleopten[$sub_key];?>/<?php echo $totleoptentotle[$sub_key];?></p></th>
                                               <?php
                                            } }?>
											<?php $passtobeneed=$prrj;$passtoneedallmarks=$rjpr;?>
                                           <th><p><?php echo @$prrj;?>/<?php echo @$rjpr; ?></p></th> 
                                           <th><p ><?php  @$totlepersent=$prrj*100/ $rjpr;
                                                  @$totlepe= round($totlepersent);
                                                   foreach($infogread as $infog)
																	{
																		if(in_array($totlepe, range($infog->min_marks, $infog->max_marks)) )
																		{
																			echo $infog->grade;
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
                            <div class="col-xs-12">
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
                                        <td><?php /*echo date("d/M/Y");*/echo "16/March/2022"; ?></td>
                                        <td>Date of Issue</td>
                                        <td><?php /*echo date("d/M/Y"); */echo "16/March/2022";?></td>
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
                                        <th style="text-align:center;">Remarks</th>
                                        
                                    </tr>
                                    <tr class="header_sub">
                                        <th height="25px" style="text-align:center;">
                                          <?php echo @$att[0]->total_meeting;?>
                                        </th>
                                        <th style="text-align:center;"><?php echo @$att[0]->attend_meeting;?></th>
										<?php  @$Percentageatt=@$att[0]->attend_meeting*100/@$att[0]->total_meeting;?>
                                        <th style="text-align:center;"><?php if($Percentageatt){echo round(@$Percentageatt).'%';}?></th>
										
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
								  if($marks_type == 'Grade'){
				if($last==1){
				?>
				<table width="100%"  border="1" style="margin-top:-4px;margin-bottom: -5px;" cellspacing="0" cellpadding="0" >
					<tr>
					<td width="70%">
						<table width="100%" border="1" cellspacing="0" cellpadding="0" >
							<tr  class="header_font main_color">
								<th height="28px" colspan="3" style="text-align:center;color:white;">Final Report</th>
							</tr>
							<tr >
								<th height="25px" width="50%" style="text-align:center;">Over All Grade</th>
								<td height="25px" width="50%" style="text-align:center;">
								<?php 
							 	$overallpass=$neaddforpasspassnumber/$neaddforpasspasstotole*100;
								
								 foreach($infogread as $infog)
																	{
																		if(in_array(round($overallpass), range($infog->min_marks, $infog->max_marks)) )
																		{
																			echo $infog->grade;
																		}
																	}
								?>
								</td>
							</tr>
							<tr>
								<th height="25px" style="text-align:center;">Result</th>
								<td style="text-align:center;">
								<?php  $overallpass=$neaddforpasspassnumber/$neaddforpasspasstotole*100;
								          
                                          if($overallpass>=40){
											  echo "PASS";
										  }else{
											  echo "FAIL";
										  }										  
								?>
								</td>
							</tr>
							<tr>
								<th height="25px" style="text-align:center;">Promotion Granted to</th>
								<td style="text-align:center;">
								<?php $class_to_promotion =array("Nursery",'KG','PREP', "I","II","III", "IV","V","VI","VII","VIII","IX","X","XI","XII");
								 $overallpass=$neaddforpasspassnumber/$neaddforpasspasstotole*100;
								if(round($overallpass)>=40){
								$b=@$student->student_class->roman_name;$k=0;
								foreach($class_to_promotion as $key=>$a){
								if($a==$b){
								$k =$key+1;
								echo $class_to_promotion[$k];

								}
								}
								}
								?>
								</td>
							</tr>
						</table>
					</td>
					<td width="30%">
						<table width="100%" border="1" cellspacing="0" cellpadding="0" >
							<tr class="header_font main_color">
								<th height="28px" colspan="3" style="text-align:center;color:white;">Examination Seal</th>
							</tr>
							<tr>
								<th height="105px" colspan="2" width="50%"></th>
							</tr>
							 
						</table>
					</td>
					</tr>
				</table>
				<?php }?>
								  <?php }?>
								    <?php 
								  if($marks_type != 'Grade'){
				if($last==1){
				?>
				<table width="100%"  border="1" style="margin-top:-4px;margin-bottom: -5px;" cellspacing="0" cellpadding="0" >
					<tr>
					<td width="70%">
						<table width="100%" border="1" cellspacing="0" cellpadding="0" >
							<tr  class="header_font main_color">
								<th height="26px" colspan="3" style="text-align:center;color:white;">Final Report</th>
							</tr>
							<tr >
								<th height="35px" width="50%" style="text-align:center;">Scope for Improvement</th>
								<td height="35px" width="50%" style="text-align:center;">
								<?php  
						if($countofsulimetri>0 && $countofsulimetri<=2)
									{
										
										echo implode(" , ",$sublimenterysubject);
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
								if($countofsulimetri<1)
								{
									echo 'PASS';
								}
								elseif($countofsulimetri>0 && $countofsulimetri<3)
								{
									echo 'SUPPLEMENTARY';
								}
								else{
									echo 'FAIL';
								}									  
								?>
								</td>
							</tr>
							<tr>
								<th height="35px" style="text-align:center;">Promotion Granted to</th>
								<td style="text-align:center;">
								
								<?php
                                  if($countofsulimetri<1)
								{
									$class_to_promotion =array("Nursery",'KG','PREP', "I","II","III", "IV","V","VI","VII","VIII","IX","X","XI","XII");
								 $overallpass=$passtobeneed/$passtobeneed*100;
								if(round($overallpass)>=33){
								$b=@$student->student_class->roman_name;$k=0;
								foreach($class_to_promotion as $key=>$a){
								if($a==$b){
								$k =$key+1;
								echo $class_to_promotion[$k];

								}
								}
								}
								}
								else{
									echo '-';
								}

								
								?>
								</td>
							</tr>
						</table>
					</td>
					<td width="30%">
						<table width="100%" border="1" cellspacing="0" cellpadding="0" >
							<tr class="header_font main_color">
								<th height="28px" colspan="3" style="text-align:center;color:white;">Examination Seal</th>
							</tr>
							<tr>
								<th height="105px" colspan="2" width="50%"></th>
							</tr>
							 
						</table>
					</td>
					</tr>
				</table>
				<?php }?>
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
                                        <div class="col-xs-12">
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
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" ><?php if ($marks_type != 'Grade'){?>Term  I<?php }else{?>Report  I<?php }?></th>
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" ><?php if ($marks_type != 'Grade'){?>Term  II<?php }else{?>Report  II<?php }?></th>
													
													<?php } ?>
                                    <?php } ?>
                                        <tr>
										<?php if($subject['parentname']){ if($j==0){?>
										<td style="width: 25%;" rowspan="<?php echo $ii[$subject['parent_id']];?>"><p style="text-align: left!important;padding-left: 5px;padding: 3px;text-align: center !important;"><?= $subject['parentname'] ?></p></td>
										<?php } }?>
                                            <td style="width: 25%;"><p style="text-align: left!important;padding-left: 5px;padding: 3px;text-align: center !important;"><?= $subject['name'] ?></p></td>
                                            <?php foreach ($subject['student_marks'] as $key => $marksqq): 
											
											?>
                                                <td><?php $copres=$marksqq['student_number']*100/$subject['exam_max_marks'][0]['max_marks'];
												if($copres>=0 && $copres<=39.99)
							                    {echo "E";}
						                     	else if($copres>=40 && $copres<=50.99)
							                    {echo "D";}
							                    else if($copres>=51 && $copres<=60.99)
							                    {echo "C";}
							                    else if($copres>=61 && $copres<=70.99)
							                    {echo "B";}
												else if($copres>=71 && $copres<=80.99)
												{echo "B+";}
												else if($copres>=81 && $copres<=90.99)
												{echo "A";}
												else if($copres>=91 && $copres<=100)
												{echo "A+";}
												?></td>
										  <?php  endforeach ?>
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
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >Report  I</th>
													<th class="header_font second_color" style="width: 25%;text-align: center !important;padding: 6px;font-weight: 600 !important;font-weight: 600!important;" >Report  II</th>
													
													<?php } ?>
                                    <?php } ?>
                                        <tr>
										
										<td style="width: 25%;"><p style="text-align: left!important;padding-left: 5px;padding: 3px;text-align: center !important;"><?php echo $j;?></p></td>
										
                                            <td style="width: 25%;"><p style="text-align: left!important;padding-left: 5px;padding: 3px;text-align: center !important;"><?= $subject['name'] ?></p></td>
                                            <?php foreach ($subject['student_marks'] as $key => $marksss): 
											
											?>
                                                <td><?php $copresss=$marksss['student_number']*100/$subject['exam_max_marks'][0]['max_marks'];
												 if($copresss>=0 && $copresss<=39.99)
							                    {echo "E";}
						                     	else if($copresss>=40 && $copresss<=50.99)
							                    {echo "D";}
							                    else if($copresss>=51 && $copresss<=60.99)
							                    {echo "C";}
							                    else if($copresss>=61 && $copresss<=70.99)
							                    {echo "B";}
												else if($copresss>=71 && $copresss<=80.99)
												{echo "B+";}
												else if($copresss>=81 && $copresss<=90.99)
												{echo "A";}
												else if($copresss>=91 && $copresss<=100)
												{echo "A+";}
												?></td>
										  <?php  endforeach ?>
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
										
										<td style="width: 25%;" ><p style="padding-left: 5px;padding: 2px;text-align: center !important;"><?php echo $j;?></p></td>
										
                                            <td style="width: 25%;"><p style="padding-left: 5px;padding: 2px;text-align: center !important;"><?= $subject['name'] ?></p></td>
                                            <?php foreach ($subject['student_marks'] as $key => $markspr): 
										
											?>
                                                <td><?php $coprespr=$markspr['student_number']*100/$subject['exam_max_marks'][0]['max_marks'];
												 if($coprespr>=0 && $coprespr<=39.99)
							                    {echo "E";}
						                     	else if($coprespr>=40 && $coprespr<=50.99)
							                    {echo "D";}
							                    else if($coprespr>=51 && $coprespr<=60.99)
							                    {echo "C";}
							                    else if($coprespr>=61 && $coprespr<=70.99)
							                    {echo "B";}
												else if($coprespr>=71 && $coprespr<=80.99)
												{echo "B+";}
												else if($coprespr>=81 && $coprespr<=90.99)
												{echo "A";}
												else if($coprespr>=91 && $coprespr<=100)
												{echo "A+";}
												?></td>
										  <?php endforeach ?>
                                        </tr>

                                <?php $j++; endforeach ?>
                            </tbody>
                                </table></div>
                            <?php endif ?>

                        </div>
								<?php  if($marks_type == 'Grade'){?>
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
											if($attend_meeting['student_id']==$student->student_id)
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
											if($attend_meeting['student_id']==$student->student_id)
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
											if($attend_meeting['student_id']==$student->student_id)
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
											if($attend_meeting['student_id']==$student->student_id)
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
                                    </tbody>
                                </table>
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
                                        <td width="34%" height="25px">MARKS-RANGE</td>
                                        <td width="33%">GRADE</td> 
                                    </tr>
                                    <tr>
                                        <td height="15px"><b>91 - 100</b></td>
                                        <td><p style="padding: 6px;"><b>A1</b></p> </td>
                                    </tr>

                                    <tr>
                                        <td height="15px"><b>81 - 90</b></td>
                                        <td><p style="padding: 6px;"><b>A2</b> </p></td>
                                    </tr>

                                    <tr>
                                        <td height="15px"><p style="padding: 6px;"><b>71 - 80</b></p></td>
                                        <td><b>B1</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 6px;"><b>61 - 70</b></p></td>
                                        <td><b>B2</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 6px;"><b>51 - 60</b></p></td>
                                        <td><b>C1</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 6px;"><b>41 - 50</b></p></td>
                                        <td><b>C2</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 6px;"><b>33 - 40</b></p></td>
                                        <td><b>	D</b> </td>
                                    </tr>
									<tr>
                                        <td height="15px"><p style="padding: 6px;"><b>32 - 	0</b></p></td>
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
				<!-- 	 <table  width="100%" border="1" cellpadding="0" cellspacing="0"   style="font-size:14px;text-align:center ;height:30px" >
				
			</table> -->
		</tbody>
			<div class="row row-eq-height">
				<div class="col-xs-5">
				<table border="1" cellpadding="0" cellspacing="0"   style="text-align:center;margin-top:0px;">
					<tbody>
						<tr   class="main_color">
					<th height="32px" colspan="2" style="text-align:center;color:white;">
						<b>PART-1 CO-SCHOLASTIC AREAS (GRADING ON FIVE POINT SCALE )</b>	
					</th>
				</tr>
				<tr  class="second_color" >
					<th height="28px" scope="col" style="text-align:center;">Marks</th>
					<th scope="col" style="text-align:center;">Grade</th>
				</tr>

				<tr>
					<td >91-100</td>
					<td  >A+</td>
				</tr>
				<tr>
					<td >71-80</td>
					<td  >B+</td>
				</tr>
				<tr>
					<td >61-70</td>
					<td >B</td>
				</tr>
				<tr>
					<td >51-60</td>
					<td  >C</td>
				</tr>
					</tbody>
				</table>
			</div>
			<div class="col-xs-7">
			<table border="1" cellpadding="0" cellspacing="0"   style="text-align:center;margin-top:0px;" >
				<tbody>
				<tr   class="main_color">
					<th height="32px" colspan="3" style="text-align:center;color:white;">
						<b>PART-2,3,4  Scholastic (GRADING ON NINE POINT SCALE)</b>	
					</th>
				</tr>
				<tr  class="second_color" >
				<th height="28px" scope="col" style="text-align:center;width:279px;">MARKS-RANGE</th>
					<th scope="col" style="text-align:center;width:279px;">GRADE</th>
					<th scope="col" style="text-align:center; width:279px;">GRADE POINT</th>
				</tr>
				<tr>
					<td height="20px">91-100</td>
					<td>A1</td>
					<td>10.0</td>
					
				</tr>
				
				<tr>
                                        <td height="20px"><b>81 - 90</b></td>
                                        <td><b>A2</b></td>
                                        <td><b>9.0</b></td>
										
                                    </tr>

                                    <tr>
                                        <td height="20"><b>71 - 80</b></td>
                                        <td><b>B1</b> </td>
                                        <td><b>8.0</b> </td>
										
                                    </tr>
									<tr>
                                        <td height="20px"><b>61 - 70</b></td>
                                        <td><b>B2</b> </td>
                                        <td><b>7.0</b> </td>
										
                                    </tr>
									<tr>
                                        <td height="20px"><b>51 - 60</b></td>
                                        <td><b>C1</b> </td>
                                        <td><b>6.0</b> </td>
                                    </tr>
									<tr>
                                        <td height="20px"><b>45 - 50</b></td>
                                        <td><b>C2</b> </td>
                                        <td><b>5.0</b> </td>
                                    </tr>
									<tr>
                                        <td height="20px"><b>40 - 44</b></td>
                                        <td><b>	D</b> </td>
                                        <td><b>	4.0</b> </td>
                                    </tr>
									<tr>
                                        <td height="20px"><b>21 - 39</b></td>
                                        <td><p><b>	E1</b></p> </td>
                                        <td><p><b>	3.0</b></p> </td>
                                    </tr>
									<tr>
                                        <td height="20px"><b>00 - 20</b></td>
                                        <td><p><b>	E2</b></p> </td>
                                        <td><p><b>	2.0</b></p> </td>
                                    </tr>
				
				</tbody>
			</table>
			</div>

			
			</div>
						 <?php }}?>
						<!--  <?php if($marks_type == 'Grade'){ ?>
					   <div class="row row-eq-height">
					   <div class="col-xs-12">
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
					  <?php }?> -->
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