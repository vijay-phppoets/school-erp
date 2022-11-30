<?php
namespace App\Controller\Api;
use App\Controller\Api;
use App\Controller\Api\AppController;
/**
 * ClassTests Controller
 *
 * @property \App\Model\Table\ClassTestsTable $ClassTests
 *
 * @method \App\Model\Entity\ClassTest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClassTestsController extends AppController
{ 
    public function addClassTest()
    {
        $user_type = $this->request->getData('user_type');
        if($user_type=='Employee'){
            $classTest = $this->ClassTests->newEntity();

            $currentSession = $this->AwsFile->currentSession();
            $user_id = $this->request->getData('user_id'); 
            $class_section_id = $this->request->getData('class_section_id');
            $student_id=$this->request->getData('student_info_id');
            $marks=$this->request->getData('marks');

            $data = $this->ClassTests->FacultyClassMappings->ClassMappings->find()->where(['ClassMappings.id'=>$class_section_id])->first();
            $medium_id = $data->medium_id;
            $student_class_id = $data->student_class_id;
            $stream_id = $data->stream_id;
            $section_id = $data->section_id; 

            $classTest = $this->ClassTests->patchEntity($classTest, $this->request->getData());
            $classTest->test_date=date('Y-m-d',strtotime($this->request->getData('test_date')));
            $classTest->session_year_id = $currentSession;
            $classTest->created_by = $user_id;
            if($medium_id){
                $classTest->medium_id = $medium_id;
            }
            if($student_class_id){
                $classTest->student_class_id = $student_class_id;
            }
            if($stream_id){
                $classTest->stream_id = $stream_id;
            }
            if($section_id){
                $classTest->section_id = $section_id;
            } 
            $classTest->class_test_students = [];
            $c=0;
            foreach ($student_id as $key=> $studentInfo) {
                 $assignmentStudents = $this->ClassTests->ClassTestStudents->newEntity();
                 $assignmentStudents->student_info_id=$studentInfo;
                 $assignmentStudents->created_by =$user_id;
                 $assignmentStudents->marks=$marks[$key];
                 $classTest->class_test_students[]=$assignmentStudents;
                 $c++;
            } 

            if($this->ClassTests->save($classTest)){
				
				$medium_id=$classTest->medium_id;
				$student_class_id=$classTest->student_class_id;
				$stream_id=$classTest->stream_id;
				$section_id=$classTest->section_id;
				$subject_id=$classTest->subject_id;
				
				$this->loadmodel('StudentInfos');
				$this->loadmodel('Users');
				 $condition=array();
                if($student_class_id){
                   $condition['StudentInfos.student_class_id']= $student_class_id; 
                }
                if($section_id){
                   $condition['StudentInfos.section_id']= $section_id; 
                }
                if($medium_id){
                   $condition['StudentInfos.medium_id']= $medium_id; 
                }
                if($stream_id){
                   $condition['StudentInfos.stream_id']= $stream_id; 
                }
					$StudentInfos=$this->StudentInfos->find()->where($condition);
					$this->loadmodel('Notifications');
					$Notifications=$this->Notifications->newEntity();
					$Notifications->title='Class Test';
					$Notifications->message=$classTest->topic;

					$Notifications->notify_date=date("Y-m-d");
					$Notifications->notify_time=date("h:i: A");
					$Notifications->status=0;
					$Notifications->created_by=$user_id;
					$this->Notifications->save($Notifications);
					
				foreach($StudentInfos as $studentInfo){
					$student_id=$studentInfo->student_id;
					$Usersdata=$this->Users->find()->where(['student_id'=>$student_id])->first();
					$NotificationRows=$this->Notifications->NotificationRows->newEntity();
					$NotificationRows->notification_id=$Notifications->id;
					$NotificationRows->user_id=$Usersdata->id;
					$NotificationRows->df_link='Alok://classtest?user_id='.$Usersdata->id.'&id='.$classTest->id;
					$NotificationRows->sent=0;
					$NotificationRows->status=0;
					$this->Notifications->NotificationRows->save($NotificationRows);
				}
				
				
                $class_test_id = $classTest->id;
                $success=true;
                $message="The class test has been saved.";
            }
            else{
                $class_test_id =0;
                $success=false;
                $message="Something went wrong.";
            }
        }
        else{
            $class_test_id =0;
            $success=false;
            $message="Something went wrong.";
        } 
        $this->set(compact('success', 'message','class_test_id'));
        $this->set('_serialize', ['success', 'message','class_test_id']); 
    }

    public function fillMarks($id = null)
    {
        $user_type = $this->request->getData('user_type');
        if($user_type=='Employee'){
             
            $currentSession = $this->AwsFile->currentSession();
            $user_id = $this->request->getData('user_id'); 
            $id = $this->request->getData('class_test_id');
            $student_id=$this->request->getData('student_info_id');
            $marks=$this->request->getData('marks');
            $x=0;
            $y=0;

            foreach ($student_id as $key=>$student) {
                $this->ClassTests->ClassTestStudents->deleteAll(['ClassTestStudents.class_test_id'=>$id,'ClassTestStudents.student_info_id'=>$student]);
                $classtestStudent = $this->ClassTests->ClassTestStudents->newEntity();
                $classtestStudent->student_info_id = $student;
                $classtestStudent->class_test_id = $id;
                $classtestStudent->created_by = $user_id;
                $classtestStudent->marks = $marks[$key];
                if ($this->ClassTests->ClassTestStudents->save($classtestStudent)){
                    $y=1;
                }
                $x++;
            }
            if($y == 1){
                $success=true;
                $message="Successfully submitted";
            } 
            else{
                $success=false;
                $message="Something went wrong.";
            }
         }
         else{
            $success=false;
            $message="Something went wrong.";  
         } 
         $this->set(compact('success', 'message'));
         $this->set('_serialize', ['success', 'message']);
    }

	public function classtestlistnew(){
		
		$employee_id = $this->request->getQuery('employee_id');
		$currentSession = $this->AwsFile->currentSession();
		$classTest=[];
		if(!empty($employee_id)){ 
		  
			$this->loadmodel('ClassMappings');
			$ClassMappings=$this->ClassMappings->find()->where(['ClassMappings.employee_id'=>$employee_id,'ClassMappings.session_year_id'=>$currentSession])->first();
			$class_id=$ClassMappings->student_class_id;
			$medium_id=$ClassMappings->medium_id;
			$stream_id=$ClassMappings->stream_id;
			$section_id=$ClassMappings->section_id;
			
			$classTest = $this->ClassTests->find()
                ->contain(['StudentClasses', 'Streams', 'Sections','Subjects'])
                ->where(['ClassTests.is_deleted'=>'N','ClassTests.session_year_id'=>$currentSession])
				->order(['ClassTests.id'=>'DESC']);
			           
			if(!empty($class_id)){
				$classTest->where(['ClassTests.student_class_id'=>$class_id]);
			}
			if(!empty($medium_id)){
				$classTest->where(['ClassTests.medium_id'=>$medium_id]);
			}
			if(!empty($section_id)){
				$classTest->where(['ClassTests.section_id'=>$section_id]);
			}
		   if(!empty($stream_id)){
				$classTest->where(['ClassTests.stream_id'=>$stream_id]);
			}
			if($classTest->toArray()){
				
				 $success=true;
			     $message='data found.';
				
			}else{
				 $success=false;
			     $message='No Data found';
			}
			
		  
		}else{
			 $success=false;
			 $message='empty employee id';
		 }
		 
		 $this->set(compact('success', 'message','classTest'));
         $this->set('_serialize', ['success', 'message','classTest']);  

		
		
		
	}


   public function classTestList(){
        $user_type = @$this->request->getQuery('user_type');
        $user_id = @$this->request->getQuery('user_id');
        $subject_id = @$this->request->getQuery('subject_id');
        $page = $this->request->getQuery('page');
        if($user_type=='Employee'){
            $classTest = $this->ClassTests->find()
                ->contain(['StudentClasses', 'Streams', 'Sections','Subjects'])
                ->where(['ClassTests.is_deleted'=>'N','ClassTests.created_by'=>$user_id])
                ->order(['ClassTests.id'=>'DESC'])->limit(10)->page($page);
            if($classTest->count()>0){
                $success=true;
                $message='';
            }else{
                $success=false;
                $message="No data found";
                $classTest=array();
            }
        }
        else if($user_type=='Student'){
            $currentSession = $this->AwsFile->currentSession();
            $student_data = $this->ClassTests->ClassTestStudents->StudentInfos->find()->select(['id'])->where(['StudentInfos.student_id'=>$user_id,'StudentInfos.session_year_id'=>$currentSession])->first();
            $student_info_id = $student_data->id;
            $classTest = $this->ClassTests->find()
                ->contain(['Subjects'])
                ->where(['ClassTests.is_deleted'=>'N']);
				if(!empty($subject_id)){
					$classTest->where(['ClassTests.subject_id'=>$subject_id]);
				}
            $classTest->matching('ClassTestStudents', function ($q)use($student_info_id) {
                return $q->where(['ClassTestStudents.student_info_id'=>$student_info_id]);
            });
            $classTest->order(['ClassTests.id'=>'DESC'])
                ->limit(10)
                ->page($page);

            if($classTest->count()>0){
                $success=true;
                $message='';
            }else{
                $success=false;
                $message="No data found";
                $classTest=array();
            }
        }
        else{
            $success=false;
            $message="No data found";
            $classTest=array();
        }
        
        $this->set(compact('success', 'message', 'classTest'));
        $this->set('_serialize', ['success', 'message', 'classTest']);  
    }


    public function classTestStudents(){
        $id = $this->request->getQuery('id'); 
        $classTestStudents = $this->ClassTests->find()
            /* ->contain(['StudentClasses', 'Streams', 'Sections','Subjects','ClassTestStudents'=>['StudentInfos'=>['Students']]]) */
			->contain(['StudentClasses', 'Streams', 'Sections','Subjects','ClassTestStudents'=>function($q){
					return $q->order(['Students.name'])->contain(['StudentInfos'=>['Students']]);
				}
			])
            ->where(['ClassTests.is_deleted'=>'N','ClassTests.id'=>$id])->first();
        
        if($classTestStudents){
            $success=true;
            $message='';
        }else{
            $success=false;
            $message="No data found";
            $classTestStudents=array();
        }
        
        $this->set(compact('success', 'message', 'classTestStudents'));
        $this->set('_serialize', ['success', 'message', 'classTestStudents']);  
        
    }
}
