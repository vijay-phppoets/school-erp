<style>
.class_hides{
    display: none;
}   
*{
    font-weight: bold;
}
strong{
    font-weight: bold;
}
b{
    font-weight: bold;
}
h3{
    font-weight: bold;
}
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                   Print Admit Card
                </h3>
            </div>
            <div class="box-body padding" style="width: 100% !important;margin-left:1%;">
               
            <?php 
            $i=1;
            if(!empty($students)){
            foreach($students as $student){
            ?>
			 <table class="breackkl"    width="800px"  border="1" style="margin-bottom:16px;" >
            <tr>
            <td width="100%" style=" padding-top:15px; padding-bottom:15px;border:1px solid;padding-left:5px;padding-right:5px">
                <table  width="100%" >
                    <tr>
                        <td rowspan="3">
                            <?php echo $this->Html->image('/img/aloklogo1aa.JPG', array('alt' => 'CakePHP')); ?>
                        </td>
                        <td align="center" >
                            <h3 style="margin-left:-22%;">ALOK SENIOR SECONDARY SCHOOL</h3>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <strong style="margin-left: -27%;">HIRAN MAGRI, SECTOR - 11, Udaipur</strong>
                        </td>
                    </tr>
					<tr>
                        <td align="center">
                            <strong style="margin-left: -28%;">CBSE AFFILIATION. No. 1730007</strong>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                           <strong style="margin-left: -3%;"> SESSION : 2022-2023</strong>
                        </td>
                    </tr>
                </table>
                <table  width="100%" style="font-size:11px">
                    <tr> 
                        <td width="20%">
                            <b > Roll No. :</b>
                        </td>
                        <td  width="25%" style="">
                            <b style="font-size:15px"><?php echo $student->roll_no; ?></b>
                        </td>
						<td width="20%">&nbsp;</td>
                        <td  width="20%">
                            <b> Name :</b>
                        </td>
                        <td  width="35%" align="left" >
                            <?php echo $student->student->name; ?> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b> Class : </b>
                        </td>
                        <td>
                            <?php echo @$student->student_class->name; ?> 
                        </td>
						<td width="20%">&nbsp;</td>
                        <td>
                            <b> Section :</b>
                        </td>
                        <td>
                            <?php echo @$student->section->name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b> Room No.:</b>
                        </td>
						
                        <td >
                            <b style="font-size:15px"><?php echo $room_no ; ?> </b>  
                        </td>
						<td width="20%">&nbsp;</td>
                        <td>
                            <b>Exam:</b>
                        </td>
                        <td>
                            <?php echo $exam->toArray()[0]->name;?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b> Remark : </b>
                        </td>
                        <td>
                            ________
                        </td>
						<td width="20%">&nbsp;</td>
                        <td >
                            <b>Paid/Dues :</b>  </td>
                        <td>
                            ________
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b> Class Teacher :</b>
                        </td>
                        <td><?php //echo $student['student_class']['class_mappings'][0]['employee']['name'];
						 foreach($student['student_class']['class_mappings'] as $stud)
						 {
						 	if($student->student_class_id==$stud->student_class_id && $student->section_id==$stud->section_id && $stud->stream_id==$student->stream_id)
						 	{
						 	echo $stud['employee']['name'];
						 }
						 }
						?>
                            <?php echo @$cls_techr_nm ; ?>
                        </td>
						<td width="20%">&nbsp;</td>
                        <td>
                            <b>Controller Exams.:  </b></td>
                        <td>
                            <b>Anil Mehta</b>
                        </td>
                    </tr>
                </table>
				<?php if($time_table_syllabuses){?>
				<table style="width: 100%; margin-top:10px;margin-bottom:0px;" border="1">
                        <tr>
                            <th style="text-align: center;width: 5%"><b>S.No</b></th>
                            <th style="text-align: center;width: 20%"><b>Subject Name</b></th>
                            <th style="text-align: center;width: 25%"><b>Date</b></th>
                            <th style="text-align: center;width: 15%"><b>From</b></th>
                            <th style="text-align: center;width: 15%"><b>To</b></th>
                        </tr>
						<?php
						$ix=1;
						$a="";
						$b="";
						$ddd=[];
						
						foreach($time_table_syllabuses as $time_labuses){
							if($student->student_class_id==$time_labuses->class_id && $student->section_id==$time_labuses->section_id && $time_labuses->stream_id==$student->stream_id)
							{
							 $ddd[strtotime($time_labuses->date)][]=$time_labuses;
							}
						}
						
							
							//$b=$time_labuses->date;
							
								//pr($ddd);die;
								?>
								
                       <?php foreach($ddd as $time_labus){
						   $sd=[];
							    foreach($time_labus as $time_labu){ 
								     if($time_labu->parent)
									 {
									$sd[]=$time_labu->parent."->".$time_labu->subject->name;
									 }else{
										 $sd[]=$time_labu->subject->name;
									 }
								}
								
						   ?>     
							
                        <tr>
                            <td style="text-align: center;width: 5%"><?php echo $ix;?></td>
                            <td style="text-align: center;width: 15%"><?php echo implode('/',$sd);?></td>
                            <td style="text-align: center;width: 15%"><p><?php echo $time_labu->date;?> <?php echo  date('l',strtotime($time_labu->date));?></p></td>
                            
							
                            <td style="text-align: center;width: 15%"><?php echo $time_labu->time_from;?></td>
                            <td style="text-align: center;width: 15%"><?php echo $time_labu->time_to;?></td>
                        </tr>
					   <?php $ix++; }  ?>
                    </table>
					<?php } ?>
            </td>
			</tr>
			</table>
			
            <?php 
            if($i==2)
            {
                echo '</tr><tr>';
                $i=0;
            }
            $i++;
            } }?>
        
       
            </div>
        </div>
    </div>
</div>


