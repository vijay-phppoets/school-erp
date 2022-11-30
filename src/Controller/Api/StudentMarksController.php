<?php
namespace App\Controller\Api;
use App\Controller\Api;
use App\Controller\Api\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
/* Students Controller */
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StudentMarksController extends AppController
{

    public function viewMarkSheet()
    { 
        $student_info_id=$this->request->getData('student_info_id');
        $student_class_id=$this->request->getData('student_class_id');
        $exam_master_id=$this->request->getData('exam_master_id');
        $last=$this->request->getData('last');
        $stream_id=$this->request->getData('stream_id');
        $section_id=$this->request->getData('section_id');


        $where['student_class_id'] = $student_class_id;
        $sy_id = $this->Auth->user('session_year_id');
        $sy_name = $this->Auth->user('session_name'); 
        if($stream_id==0)
        {
             $where['stream_id'] = '';
        }else{
            $where['stream_id'] = $stream_id;
        }
       $infodata=$this->StudentMarks->ClassMappings->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id,'section_id'=>$section_id,'ClassMappings.session_year_id'=>$sy_id])->contain(['employees']);
       
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id,"session_year_id"=>$sy_id]);
   //  pr($infodata->toArray());die;
        
        $where = array_filter($where, function($value) { return $value != ''; });
        $this->viewBuilder()->setLayout('pdf');

        
        $student = $this->StudentMarks->StudentInfos->get($student_info_id, [
            'contain' => ['Students','StudentClasses','Sections','Streams']
        ]);
//pr($student['student']->id);die;
   
        $marks_type = $student->student_class->grade_type;
       
       if($last == 0)
        {
            $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id])->where(['ExamMasters.session_year_id'=>$sy_id])->contain(['SubExams']);
            if($student_class_id==1 or $student_class_id==2 or $student_class_id==3 or $student_class_id==4 or $student_class_id==5 ){
                if($exam_master_id==133 or $exam_master_id==134 or $exam_master_id==135 or $exam_master_id==136 or $exam_master_id==137)
                {
                $children = $this->StudentMarks->ExamMasters->find()->where(['ExamMasters.id'=>$exam_master_id,'ExamMasters.session_year_id'=>$sy_id])->contain(['SubExams']);
                }
            }
        }
      else{  
            $children = $this->StudentMarks->ExamMasters->find()->where([$where,'session_year_id'=>$sy_id])->order(['ExamMasters.order_number'=>'ASC'])->contain(['SubExams']);
          }  
  // pr($children->toArray());die;
        if(!empty($children->toArray()))
        {
            $old_exam_master_id = $exam_master_id;
            $exam_master_id = [];
            $exam_master_id[] = $old_exam_master_id;
            foreach ($children as $key => $child) {
                //pr($child);
                $exam_master_id[] = $child->id;
                if($child['sub_exams'])
                {
                    foreach($child['sub_exams'] as $key1=>$sub)
                    {
                        $exam_master_id[] = $sub->id;
                    }
                }
            }
          
        }
       
      $examattendances = $this->StudentMarks->ExamAttendances->find()->where(['ExamAttendances.student_id'=>$student->id,'ExamAttendances.exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
   $att=$examattendances->toArray();
 // pr($att);die;
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N','ExamMasters.session_year_id'=>$sy_id]);

        $marks = $this->StudentMarks->Results->find()->where(['student_info_id'=>$student_info_id,'exam_master_id IN'=>$exam_master_id])->contain(['ResultRows'=>function($q){
                return $q->order(['ExamMasters.order_number'=>'ASC'])->contain(['ExamMasters']);
            }]); 
        
        

        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id,'Subjects.is_deleted'=>'N'])->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);
   // pr($exam_master_id);die;
        $non_scholastic_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>2,'Subjects.is_deleted ='=>'N','Subjects.session_year_id'=>$sy_id]);
        
        $non_scholastic_subjects = json_decode(json_encode($non_scholastic_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($non_scholastic_subjects as $key => $subject)
        { 
        @$ii[$subject['parent_id']]+=1;
        @$prashantsubject=$this->StudentMarks->Subjects->find()->where(['Subjects.id'=>$subject['parent_id'],'Subjects.session_year_id'=>$sy_id]);
        //pr();die;
        $non_scholastic_subjects[$key]['parentname']=@$prashantsubject->toArray()[0]->name;
            if(empty($subject['student_marks']))
            {
                unset($non_scholastic_subjects[$key]);
            }
 }
  $personality_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>4,'Subjects.is_deleted ='=>'N','Subjects.session_year_id'=>$sy_id]);
        
        $personality_subjects = json_decode(json_encode($personality_subjects->toArray()),true);
  // pr($non_scholastic_subjects);die;
        foreach ($personality_subjects as $key => $subject)
        { 
            if(empty($subject['student_marks']))
            {
                unset($personality_subjects[$key]);
            }
        }
 
 $attitude_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>5,'Subjects.is_deleted ='=>'N','Subjects.session_year_id'=>$sy_id]);
        
        $attitude_subjects = json_decode(json_encode($attitude_subjects->toArray()),true);
  
        foreach ($attitude_subjects as $key => $subject)
        { 
            if(empty($subject['student_marks']))
            {
                unset($attitude_subjects[$key]);
            }
        }
        $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    
        $success=true;
        $message='';
        print_r($marks);exit;
       
        $this->set(compact('success', 'message','sy_name','attitude_subjects','personality_subjects','ii','student','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
         $this->set('_serialize', ['success', 'message','sy_name','attitude_subjects','personality_subjects','ii','student','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att']); 
    }
}