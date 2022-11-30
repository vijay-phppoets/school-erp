<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StudentElectiveSubject[]|\Cake\Collection\CollectionInterface $studentElectiveSubjects
 */
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border" >
                <?php if(!empty($id)){ ?>
                  <label > Mark Sheet </label>
                <?php }else{ ?>
                  <label> Mark Sheet </label>
                <?php } ?>
            </div>
            <div class="box-body">
                <div class="form-group">    
                    <?= $this->Form->create($studentMark,['id'=>'ServiceForm','autocomplete'=>false]) ?>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label">Scholar No. <span class="required" aria-required="true"> * </span></label>
                            <?= $this->Form->control('scholar_no',['label' => false,'class'=>'form-control ','placeholder'=>'Scholar No.','type'=>'text','required','id'=>'scholar_no','name'=>'scholar_no']); ?>
                        </div>
                    
                        <div class="col-md-4">
                            <label class="control-label"> Roll No. </label>
                            <?php echo $this->Form->control('roll_no',['label' => false,'class'=>'form-control ','placeholder'=>'Roll No.','type'=>'text','required','id'=>'roll_no','name'=>'roll_no']); ?>
                            <?php echo $this->Form->hidden('last',['value'=>0,'id'=>'last']); ?>
                        </div>
                 
                        <div class="col-md-4">                           
                            <?php echo $this->Form->button('View Marksheet',['class'=>'btn button btnClass','id'=>'submit_member']); ?>                       
                        </div>
                    </div>
					  <?php $this->Form->unlockField('last');?>
                    <?= $this->Form->end() ?>
                </div>                
            </div>
        </div>
    </div>
</div>
<?php 
// public function markSheetScholar()
//     {
//         $studentMark = $this->StudentMarks->newEntity();
//         $user_id=$this->Auth->User('id');

       
//         if($this->request->is('post'))
//         {           

//             $students = $this->StudentMarks->StudentInfos->find()
//             ->select($this->StudentMarks->StudentInfos)
//             ->select(['name'=>'Students.name','scholer_no'=>'Students.scholar_no'])            
//             ->where(['StudentInfos.session_year_id'=>$this->Auth->user('session_year_id'),'StudentInfos.student_id'=>$user_id])
//             ->where(['is_deleted'=>'N'])
//             ->contain(['Students'])
//             ->order(['Students.name ASC'])->first();

//             $ClassMappings = $this->StudentMarks->ClassMappings->find()
//                             ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
//                             ->where(['ClassMappings.student_class_id'=>$students->student_class_id])
//                             ->where(['ClassMappings.stream_id'=>$students->stream_id])
//                             ->where(['ClassMappings.section_id'=>$students->section_id])
//                             ->where(['ClassMappings.medium_id'=>$students->medium_id])
//                             ->where(['ClassMappings.is_deleted'=>'N'])
//                             ->contain(['Mediums','StudentClasses','Streams','Sections'])->first();

//             $response = $this->StudentMarks->ExamMasters->find('threaded')
//                         ->where(['ExamMasters.student_class_id'=>$ClassMappings->student_class_id,'ExamMasters.session_year_id'=>$this->Auth->user('session_year_id'),'ExamMasters.parent_id'=>0,'is_deleted'=>'N','stream_id'=>@$ClassMappings->stream_id])->order(['ExamMasters.order_number'=>'DESC'])->first();

//             $student_info_id=$students->id;
//             $student_class_id=$students->student_class_id;
//             $exam_master_id=$response->id;
//             $last=1;
//             $stream_id=$students->stream_id;
//             $section_id=$students->section_id;

//             // echo "<pre>";print_r($ClassMappings);exit;
//             if(strtoupper($ClassMappings->student_class->name) == 'NINTH' || strtoupper($ClassMappings->student_class->name) == 'TENTH'){

//                  return $this->redirect(['controller'=>'StudentMarks','action' => 'viewMarkSheetixx/'.$student_info_id,$student_class_id,$exam_master_id,$last,$stream_id,$section_id]);
//             }
//             else if(strtoupper($ClassMappings->student_class->name) == 'ELEVENTH'){
//                 return $this->redirect(['controller'=>'StudentMarks','action' => 'viewMarkSheetxi/'.$student_info_id,$student_class_id,$exam_master_id,$last,$stream_id,$section_id]);
//             }
//             else{
//                 return $this->redirect(['controller'=>'StudentMarks','action' => 'viewMarkSheet1/'.$student_info_id,$student_class_id,$exam_master_id,$last,$stream_id,$section_id]);
//             // }              
           
//         }
//         //$mediums = $this->StudentMarks->Mediums->find('list');
//         $this->set(compact('studentMark', 'sessionYears', 'studentInfos', 'examMasters', 'subjects','classMappings','students','ClassMappingssss'));
//     }
?>

<?= $this->element('loading') ?>
<?= $this->element('selectpicker') ?>
<?= $this->element('validate') ?>
