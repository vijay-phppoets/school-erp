<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Attendances Controller
 *
 * @property \App\Model\Table\AttendancesTable $Attendances
 *
 * @method \App\Model\Entity\Attendance[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AttendancesController extends AppController
{
    
    public function initialize()
    {
        parent::initialize();
        //$this->loadComponent('Csrf');
    }
     public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
      //  $this->getEventManager()->off($this->Csrf);
        $this->Security->setConfig('unlockedActions', ['add','summaryAttendance']);
         
        

    }
	
	public function summaryReportDetail($date =null,$class_id=null,$section_id=null,$status=null)
   {
       if($status == "Firstpresent")
       {
          $attendances=$this->Attendances->find()
           ->contain(['StudentInfos'=>['Students','Mediums','StudentClasses','Sections'],'ClassMappings'=>['Employees']])
           ->where(['Attendances.attendance_date'=>$date,'StudentInfos.student_class_id'=>$class_id,'StudentInfos.section_id'=>$section_id,'Attendances.first_half' => 0.5])
           ->autoFields(true);
       }
       if($status == "Firstabsent")
       {
            $attendances=$this->Attendances->find()
           ->contain(['StudentInfos'=>['Students','Mediums','StudentClasses','Sections'],'ClassMappings'=>['Employees']])
           ->where(['Attendances.attendance_date'=>$date,'StudentInfos.student_class_id'=>$class_id,'StudentInfos.section_id'=>$section_id,'Attendances.first_half' => 0.0])->orwhere(['Attendances.attendance_date'=>$date,'StudentInfos.student_class_id'=>$class_id,'StudentInfos.section_id'=>$section_id,'Attendances.first_half' => 1.0])
           ->autoFields(true);
       }
       if($status == "Secondpresent")
       {
            $attendances=$this->Attendances->find()
           ->contain(['StudentInfos'=>['Students','Mediums','StudentClasses','Sections'],'ClassMappings'=>['Employees']])
           ->where(['Attendances.attendance_date'=>$date,'StudentInfos.student_class_id'=>$class_id,'StudentInfos.section_id'=>$section_id,'Attendances.second_half' => 0.5])
           ->autoFields(true);
       }
       if($status == "Secondabsent")
       {
            $attendances=$this->Attendances->find()
           ->contain(['StudentInfos'=>['Students','Mediums','StudentClasses','Sections'],'ClassMappings'=>['Employees']])
           ->where(['Attendances.attendance_date'=>$date,'StudentInfos.student_class_id'=>$class_id,'StudentInfos.section_id'=>$section_id,'Attendances.second_half' => 0.0])->orwhere(['Attendances.attendance_date'=>$date,'StudentInfos.student_class_id'=>$class_id,'StudentInfos.section_id'=>$section_id,'Attendances.second_half' => 1.0])
           ->autoFields(true);
       }
       //pr($attendances->toArray());exit;
       $this->set(compact('attendances','date','status'));
   }
	
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    public function summaryAttendance()
    {
        //pr($daterange);exit;
        if ($this->request->is(['post','put'])) 
        {
         $date=date('Y-m-d',strtotime($this->request->getData('date')));
         //pr($date);exit;
        }
        else
        {
            $date=date('Y-m-d');
           
        }
        //


        $attendances=$this->Attendances->find()
        ->contain(['Employees','StudentInfos'=>['Students','Mediums','StudentClasses','Sections'],'ClassMappings'=>['Employees']])
        ->where(['Attendances.attendance_date'=>$date])
        ->group(['StudentInfos.student_class_id','StudentInfos.medium_id','StudentInfos.section_id'])->autoFields(true);
        //pr($attendances->toArray());exit;

        $morning_p = $attendances->newExpr()
                ->addCase(
                    $attendances->newExpr()->add(['Attendances.first_half' => 0.5]),
                    1,
                    'integer'
                );
        $morning_a = $attendances->newExpr()
                ->addCase(
                    $attendances->newExpr()->add(['Attendances.first_half' => 0.0]),
                    1,
                    'integer'
                );

        $morning_a_1 = $attendances->newExpr()
                ->addCase(
                    $attendances->newExpr()->add(['Attendances.first_half' => 1]),
                    1,
                    'integer'
                );

        $evening_p = $attendances->newExpr()
                ->addCase(
                    $attendances->newExpr()->add(['Attendances.second_half' => 0.5]),
                    1,
                    'integer'
                );
        $evening_a = $attendances->newExpr()
                ->addCase(
                    $attendances->newExpr()->add(['Attendances.second_half' => 0.0]),
                    1,
                    'integer'
                );
        $evening_a_1 = $attendances->newExpr()
                ->addCase(
                    $attendances->newExpr()->add(['Attendances.second_half' => 1]),
                    1,
                    'integer'
                );

        $total_student = $attendances->newExpr()
                ->addCase(
                    $attendances->newExpr()->add(['Attendances.student_info_id']),
                    1,
                    'integer'
                );

            $attendances->select([
                'morning_p' => $attendances->func()->count($morning_p),
                'morning_a' => $attendances->func()->count($morning_a),
                'morning_a_1' => $attendances->func()->count($morning_a_1),
                'evening_p' => $attendances->func()->count($evening_p),
                'evening_a' => $attendances->func()->count($evening_a),
                'evening_a_1' => $attendances->func()->count($evening_a_1),
                'total_student' => $attendances->func()->count($total_student),
                'Attendances.student_info_id'
            ]);
      
        //pr($attendances->toArray());exit;

        $this->set(compact('attendances','date'));
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['SessionYears', 'Mediums', 'StudentClasses', 'Streams', 'Sections', 'StudentInfos']
        ];
        $attendances = $this->paginate($this->Attendances);

        $this->set(compact('attendances'));
    }

 public function attendanceReport()
    {
        //$attendances=$this->Attendances->find()->where(['id'=>1]);

        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $i=1;
            $medium_id=$this->request->getData('medium_id');
            $student_months=$this->request->getData('student_months');
            $student_class_id=$this->request->getData('student_class_id');
            //pr($student_class_id);exit;
            $section_id=$this->request->getData('section_id');
           // $month1=explode('-', $student_months);
            $year="2019";
           $F_date=$student_months.'-01';
           $first_date=date('Y-m-d',strtotime($F_date));
           $last_date=date('Y-m-t',strtotime($F_date));
           
            // if(!empty($student_months))
            // {
            //     $attendances=$this->Attendances->find()->where(['Attendances.attendance_date LIKE'=>'%'.$student_months.'%'])->contain(['StudentInfos'=>['Students']])->group(['Attendances.student_info_id']);
            // }

            if((!empty($medium_id))&&(!empty($student_months))&&(!empty($student_class_id))&&(!empty($section_id)))
            {
                @$no_month=cal_days_in_month(CAL_GREGORIAN,$student_months,2019);


               
                $attendances=$this->Attendances->find()
                ->where(['StudentInfos.medium_id'=>$medium_id,'StudentInfos.student_class_id'=>$student_class_id,'StudentInfos.section_id'=>$section_id,'Attendances.attendance_date >=' => $first_date,'Attendances.attendance_date <=' => $last_date])
                ->contain(['StudentInfos'=>['Students','Mediums','StudentClasses','Sections']])
                ;
               $AttendancesFirstHalf=array();
               $AttendancesSecondHalf=array();
               $studenlist=array();
               foreach ($attendances as $attendance) { 
                    $Date=date('d-m-y',strtotime($attendance->attendance_date));
					//pr($Date);
                      // $attendance_status=$attendance->attendance_status;
                       $AttendancesFirstHalf[$attendance->student_info->student_id][$Date]=$attendance->first_half;
                      
                       $AttendancesSecondHalf[$attendance->student_info->student_id][$Date]=$attendance->second_half;

                       $studenlist[$attendance->student_info->student_id]=['student_name'=>$attendance->student_info->student->name,'father_name'=>$attendance->student_info->student->father_name,'scoler_no'=>$attendance->student_info->student->scholar_no];
                  
               }
               //    pr($AttendancesFirstHalf); exit;
                  //  pr($AttendancesSecondHalf); exit;



               //  $attendances=$this->Attendances->find()
               //  ->where(['StudentInfos.medium_id'=>$medium_id,'StudentInfos.student_class_id'=>$student_class_id,'StudentInfos.section_id'=>$section_id,'Attendances.attendance_date LIKE'=>'2019-'.$student_months.'-%'])
               //  ->contain(['StudentInfos'=>['Students','Mediums','StudentClasses','Sections']])
               //  ->group(['StudentInfos.student_id']);

               //  //pr($attendances->toArray());exit;

               //  foreach ($attendances as $key =>$data) {
               //      //pr($val->attendance_date);exit;
               //      for ($a = 1; $a <= $no_month; $a++) {

                        


               //      }

               // }

            }


           
        }

        $mediums=$this->Attendances->StudentInfos->Mediums->find('list')->where(['Mediums.is_deleted'=>'N']);
        $sections=$this->Attendances->StudentInfos->Sections->find('list')->where(['Sections.is_deleted'=>'N']);
        $classes=$this->Attendances->StudentInfos->StudentClasses->find('list')->where(['StudentClasses.is_deleted'=>'N']);
        $holidays=$this->Attendances->Holidays->find()->where(['Holidays.is_deleted'=>'N']);
      // pr($holidays->toArray());die;
        
        $this->set(compact('attendances','mediums','sections','month','classes','show_med','show_class','show_sec','student_months','query','no_month','AttendancesSecondHalf','AttendancesFirstHalf','first_date','last_date','F_date','studenlist','holidays'));
    }
  /*  public function attendanceReport()
    {
        //$attendances=$this->Attendances->find()->where(['id'=>1]);

        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $i=1;
            $medium_id=$this->request->getData('medium_id');
            $student_months=$this->request->getData('student_months');
            $student_class_id=$this->request->getData('student_class_id');
            //pr($student_class_id);exit;
            $section_id=$this->request->getData('section_id');
           // $month1=explode('-', $student_months);
            $year="2019";
           $F_date=$year.'-'.$student_months.'-01';
           $first_date=date('Y-m-d',strtotime($F_date));
           $last_date=date('Y-m-t',strtotime($F_date));
           
            // if(!empty($student_months))
            // {
            //     $attendances=$this->Attendances->find()->where(['Attendances.attendance_date LIKE'=>'%'.$student_months.'%'])->contain(['StudentInfos'=>['Students']])->group(['Attendances.student_info_id']);
            // }

            if((!empty($medium_id))&&(!empty($student_months))&&(!empty($student_class_id))&&(!empty($section_id)))
            {
                @$no_month=cal_days_in_month(CAL_GREGORIAN,$student_months,2019);


               
                $attendances=$this->Attendances->find()
                ->where(['StudentInfos.medium_id'=>$medium_id,'StudentInfos.student_class_id'=>$student_class_id,'StudentInfos.section_id'=>$section_id,'Attendances.attendance_date >=' => $first_date,'Attendances.attendance_date <=' => $last_date])
                ->contain(['StudentInfos'=>['Students','Mediums','StudentClasses','Sections']])
                ;
               $AttendancesFirstHalf=array();
               $AttendancesSecondHalf=array();
               $studenlist=array();
               foreach ($attendances as $attendance) { 
                    $Date=strtotime($attendance->attendance_date);
                      // $attendance_status=$attendance->attendance_status;
                       $AttendancesFirstHalf[$attendance->student_info->student_id][$Date]=$attendance->first_half;
                      
                       $AttendancesSecondHalf[$attendance->student_info->student_id][$Date]=$attendance->second_half;

                       $studenlist[$attendance->student_info->student_id]=['student_name'=>$attendance->student_info->student->name,'father_name'=>$attendance->student_info->student->father_name,'scoler_no'=>$attendance->student_info->student->scholar_no];
                  
               }
                    //pr($studenlist); exit;



               //  $attendances=$this->Attendances->find()
               //  ->where(['StudentInfos.medium_id'=>$medium_id,'StudentInfos.student_class_id'=>$student_class_id,'StudentInfos.section_id'=>$section_id,'Attendances.attendance_date LIKE'=>'2019-'.$student_months.'-%'])
               //  ->contain(['StudentInfos'=>['Students','Mediums','StudentClasses','Sections']])
               //  ->group(['StudentInfos.student_id']);

               //  //pr($attendances->toArray());exit;

               //  foreach ($attendances as $key =>$data) {
               //      //pr($val->attendance_date);exit;
               //      for ($a = 1; $a <= $no_month; $a++) {

                        


               //      }

               // }

            }


           
        }

        $mediums=$this->Attendances->StudentInfos->Mediums->find('list')->where(['Mediums.is_deleted'=>'N']);
        $sections=$this->Attendances->StudentInfos->Sections->find('list')->where(['Sections.is_deleted'=>'N']);
        $classes=$this->Attendances->StudentInfos->StudentClasses->find('list')->where(['StudentClasses.is_deleted'=>'N']);
       

        $this->set(compact('attendances','mediums','sections','month','classes','show_med','show_class','show_sec','student_months','query','no_month','AttendancesSecondHalf','AttendancesFirstHalf','first_date','last_date','F_date','studenlist'));
    }
*/
    /**
     * View method
     *
     * @param string|null $id Attendance id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $attendance = $this->Attendances->get($id, [
            'contain' => ['SessionYears', 'Mediums', 'StudentClasses', 'Streams', 'Sections', 'StudentInfos']
        ]);

        $this->set('attendance', $attendance);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user_id = $this->Auth->User('id');
        $session_year_id = $this->Auth->User('session_year_id');
        if ($this->request->is('get'))
        {
            $where=[];
            $attendance_date= date('Y-m-d',strtotime($this->request->getQuery('attendance_date')));
			$holidays_days=$this->Attendances->Holidays->find()->where(['date'=>$attendance_date]);
			
            $medium_id = $this->request->getQuery('medium_id');
            if(!empty($medium_id)){
               $where['StudentInfos.medium_id'] = $medium_id; 
			   $Mediumsdata=$this->Attendances->StudentInfos->Mediums->get($medium_id);
			   $medium_name=$Mediumsdata->name;
            }
            $student_class_id = $this->request->getQuery('student_class_id');
            if(!empty($student_class_id)){
               $where['StudentInfos.student_class_id'] = $student_class_id; 
			   $StudentClassdata=$this->Attendances->StudentInfos->StudentClasses->get($student_class_id);
			   $class_name=$StudentClassdata->name;
            }
            $stream_id = $this->request->getQuery('stream_id');
            if(!empty($stream_id)){
               $where['StudentInfos.stream_id'] = $stream_id; 
			    $Streamsdata=$this->Attendances->StudentInfos->Streams->get($stream_id);
			    $stream_name=$Streamsdata->name;
            }
            $section_id = $this->request->getQuery('section_id');
            if(!empty($section_id)){
               $where['StudentInfos.section_id'] = $section_id; 
			   $Sectionsdata=$this->Attendances->StudentInfos->Sections->get($section_id);
			    $section_name=$Sectionsdata->name;
            }

            $optradio = $this->request->getQuery('optradio'); 
            $attendancesDatas = $this->Attendances->StudentInfos->find()->where(['student_status'=>'Continue'])
            ->contain(['Students','Attendances'=>function($q)use($attendance_date){
                return $q->where(['attendance_date'=>$attendance_date]);
            }])
            ->where($where)->order(['Students.name'=>'ASC']);
            //pr($attendancesDatas->toArray());exit;
			
			
        }
        $attendance = $this->Attendances->newEntity();
		$medium_id = $this->request->getQuery('medium_id');
        $stream_id = $this->request->getQuery('stream_id');
        $section_id = $this->request->getQuery('section_id');
        $student_class_id = $this->request->getQuery('student_class_id');	
        if ($this->request->is('post')) {
		$mappings=$this->Attendances->ClassMappings->find()
        ->where(['ClassMappings.medium_id'=>$medium_id,'ClassMappings.stream_id'=>$stream_id,'ClassMappings.section_id'=>$section_id,'ClassMappings.student_class_id'=>$student_class_id])->toArray();  
            $attendance_date= date('Y-m-d',strtotime($this->request->getQuery('attendance_date')));
            $student_info_id=$this->request->getData('student_info_id');
            $attendanceData=$this->request->getData('attendance');
            $attendance_id=$this->request->getData('attendance_id');
            $optradio=$this->request->getData('optradio');
           
            $x=0;
            foreach ($student_info_id as $student_id) {
                if(@$attendance_id[$student_id]){
                    $attendance = $this->Attendances->get($attendance_id[$student_id], [
                        'contain' => []
                    ]);
                    $attendance->edited_by = $user_id; 
                }
                else{
                    $attendance = $this->Attendances->newEntity();
                    $attendance->created_by = $user_id; 
                }
                $attendance->attendance_date=$attendance_date;
                $attendance->student_info_id = $student_id; 
                $attendance->session_year_id = $session_year_id; 
				$attendance->class_mapping_id = $mappings[0]['id']; 
                if($optradio=='first'){
                    echo $attendance->first_half = $attendanceData[$x];
					if($attendanceData[$x]=="0.5"){
						$check="Present";
					}else{
						
						$check="Absent";
					}
                }
                else{
                    $attendance->second_half = $attendanceData[$x];
					if($attendanceData[$x]=="0.5"){
						$check="Present";
					}else{
						
						$check="Absent";
					}
                }
                //-Save
					$this->loadmodel('StudentInfos');
				$StudentInfos=$this->StudentInfos->get($student_id,['contain'=>['Users','Students']]);
				$name=$StudentInfos->student->name; 
				$device_token=$StudentInfos->user->device_token;
				$title="Attendance";
				$message="Your ward is ".$check."";
				 if(!empty($device_token)){
							
								$tokens = array($device_token);

								$header = [
								'Content-Type:application/json',
								'Authorization: Key=AAAA8Hq2jLc:APA91bEz42EHdwNVDAF5SdL1oKqDQrnVWU2-kIJu_YsIjF93SSHeLWqajg3qyvaJRZ1l9P4QJJWiyvS51djw-Bc1nP_o4P8kfNqruRYIn_13dxWAEd8RkWGHkopgSQbHp1jt5AqW6hrs'
								];

								$msg = [
								'title'=> $title,
								'message' => $message,
								
								'link' =>'Alok://home'
								];

								$payload = array(
								'registration_ids' => $tokens,
								'data' => $msg
								);

								$curl = curl_init();
								curl_setopt_array($curl, array(
								CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_CUSTOMREQUEST => "POST",
								CURLOPT_POSTFIELDS => json_encode($payload),
								CURLOPT_HTTPHEADER => $header
								));
								$response = curl_exec($curl);
								$err = curl_error($curl);
								curl_close($curl);
								//pr($response);die;
								$final_result=json_decode($response);
								$sms_flag=$final_result->success;     
								if ($err) {
									//echo "cURL Error #:" . $err;
								} else {
									//echo $response;
								}            
									
						}  
				
                $this->Attendances->save($attendance);

                $x++;
            } 
                return $this->redirect(['action' => 'add']);
            }
        $mediums = $this->Attendances->StudentInfos->Mediums->find('list', ['limit' => 200])->where(['Mediums.is_deleted'=>'N']);
         
        $this->set(compact('attendance', 'mediums','attendancesDatas','optradio','class_name','stream_name','section_name','medium_name','holidays_days'));
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Attendance id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $attendance = $this->Attendances->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attendance = $this->Attendances->patchEntity($attendance, $this->request->getData());
            if ($this->Attendances->save($attendance)) {
                $this->Flash->success(__('The attendance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The attendance could not be saved. Please, try again.'));
        }
        $sessionYears = $this->Attendances->SessionYears->find('list', ['limit' => 200]);
        $media = $this->Attendances->Media->find('list', ['limit' => 200]);
        $studentClasses = $this->Attendances->StudentClasses->find('list', ['limit' => 200]);
        $streams = $this->Attendances->Streams->find('list', ['limit' => 200]);
        $sections = $this->Attendances->Sections->find('list', ['limit' => 200]);
        $studentInfos = $this->Attendances->StudentInfos->find('list', ['limit' => 200]);
        $this->set(compact('attendance', 'sessionYears', 'media', 'studentClasses', 'streams', 'sections', 'studentInfos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Attendance id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attendance = $this->Attendances->get($id);
        if ($this->Attendances->delete($attendance)) {
            $this->Flash->success(__('The attendance has been deleted.'));
        } else {
            $this->Flash->error(__('The attendance could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
