<?php
namespace App\Controller;
use Cake\Event\Event;
use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

ini_set('memory_limit', '90000M');

/**photo
 * StudentMarks Controller
 *
 * @property \App\Model\Table\StudentMarksTable $StudentMarks
 *
 * @method \App\Model\Entity\StudentMark[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StudentMarksController extends AppController
{
    private $array = [];
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if ($this->request->getParam('_ext') == 'json') 
        {
            $this->Security->setConfig('unlockedActions', [$this->request->getParam('action')]);
        }

        $this->Security->setConfig('unlockedActions', ['add','excelDownload','excelUpload','markSheet','getParentExams','printattendanceLists','printAttendanceList','admitCard']);
    }

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logout','markSheetScholar','viewMarkSheet1Web','viewMarkSheetxiWeb','viewMarkSheetixxWeb']);        
       
        header('Content-type: text/html');
        header('Access-Control-Allow-Origin: *'); 
    }
	
	public function uploadForms(){
		echo "hello";
		 if($this->request->is('post'))
        {
			echo "Vijay";
		}
		exit;
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    /* public function index()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if($this->request->is('post'))
        {
            $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'));
            
            $where['student_class_id'] = $class_mapping->student_class_id;
            $where['stream_id'] = $class_mapping->stream_id;

            $exam_master_id[] = $this->request->getData('exam_master_id');

            $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id[0]]);

            if(!empty($children->toArray()))
                foreach ($children as $key => $child)
                    $exam_master_id[] = $child->id;

            $subject_id = $this->request->getData('subject_id');
            
            if (!empty($subject_id))
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where(['id IN'=>$subject_id,'Subjects.subject_type_id' => 1]);
            else
            {
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N']);

                $subject_ids = $this->StudentMarks->Subjects->find()->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N']);
            }

            if (!empty($subject_id)){}
            else
            {
                $subject_id =[];
                foreach ($subject_ids as $key => $sub)
                    $subject_id [] = $sub->id;
            }

            $condition = implode(' AND ',$this->array_map_assoc(function($k,$v){return "$k = $v";},$where));
            $exams = $this->StudentMarks->ExamMasters->find('threaded')->contain(['SubExams'])->where(['id IN'=>$exam_master_id]);

            $conn = ConnectionManager::get('default');

            $stmt = $conn->execute("SELECT 
            students.name,
            student_infos.id As student_info_id, 
            exam_masters.id,
            exam_masters.name As exam,
            sub_exams.name as sub_exam,
            sub_exams.id as sub_exam_id,
            subjects.name As subject,
            subjects.id As subject_id,
            student_marks.student_number,
            exam_masters.max_marks,
            sub_exams.max_marks As sub_max,
            IF(sub_exams.id,1,0) as save_to
            FROM student_infos

            INNER JOIN students ON student_infos.student_id = students.id
            AND ".$condition." AND student_infos.section_id = ".$class_mapping->section_id."

            LEFT JOIN subjects ON subjects.student_class_id = student_infos.student_class_id 
            AND subjects.stream_id = student_infos.stream_id 
            AND subjects.rght-subjects.lft=1  
            AND subjects.subject_type_id = 1
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."

            LEFT JOIN exam_masters ON subjects.student_class_id = exam_masters.student_class_id 
            AND subjects.stream_id = exam_masters.stream_id 
            AND exam_masters.rght-exam_masters.lft=1
            AND exam_masters.id IN (".implode(',',$exam_master_id).")

            LEFT JOIN sub_exams ON sub_exams.exam_master_id = exam_masters.id

            LEFT JOIN student_marks ON (student_marks.exam_master_id = exam_masters.id OR student_marks.sub_exam_id = sub_exams.id)
            AND student_marks.student_info_id = student_infos.id 
            AND student_marks.subject_id = subjects.id 
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."

            ORDER BY student_infos.id ASC,exam_masters.order_number,sub_exams.id,subjects.order_number;");
            $students = $stmt->fetchAll('assoc');

            $subjects = json_decode(json_encode($subjects->toArray()),true);
            $exams = json_decode(json_encode($exams->toArray()),true);

            foreach ($students as $key => $student) {
                if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']]))
                    $students[$key]['max_marks'] = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()->where(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']])->first()->max_marks;
            }
            //pr($students);exit;
        }
        
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }

        $this->set(compact('studentMarks','studentMark','subjects','exams','students','classMappings'));
    }
 */
 /* public function index()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if($this->request->is('post'))
        {
            $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'));
            
            $where['student_class_id'] = $class_mapping->student_class_id;
            $where['stream_id'] = $class_mapping->stream_id;
            $exam_master_id[] = $this->request->getData('exam_master_id');
            $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id[0]]);
            if(!empty($children->toArray()))
                foreach ($children as $key => $child)
                    $exam_master_id[] = $child->id;
            $subject_id = $this->request->getData('subject_id');
            
            if (!empty($subject_id))
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where(['id IN'=>$subject_id,'Subjects.subject_type_id' => 1]);
            else
            {
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N']);
                $subject_ids = $this->StudentMarks->Subjects->find()->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N']);
            }
            if (!empty($subject_id)){}
            else
            {
                $subject_id =[];
                foreach ($subject_ids as $key => $sub)
                    $subject_id [] = $sub->id;
            }
            $condition = implode(' AND ',$this->array_map_assoc(function($k,$v){return "$k = $v";},$where));
            $exams = $this->StudentMarks->ExamMasters->find('threaded')->contain(['SubExams'])->where(['id IN'=>$exam_master_id]);
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute("SELECT 
            students.name,
            student_infos.id As student_info_id, 
            student_infos.roll_no As roll_no, 
            exam_masters.id,
            exam_masters.name As exam,
            sub_exams.name as sub_exam,
            sub_exams.id as sub_exam_id,
            subjects.name As subject,
            subjects.id As subject_id,
            student_marks.student_number,
            exam_masters.max_marks,
            sub_exams.max_marks As sub_max,
            IF(sub_exams.id,1,0) as save_to
            FROM student_infos
            INNER JOIN students ON student_infos.student_id = students.id
            AND ".$condition." AND student_infos.section_id = ".$class_mapping->section_id."
            LEFT JOIN subjects ON subjects.student_class_id = student_infos.student_class_id 
            AND subjects.stream_id = student_infos.stream_id 
            AND subjects.rght-subjects.lft=1  
            AND subjects.subject_type_id = 1
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."
            LEFT JOIN exam_masters ON subjects.student_class_id = exam_masters.student_class_id 
            AND subjects.stream_id = exam_masters.stream_id 
            AND exam_masters.rght-exam_masters.lft=1
            AND exam_masters.id IN (".implode(',',$exam_master_id).")
            LEFT JOIN sub_exams ON sub_exams.exam_master_id = exam_masters.id
            LEFT JOIN student_marks ON (student_marks.exam_master_id = exam_masters.id OR student_marks.sub_exam_id = sub_exams.id)
            AND student_marks.student_info_id = student_infos.id 
            AND student_marks.subject_id = subjects.id 
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."
            ORDER BY student_infos.roll_no ASC,exam_masters.order_number,sub_exams.id,subjects.order_number;");
            $students = $stmt->fetchAll('assoc');
            //pr($students);exit;
            $subjects = json_decode(json_encode($subjects->toArray()),true);
            $exams = json_decode(json_encode($exams->toArray()),true);
            foreach ($students as $key => $student) {
                if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']]))
                    $students[$key]['max_marks'] = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()->where(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']])->first()->max_marks;
            }
            //pr($students);exit;
        }
        
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('studentMarks','studentMark','subjects','exams','students','classMappings'));
    } */
    public function passfailreport()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if($this->request->is('post'))
        {
            $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'),['contain'=>['StudentClasses','Sections','Streams','Mediums']]);
           
            $where['student_class_id'] = $class_mapping->student_class_id;
            $where['stream_id'] = $class_mapping->stream_id;
            $exam_master_id[] = $this->request->getData('exam_master_id');
            $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id[0]]);
            if(!empty($children->toArray()))
                foreach ($children as $key => $child)
                    $exam_master_id[] = $child->id;
            $subject_id = $this->request->getData('subject_id');
            
            if (!empty($subject_id))
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where(['id IN'=>$subject_id,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N'])->order(['Subjects.order_number'=>'ASC']);
            else
            {
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N'])->order(['Subjects.order_number'=>'ASC']);;
                $subject_ids = $this->StudentMarks->Subjects->find()->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N'])->order(['Subjects.order_number'=>'ASC']);
            }
            if (!empty($subject_id)){}
            else
            {
                $subject_id =[];
                foreach ($subject_ids as $key => $sub)
                    $subject_id [] = $sub->id;
            }
            $condition = implode(' AND ',$this->array_map_assoc(function($k,$v){return "$k = $v";},$where));
            $exams = $this->StudentMarks->ExamMasters->find('threaded')->contain(['SubExams'])->where(['id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N'])->order(['ExamMasters.order_number'=>'ASC']);
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute("SELECT 
            students.name, 
            student_infos.id As student_info_id, 
            student_infos.roll_no As roll_no, 
            exam_masters.id,
            exam_masters.name As exam,
            sub_exams.name as sub_exam,
            sub_exams.id as sub_exam_id,
            subjects.name As subject,
            subjects.id As subject_id,
            student_marks.student_number,
            exam_masters.max_marks,
            sub_exams.max_marks As sub_max,
            IF(sub_exams.id,1,0) as save_to
            FROM student_infos
            INNER JOIN students ON student_infos.student_id = students.id
            AND ".$condition." AND student_infos.section_id = ".$class_mapping->section_id." AND student_infos.session_year_id = ".$this->Auth->user('session_year_id')." AND 'StudentInfos.student_status'=>'Continue'
            LEFT JOIN subjects ON subjects.student_class_id = student_infos.student_class_id 
            AND subjects.stream_id = student_infos.stream_id 
            AND subjects.rght-subjects.lft=1  
            AND subjects.subject_type_id = 1
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.$subject_id.')':'')."
            LEFT JOIN exam_masters ON subjects.student_class_id = exam_masters.student_class_id 
            AND subjects.stream_id = exam_masters.stream_id 
            AND exam_masters.rght-exam_masters.lft=1
            AND exam_masters.id IN (".implode(',',$exam_master_id).")
            LEFT JOIN sub_exams ON sub_exams.exam_master_id = exam_masters.id
            LEFT JOIN student_marks ON (student_marks.exam_master_id = exam_masters.id OR student_marks.sub_exam_id = sub_exams.id)
            AND student_marks.student_info_id = student_infos.id 
            AND student_marks.subject_id = subjects.id 
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.$subject_id.')':'')."
            ORDER BY student_infos.roll_no ASC,exam_masters.order_number,sub_exams.id,subjects.order_number;");
            $students = $stmt->fetchAll('assoc');
            //pr($students);exit;
            $subjects = json_decode(json_encode($subjects->toArray()),true);
            $exams = json_decode(json_encode($exams->toArray()),true);
            foreach ($students as $key => $student) {
                if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']]))
                    $students[$key]['max_marks'] = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()->where(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']])->first()->max_marks;
            }
            //pr($students);exit;
        }
        
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('studentMarks','studentMark','subjects','exams','students','classMappings','class_mapping'));
    }
    public function passfailreportnew()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if($this->request->is('post'))
        {
            $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'),['contain'=>['StudentClasses','Sections','Streams','Mediums']]);
           
            $where['student_class_id'] = $class_mapping->student_class_id;
            $where['stream_id'] = $class_mapping->stream_id;
            $exam_master_id[] = $this->request->getData('exam_master_id');
			$session_year_id = $this->Auth->user('session_year_id');
            $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id[0]])->where(['ExamMasters.session_year_id'=>$session_year_id]);
            if(!empty($children->toArray()))
                foreach ($children as $key => $child)
                    $exam_master_id[] = $child->id;
            $subject_id = $this->request->getData('subject_id');
            
            if (!empty($subject_id))
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where(['id IN'=>$subject_id,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N','Subjects.session_year_id'=>$session_year_id])->order(['Subjects.order_number'=>'ASC']);
            else
            {
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N','Subjects.session_year_id'=>$session_year_id])->order(['Subjects.order_number'=>'ASC']);;
                $subject_ids = $this->StudentMarks->Subjects->find()->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N','Subjects.session_year_id'=>$session_year_id])->order(['Subjects.order_number'=>'ASC']);
            }
            if (!empty($subject_id)){}
            else
            {
                $subject_id =[];
                foreach ($subject_ids as $key => $sub)
                    $subject_id [] = $sub->id;
            }
            $condition = implode(' AND ',$this->array_map_assoc(function($k,$v){return "$k = $v";},$where));
            $exams = $this->StudentMarks->ExamMasters->find('threaded')->contain(['SubExams'])->where(['id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N','ExamMasters.session_year_id'=>$session_year_id])->order(['ExamMasters.order_number'=>'ASC']);
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute("SELECT 
            students.name, 
            student_infos.id As student_info_id, 
            student_infos.roll_no As roll_no, 
            exam_masters.id,
            exam_masters.name As exam,
			exam_masters.number_of_best As number_of_best,
            sub_exams.name as sub_exam,
            sub_exams.id as sub_exam_id,
            subjects.name As subject,
            subjects.id As subject_id,
            student_marks.student_number,
            exam_masters.max_marks,
            sub_exams.max_marks As sub_max,
            IF(sub_exams.id,1,0) as save_to
            FROM student_infos
            INNER JOIN students ON student_infos.student_id = students.id
            AND ".$condition." AND student_infos.section_id = ".$class_mapping->section_id." AND student_infos.session_year_id = ".$this->Auth->user('session_year_id')." AND 	student_infos.student_status='Continue'
            LEFT JOIN subjects ON subjects.student_class_id = student_infos.student_class_id 
            AND subjects.stream_id = student_infos.stream_id 
            AND subjects.rght-subjects.lft=1  
            AND subjects.subject_type_id = 1
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."
            LEFT JOIN exam_masters ON subjects.student_class_id = exam_masters.student_class_id 
            AND subjects.stream_id = exam_masters.stream_id 
            AND exam_masters.rght-exam_masters.lft=1
            AND exam_masters.id IN (".implode(',',$exam_master_id).")
            LEFT JOIN sub_exams ON sub_exams.exam_master_id = exam_masters.id
            LEFT JOIN student_marks ON (student_marks.exam_master_id = exam_masters.id OR student_marks.sub_exam_id = sub_exams.id)
            AND student_marks.student_info_id = student_infos.id 
            AND student_marks.subject_id = subjects.id 
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."
            ORDER BY student_infos.roll_no ASC,exam_masters.order_number,sub_exams.id,subjects.order_number;");
            $students = $stmt->fetchAll('assoc');
            //pr($students);exit;
            $subjects = json_decode(json_encode($subjects->toArray()),true);
            $exams = json_decode(json_encode($exams->toArray()),true);
            foreach ($students as $key => $student) {
                if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']]))
                    $students[$key]['max_marks'] = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()->where(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']])->first()->max_marks;
            }
            //pr($students);exit;
        }
        
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('studentMarks','studentMark','subjects','exams','students','classMappings','class_mapping'));
    }
	public function consoladated()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if($this->request->is('post'))
        {
            $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'),['contain'=>['StudentClasses','Sections','Streams','Mediums']]);
           
            $where['student_class_id'] = $class_mapping->student_class_id;
            $student_class_id = $class_mapping->student_class_id;
            $where['stream_id'] = $class_mapping->stream_id;
           $exam_master_id =$this->request->getData('exam_master_id');
		  // pr($exam_master_id);die;
         //   $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id[0]]);
			//pr($exam_master_id);die;
        //    if(!empty($children->toArray()))
           //     foreach ($children as $key => $child)
              //      $exam_master_id[] = $child->id;
			  $last=$this->request->getData('last');
			   if(@$last == 0)
        {
            $children = $this->StudentMarks->ExamMasters->find('children', ['for' =>$exam_master_id]);
			if($student_class_id==1 or $student_class_id==2 or $student_class_id==3 or $student_class_id==4 or $student_class_id==5 ){
				if($exam_master_id==133 or $exam_master_id==134 or $exam_master_id==135 or $exam_master_id==136 or $exam_master_id==137)
				{
				$children = $this->StudentMarks->ExamMasters->find()->where(['ExamMasters.id'=>$exam_master_id]);
				} 
			}
        }
      else{  
            $children = $this->StudentMarks->ExamMasters->find()->where([@$where])->order(['ExamMasters.order_number'=>'ASC']);
          }  
 // pr($children->toArray());die;
        if(!empty($children->toArray()))
        {
            $old_exam_master_id = $this->request->getData('exam_master_id');
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
         //  pr($exam_master_id);die;
            $subject_id = $this->request->getData('subject_id');
            
            if (!empty($subject_id))
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where(['id IN'=>$subject_id,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N'])->order(['Subjects.order_number'=>'ASC']);
            else
            {
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N'])->order(['Subjects.order_number'=>'ASC']);;
                $subject_ids = $this->StudentMarks->Subjects->find()->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N'])->order(['Subjects.order_number'=>'ASC']);
            }
            if (!empty($subject_id)){}
            else
            {
                $subject_id =[];
                foreach ($subject_ids as $key => $sub)
                    $subject_id [] = $sub->id;
            }
            $condition = implode(' AND ',$this->array_map_assoc(function($k,$v){return "$k = $v";},$where));
            $exams = $this->StudentMarks->ExamMasters->find('threaded')->contain(['SubExams'])->where(['id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N'])->order(['ExamMasters.order_number'=>'ASC']);
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute("SELECT 
            students.name, 
            student_infos.id As student_info_id, 
            student_infos.roll_no As roll_no, 
            exam_masters.id,
            exam_masters.name As exam,
            sub_exams.name as sub_exam,
            sub_exams.id as sub_exam_id,
            subjects.name As subject,
            subjects.id As subject_id,
            student_marks.student_number,
            exam_masters.max_marks,
			exam_masters.name As examname,
            exam_masters.number_of_best,
            sub_exams.max_marks As sub_max,
            IF(sub_exams.id,1,0) as save_to
            FROM student_infos
            INNER JOIN students ON student_infos.student_id = students.id
            AND ".$condition." AND student_infos.section_id = ".$class_mapping->section_id." AND student_infos.session_year_id = ".$this->Auth->user('session_year_id')." AND 	student_infos.student_status='Continue'
            LEFT JOIN subjects ON subjects.student_class_id = student_infos.student_class_id 
            AND subjects.stream_id = student_infos.stream_id 
            AND subjects.rght-subjects.lft=1  
            AND subjects.subject_type_id = 1
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."
            LEFT JOIN exam_masters ON subjects.student_class_id = exam_masters.student_class_id 
            AND subjects.stream_id = exam_masters.stream_id 
            AND exam_masters.rght-exam_masters.lft=1
            AND exam_masters.id IN (".implode(',',$exam_master_id).")
            LEFT JOIN sub_exams ON sub_exams.exam_master_id = exam_masters.id
            LEFT JOIN student_marks ON (student_marks.exam_master_id = exam_masters.id OR student_marks.sub_exam_id = sub_exams.id)
            AND student_marks.student_info_id = student_infos.id 
            AND student_marks.subject_id = subjects.id 
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."
            ORDER BY student_infos.roll_no ASC,exam_masters.order_number,sub_exams.id,subjects.order_number;");
            $students = $stmt->fetchAll('assoc');
            //pr($students);exit;
            $subjects = json_decode(json_encode($subjects->toArray()),true);
            $exams = json_decode(json_encode($exams->toArray()),true);
            foreach ($students as $key => $student) {
                if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']]))
                    $students[$key]['max_marks'] = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()->where(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']])->first()->max_marks;
            }
            //pr($students);exit;
        }
        
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('studentMarks','studentMark','subjects','exams','students','classMappings','class_mapping'));
    }
  
  /*    public function admitCard($room_no=null,$exam_hide=null)
    {
        if ($this->request->is('post')) {  
            $exam_id    = $this->request->getData('exam_id');
            $rollNos    = array_filter(($this->request->getData('rollno')));
            $exam       = $this->StudentMarks->StudentInfos->StudentClasses->ExamMasters->find('threaded')
                            ->where(['ExamMasters.id'=>$exam_id]);
            if(sizeof($rollNos)>0)
            {
                $students =  $this->StudentMarks->StudentInfos->find()->contain(['Sections','Students','StudentClasses'])
                                ->where(['StudentInfos.roll_no IN'=>$rollNos])->order(['StudentInfos.roll_no'=>'ASC']);
            }
            
        }
        $this->set(compact('students','exam','room_no','exam_hide'));
    }*/
    public function admitCard($room_no=null,$exam_hide=null,$exam_master_id=null)
    {
        if ($this->request->is('post')) {  
            $exam_id    = $this->request->getData('exam_id');
            $rollNos    = array_filter(($this->request->getData('rollno')));
            $exam  = $this->StudentMarks->StudentInfos->StudentClasses->ExamMasters->find('threaded')
                            ->where(['ExamMasters.id'=>$exam_master_id]);
				// print_r($rollNos);exit;
            if(sizeof($rollNos)>0)
            {
   //              $students =  $this->StudentMarks->StudentInfos->find()->contain(['Sections','Students','StudentClasses'=>['ClassMappings'=>['Employees']]])
   //                              ->where(['StudentInfos.roll_no IN'=>$rollNos,'StudentInfos.session_year_id'=>$this->Auth->user('session_year_id'),'StudentInfos.student_status'=>"Continue"])->order(['StudentInfos.roll_no'=>'ASC']);
		      		
		 // $time_table_syllabuses =  $this->StudentMarks->StudentInfos->TimeTableSyllabuses->find()->contain(['Sections','StudentClasses','Subjects','Streams','Mediums'])
   //                              ->where(['TimeTableSyllabuses.exam_id'=>$exam_id])->order(['TimeTableSyllabuses.date'=>'ASC']);
                
                 $students =  $this->StudentMarks->StudentInfos->find()->contain(['Sections','Students','StudentClasses'=>['ClassMappings'=>function($r){
					 return $r->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id'),'ClassMappings.is_deleted'=>"N"])->contain(['Employees']);
				 }]])->where(['StudentInfos.roll_no IN'=>$rollNos,'StudentInfos.session_year_id'=>$this->Auth->user('session_year_id'),'StudentInfos.student_status'=>'Continue'])->order(['StudentInfos.roll_no'=>'ASC']);
                    
        /* $time_table_syllabuses =  $this->StudentMarks->StudentInfos->TimeTableSyllabuses->find()->contain(['Sections','StudentClasses','Subjects','Streams','Mediums'])
                                ->where(['TimeTableSyllabuses.exam_id'=>$exam_master_id])->order(['TimeTableSyllabuses.date'=>'ASC']);*/
                    
         $time_table_syllabuses =  $this->StudentMarks->StudentInfos->TimeTableSyllabuses->find()->contain(['Sections','StudentClasses','Subjects'=>function($q){
            return $q->select(['id','name','parent_id','order_number','parent'=>'ParentSubjects.name'])->where([$where,'Subjects.rght-Subjects.lft'=>1,'Subjects.session_year_id'=>$this->Auth->user('session_year_id')])
                    ->order('Subjects.parent_id')
                    ->contain(['ParentSubjects']);
         },'Streams','Mediums'])->order(['TimeTableSyllabuses.date'=>'ASC']);
							
            }
            // pr($students->toArray());die;
        }
        $this->set(compact('students','exam','room_no','exam_hide','time_table_syllabuses'));
    }
    public function printattendanceLists($room_no=null,$exam_hide=null)
    {
        $session_year_id = $this->Auth->user('session_year_id');
        $session = $this->request->session();
        $room_no = $this->request->query('room_no');
        $exam_hide = $this->request->query('exam_hide');
        $section_id = $this->request->query('section_id');
        $exam_id = $this->request->query('exam_id');
            // pr($exam_hide);die;
        if ($this->request->is('post')) {
            // $section_id = $this->request->getData('section_id'); 
            // $exam_id    = $this->request->getData('exam_master_id');
            $rollNos    = array_filter(($this->request->getData('rollno')));
            $examDate    = array_filter(($this->request->getData('Examdate')));
            $this->request->session()->write('x_hours', $examDate);
            // pr($this->request->getData());exit;
            $exam = $this->StudentMarks->StudentInfos->StudentClasses->ExamMasters->find('threaded')->where(['ExamMasters.id'=>$exam_id,'ExamMasters.session_year_id'=>$session_year_id]);
            if(sizeof($rollNos)>0)
            {
                $rollNoArr=[];
                $examSubjectDetails = $this->StudentMarks->StudentInfos->find()->contain(['Sections','Students','StudentClasses'])->where(['StudentInfos.student_status'=>'Continue','StudentInfos.roll_no IN'=>$rollNos,'StudentInfos.session_year_id'=>$session_year_id])->order(['StudentInfos.roll_no'=>'ASC']); 
                
            }
        //    ksort($rollNoArr);

        //    pr($rollNoArr);exit;
        }
        $this->set(compact('examSubjectDetails','exam','room_no','examDate','rollNoArr','school','exam_hide','examDate'));
    }

    public function printAttendanceList($room_no=null,$exam_hide=null,$examDate=null)
    {
           // pr($examDate);die;
        if ($this->request->is('post')) {
            $section_id = $this->request->getData('section_id'); 
            $exam_id    = $this->request->getData('exam_master_id');
            $rollNos    = array_filter(($this->request->getData('rollno')));
            $examDate    = array_filter(($this->request->getData('Examdate')));
            //pr($examDate);exit;
            $exam = $this->StudentMarks->StudentInfos->StudentClasses->ExamMasters->find('threaded')->where(['ExamMasters.id'=>$exam_id]);
            if(sizeof($rollNos)>0)
            {
                $rollNoArr=[];
                $examSubjectDetails = $this->StudentMarks->StudentInfos->find()->contain(['Sections','Students','StudentClasses'])->where(['StudentInfos.student_status'=>'Continue','StudentInfos.roll_no IN'=>$rollNos])->order(['StudentInfos.roll_no'=>'ASC']); 
                if(sizeof($examSubjectDetails->toArray())>0)
                {
                    foreach($examSubjectDetails as $examSubjectDetail)
                    {
                        $rollNoArr[$examSubjectDetail->roll_no] = $examSubjectDetail;
                    }
                }
            }
            ksort($rollNoArr);

           // pr($rollNoArr);exit;
        }
        $this->set(compact('examSubjectDetails','exam','room_no','examDate','rollNoArr','school','exam_hide','examDate'));
    }

     public function examWise2Report()
    {
        
    }

    public function resultHold()
    {
       $session_year_id = $this->Auth->user('session_year_id');
        if($this->request->is('post'))
        {
            $mapping_id = $this->request->getData('class_mapping_id');
            $datas=$this->StudentMarks->ClassMappings->find()->where(['id'=>$mapping_id]);
            foreach ($datas as $data) {

                $student_infos=$this->StudentMarks->StudentInfos->find()
                ->where(['StudentInfos.student_class_id'=>$data->student_class_id,'StudentInfos.section_id'=>$data->section_id,'StudentInfos.session_year_id'=>$session_year_id,'StudentInfos.roll_no >'=>0])
                ->contain(['Students','StudentClasses','Sections'])
                ->order(['StudentInfos.roll_no']);
                //pr($student_infos->toArray());exit;
            }

        }
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections'])
            ->order(['ClassMappings.student_class_id','ClassMappings.section_id']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('classMappings','data','student_infos'));
    }

    public function holdStatus($status,$student_id)
    {
        $done = 0;
        if($status == 'Hold')
        {
            $info = $this->StudentMarks->StudentInfos->get($student_id);
            $info->result_hold = "Hold";
            $done = $this->StudentMarks->StudentInfos->save($info);
        }
        else
        {
            $info = $this->StudentMarks->StudentInfos->get($student_id);
            $info->result_hold = "Unhold";
            $done = $this->StudentMarks->StudentInfos->save($info);
        }
        echo $done ? 1 : 0; exit;
    }

    public function classWiseReport()
    {
        
    }

     public function seatArrangementReport()
    {
             $session = $this->request->session();
            $Examdatess = $session->read('x_hours');

            $room_no=$this->request->query('room_no');
            $student_capacity=$this->request->query('student_capacity');
            $row=$this->request->query('row');
            $exam_master=$this->request->query('exam_master_id');
            $exam_hide=$this->request->query('exam_hide');

            //pr($examDate);exit;
          /*  $exam = $this->StudentMarks->ExamMasters->find('threaded')->where(['ExamMasters.id'=>$exam_master]);*/
		  /*$exam = $this->StudentMarks->ExamMasters->SubExams->find('threaded')->where(['SubExams.id'=>$exam_master]);*/
$exammain = $this->StudentMarks->ExamMasters->find('threaded')->where(['ExamMasters.id'=>$exam_master]);
//pr($exammain);die;
        //}

        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections'])
            ->order(['ClassMappings.student_class_id','ClassMappings.section_id']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('sessionYears','classMappings','data','room_no','student_capacity','row','exam_master','exam_hide','Examdate','exam','examDate','Examdatess','exammain'));
    }

    public function examAttendanceReport()
    {
         if($this->request->is('post'))
        {
            $exam_text=$this->request->getData('exam_hide');
        }
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections'])
            ->order(['ClassMappings.student_class_id','ClassMappings.section_id']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('classMappings','exam_text'));
    }

     public function subjectWiseReport()
    {
         if($this->request->is('post'))
        {
            $subject_text=$this->request->getData('subject_hide');
            $exam_text=$this->request->getData('exam_hide');
            $mapping_id=$this->request->getData('class_mapping_id');
            $subject_id=$this->request->getData('subject_id');
            $exam_id=$this->request->getData('exam_master_id');
        }
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections'])
            ->order(['ClassMappings.student_class_id','ClassMappings.section_id']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('sessionYears','classMappings','data','datas','subjects','subject_text','exam_text'));
        
    }


 /*   public function crossSectionReport()
    {
         
        
      
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections'])
            ->order(['ClassMappings.student_class_id','ClassMappings.section_id']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('sessionYears','classMappings','data','datas','studentinfos','class_text','max'));
    }*/
	 public function crossSectionReport()
    {
          if($this->request->is('post'))
        {
            $mapping_id = $this->request->getData('class_mapping_id');
			 $datas=$this->StudentMarks->ClassMappings->find()->where(['id'=>$mapping_id]);
          
			$classname=$this->StudentMarks->StudentClasses->get($datas->toArray()[0]['student_class_id']);
			$classnamesection=$this->StudentMarks->Sections->get($datas->toArray()[0]['section_id']);
			$classnamestreams=$this->StudentMarks->Streams->get($datas->toArray()[0]['stream_id']);
			
			// $datastudentrecords=$this->StudentMarks->StudentRecords->find()->where(['StudentRecords.session_year_id'=>$this->Auth->user('session_year_id'),'StudentRecords.student_class_id'=>$datas->toArray()[0]['student_class_id'],'StudentRecords.section_id'=>$datas->toArray()[0]['section_id'],'StudentRecords.stream_id'=>$datas->toArray()[0]['stream_id']])->contain(['StudentInfos'=>'Students'])->order(['StudentRecords.status'=>'ASC','StudentRecords.percentage'=>'DESC']);
			// $alldeta=$datastudentrecords->toArray();

            $datastudentrecords=$this->StudentMarks->StudentRecords->find()->where(['StudentRecords.session_year_id'=>$this->Auth->user('session_year_id'),'StudentRecords.student_class_id'=>$datas->toArray()[0]['student_class_id'],'StudentRecords.section_id'=>$datas->toArray()[0]['section_id'],'StudentRecords.stream_id'=>$datas->toArray()[0]['stream_id']])->contain(['StudentInfos'=> 'Students'])
                ->order(['FIELD(StudentRecords.status, "pass","PASS","Pass") DESC'])
                ->order(['StudentRecords.grade' => 'ASC','StudentRecords.percentage'=>'DESC']);
            $alldeta=$datastudentrecords->toArray();
        }
        
      
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections'])
            ->order(['ClassMappings.student_class_id','ClassMappings.section_id']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('classnamestreams','classnamesection','sessionYears','classMappings','data','datas','studentinfos','class_text','max','alldeta','classname'));
    }
 public function crossClassReport()
    {
         if($this->request->is('post'))
        {
            $mapping_id = $this->request->getData('class_mapping_id');
			 $datas=$this->StudentMarks->ClassMappings->find()->where(['id'=>$mapping_id]);
           
			$classname=$this->StudentMarks->StudentClasses->get($datas->toArray()[0]['student_class_id']);
			
			$datastudentrecords=$this->StudentMarks->StudentRecords->find()->where(['StudentRecords.student_class_id'=>$datas->toArray()[0]['student_class_id'],'StudentRecords.session_year_id'=>$this->Auth->user('session_year_id')])->contain(['StudentInfos'=>'Students'])->order(['Students.scholar_no'=>'ASC']);
			$alldeta=$datastudentrecords->toArray();
        }
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections'])
			->group(['StudentClasses.id','Streams.id'])
            ->order(['ClassMappings.student_class_id','ClassMappings.section_id']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
		//pr($alldeta);die;
        $this->set(compact('sessionYears','classMappings','data','datas','studentinfos','class_text','alldeta','classname'));
    }
	/*public function crossSectionReport()
    {
         if($this->request->is('post'))
        {
            $mapping_id = $this->request->getData('class_mapping_id');
			 $datas=$this->StudentMarks->ClassMappings->find()->where(['id'=>$mapping_id]);
           
			$classname=$this->StudentMarks->StudentClasses->get($datas->toArray()[0]['student_class_id']);
			
			$datastudentrecords=$this->StudentMarks->StudentRecords->find()->where(['StudentRecords.student_class_id'=>$datas->toArray()[0]['student_class_id','StudentRecords.section_id'=>$datas->toArray()[0]['section_id']])->contain(['StudentInfos'=>'Students'])->order(['StudentInfos.roll_no'=>'ASC']);
			$alldeta=$datastudentrecords->toArray();
        }
          $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections'])
            ->order(['ClassMappings.student_class_id','ClassMappings.section_id']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
		//pr($alldeta);die;
        $this->set(compact('sessionYears','classMappings','data','datas','studentinfos','class_text','alldeta','classname'));
    }*/
/*
    public function crossClassReport()
    {
         if($this->request->is('post'))
        {
            $mapping_id = $this->request->getData('class_mapping_id');
            $class_text = $this->request->getData('class_hide');
            $datas=$this->StudentMarks->ClassMappings->find()->where(['id'=>$mapping_id]);
			$sub_ex_id=[];
            foreach ($datas as $data) {
              // $studentinfos=$this->StudentMarks->StudentInfos->find()
              // ->select($this->StudentMarks->StudentInfos)
              // ->select(['Students.name','Students.scholar_no','Students.father_name'])
              // ->where(['StudentInfos.student_class_id'=>$data->student_class_id,'StudentInfos.section_id'=>$data->section_id])
              // //->group(['StudentMarks.student_info_id'])
              // ->order(['StudentInfos.roll_no'])
              // ->contain(['StudentMarks','Students']);

              $studentinfos=$this->StudentMarks->find()
              ->select(['StudentInfos.roll_no','total'=>'SUM(StudentMarks.student_number)','StudentMarks.student_info_id','Students.name','Students.father_name','Students.scholar_no','Students.id'])
              ->where(['StudentInfos.student_class_id'=>$data->student_class_id,'Subjects.subject_type_id'=>1])
              ->group(['StudentMarks.student_info_id'])
              ->order(['StudentInfos.roll_no'])
              ->contain(['SubExams','Subjects','StudentInfos'=>['Students'=>['ExamAttendances']]]);
			  
			  $max_marks=$this->StudentMarks->find()
			->select(['sub_exams_id'=>'DISTINCT StudentMarks.sub_exam_id'])
            ->where(['StudentInfos.student_class_id'=>$data->student_class_id])
            ->group(['StudentMarks.student_info_id'])
            ->contain(['SubExams','Subjects','StudentInfos'=>['Students'=>['ExamAttendances']]]);
			//  pr($max_marks->toArray());exit;
			
			foreach($max_marks as $max){
				$sub_ex_id[]=$max->sub_exams_id;
			}
             
            // pr($sub_ex_id);
			
			$exams=$this->StudentMarks->Subjects->ResultRows->find()
			->select(['total'=>'SUM(total)'])
			->where(['ResultRows.exam_master_id IN'=>$sub_ex_id,'Subjects.subject_type_id'=>1])
			->contain(['Subjects'])
			->group(['ResultRows.exam_master_id']);
		//	pr($exams->toArray());exit;

            
            }
			//pr($studentinfos->toArray());exit;
        }
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections'])
			->group(['StudentClasses.id','Streams.id'])
            ->order(['ClassMappings.student_class_id','ClassMappings.section_id']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('sessionYears','classMappings','data','datas','studentinfos','class_text'));
    }*/
    
    
      public function subjectWise()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if($this->request->is('post'))
        {
            
            $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'),['contain'=>['StudentClasses','Sections','Streams','Mediums']]);
        
            $where['student_class_id'] = $class_mapping->student_class_id;
            $where['stream_id'] = $class_mapping->stream_id;
            $exam_master_id[] = $this->request->getData('exam_master_id');
            $subexamhide = $this->request->getData('subexamhide');
            $sub_exam_id=$this->request->getData('sub_exam_master_id');    
            //pr($sub_exam_id);
            $subjecthide = $this->request->getData('subjecthide');
            $exam_master_id[] = $sub_exam_id;
            $subject_id = $this->request->getData('subject_id');
            
            if (!empty($subject_id))
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where(['id IN'=>$subject_id,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N']);
            else
            {
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N']);
                $subject_ids = $this->StudentMarks->Subjects->find()->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N']);
            }
            if (!empty($subject_id)){}
            else
            {
                $subject_id =[];
                foreach ($subject_ids as $key => $sub)
                    $subject_id [] = $sub->id;
            }
            $condition = implode(' AND ',$this->array_map_assoc(function($k,$v){return "$k = $v";},$where));
            $exams = $this->StudentMarks->ExamMasters->find('threaded')->contain(['SubExams'])->where(['id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N']);
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute("SELECT 
            students.name, 
            student_infos.id As student_info_id, 
            student_infos.roll_no As roll_no, 
            exam_masters.id,
            exam_masters.name As exam,
            sub_exams.name as sub_exam,
            sub_exams.id as sub_exam_id,
            subjects.name As subject,
            subjects.id As subject_id,
            student_marks.student_number,
            exam_masters.max_marks,
            sub_exams.max_marks As sub_max,
            IF(sub_exams.id,1,0) as save_to
            FROM student_infos
            INNER JOIN students ON student_infos.student_id = students.id
            AND ".$condition." AND student_infos.section_id = ".$class_mapping->section_id." AND student_infos.session_year_id = ".$this->Auth->user('session_year_id')." AND 'StudentInfos.student_status'=>'Continue'
            LEFT JOIN subjects ON subjects.student_class_id = student_infos.student_class_id 
            AND subjects.stream_id = student_infos.stream_id 
            AND subjects.rght-subjects.lft=1  
            AND subjects.subject_type_id = 1
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."
            LEFT JOIN exam_masters ON subjects.student_class_id = exam_masters.student_class_id 
            AND subjects.stream_id = exam_masters.stream_id 
            AND exam_masters.rght-exam_masters.lft=1
            AND exam_masters.id IN (".implode(',',$exam_master_id).")
            LEFT JOIN sub_exams ON sub_exams.exam_master_id = exam_masters.id
            LEFT JOIN student_marks ON (student_marks.exam_master_id = exam_masters.id OR student_marks.sub_exam_id = sub_exams.id)
            AND student_marks.student_info_id = student_infos.id 
            AND student_marks.subject_id = subjects.id 
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."
            ORDER BY student_infos.roll_no ASC,exam_masters.order_number,sub_exams.id,subjects.order_number;");
            $students = $stmt->fetchAll('assoc');
            //pr($students);exit;
            $subjects = json_decode(json_encode($subjects->toArray()),true);
            $exams = json_decode(json_encode($exams->toArray()),true);
            foreach ($students as $key => $student) {
                if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']]))
                    $students[$key]['max_marks'] = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()->where(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']])->first()->max_marks;
            }
            //pr($students);exit;
        }
        
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('studentMarks','studentMark','subjects','exams','students','classMappings','class_mapping','subexamhide','subjecthide'));
    }

     public function rollReport()
    {
        if($this->request->is('post'))
        {
            $row= $this->request->getData('row');
            $mapping_id= $this->request->getData('class_mapping_id');
            @$class_text= $this->request->getData('class_hide');
            @$subject_text= $this->request->getData('subject_hide');
            $subject_id= $this->request->getData('subject_id');
			$session_name = $this->Auth->User('session_name');
            $session_year = $this->Auth->user('session_year_id');
            $find_sub=$this->StudentMarks->StudentInfos->StudentClasses->Subjects->find()
            ->select(['id','name','parent_id','order_number','parent'=>'ParentSubjects.name'])
                    ->where(['Subjects.id'=>$subject_id,'Subjects.rght-Subjects.lft'=>1])
                    ->order('Subjects.parent_id')
                    ->contain(['ParentSubjects'])->toArray();
         
            @$exam_text= $this->request->getData('exam_hide');
            $datas=$this->StudentMarks->ClassMappings->find()->where(['id'=>$mapping_id,'ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')]);
            // echo "<pre>"; print_r($find_sub);exit;
            foreach ($datas as $data) {

                $class=$this->StudentMarks->StudentInfos->StudentClasses->find()
                ->select(['name'])
                ->where(['id'=>$data->student_class_id])
                ->first();

                $section=$this->StudentMarks->StudentInfos->Sections->find()
                ->select(['name'])
                ->where(['id'=>$data->section_id])
                ->first();


                $studentinfos=$this->StudentMarks->StudentInfos->find()
                ->where(['StudentInfos.session_year_id'=>$this->Auth->user('session_year_id'),'StudentInfos.student_class_id'=>$data->student_class_id,'StudentInfos.stream_id'=>$data->stream_id,'StudentInfos.section_id'=>$data->section_id,'StudentInfos.medium_id'=>$data->medium_id,'StudentInfos.student_status'=>'Continue'])
                ->contain(['Students'])
                ->order(['StudentInfos.roll_no']);                
            }
         

        }
       
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            ->contain(['Mediums','StudentClasses','Streams','Sections'])
            ->order(['ClassMappings.student_class_id','ClassMappings.section_id']);
         
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('session_name','find_sub','studentMark', 'sessionYears', 'studentinfos', 'examMasters', 'subjects','classMappings','row','class_text','subject_text','exam_text','class','section'));
    }

    
    
    
 /*    public function index()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if($this->request->is('post'))
        {
            $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'),['contain'=>['StudentClasses','Sections','Streams','Mediums']]);
           
            $where['student_class_id'] = $class_mapping->student_class_id;
            $where['stream_id'] = $class_mapping->stream_id;
            $exam_master_id[] = $this->request->getData('exam_master_id');
            $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id[0]]);
            if(!empty($children->toArray()))
                foreach ($children as $key => $child)
                    $exam_master_id[] = $child->id;
            $subject_id = $this->request->getData('subject_id');
            
            if (!empty($subject_id))
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where(['id IN'=>$subject_id,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N']);
            else
            {
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N']);
                $subject_ids = $this->StudentMarks->Subjects->find()->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N']);
            }
            if (!empty($subject_id)){}
            else
            {
                $subject_id =[];
                foreach ($subject_ids as $key => $sub)
                    $subject_id [] = $sub->id;
            }
            $condition = implode(' AND ',$this->array_map_assoc(function($k,$v){return "$k = $v";},$where));
            $exams = $this->StudentMarks->ExamMasters->find('threaded')->contain(['SubExams'])->where(['id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N']);
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute("SELECT 
            students.name, 
            student_infos.id As student_info_id, 
            student_infos.roll_no As roll_no, 
            exam_masters.id,
            exam_masters.name As exam,
            sub_exams.name as sub_exam,
            sub_exams.id as sub_exam_id,
            subjects.name As subject,
            subjects.id As subject_id,
            student_marks.student_number,
            exam_masters.max_marks,
            sub_exams.max_marks As sub_max,
            IF(sub_exams.id,1,0) as save_to
            FROM student_infos
            INNER JOIN students ON student_infos.student_id = students.id
            AND ".$condition." AND student_infos.section_id = ".$class_mapping->section_id."
            LEFT JOIN subjects ON subjects.student_class_id = student_infos.student_class_id 
            AND subjects.stream_id = student_infos.stream_id 
            AND subjects.rght-subjects.lft=1  
            AND subjects.subject_type_id = 1
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."
            LEFT JOIN exam_masters ON subjects.student_class_id = exam_masters.student_class_id 
            AND subjects.stream_id = exam_masters.stream_id 
            AND exam_masters.rght-exam_masters.lft=1
            AND exam_masters.id IN (".implode(',',$exam_master_id).")
            LEFT JOIN sub_exams ON sub_exams.exam_master_id = exam_masters.id
            LEFT JOIN student_marks ON (student_marks.exam_master_id = exam_masters.id OR student_marks.sub_exam_id = sub_exams.id)
            AND student_marks.student_info_id = student_infos.id 
            AND student_marks.subject_id = subjects.id 
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."
            ORDER BY student_infos.roll_no ASC,exam_masters.order_number,sub_exams.id,subjects.order_number;");
            $students = $stmt->fetchAll('assoc');
            //pr($students);exit;
            $subjects = json_decode(json_encode($subjects->toArray()),true);
            $exams = json_decode(json_encode($exams->toArray()),true);
            foreach ($students as $key => $student) {
                if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']]))
                    $students[$key]['max_marks'] = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()->where(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']])->first()->max_marks;
            }
            //pr($students);exit;
        }
        
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('studentMarks','studentMark','subjects','exams','students','classMappings','class_mapping'));
    }*/
 public function index()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if($this->request->is('post'))
        {
            $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'),['contain'=>['StudentClasses','Sections','Streams','Mediums']]);
           
            $where['student_class_id'] = $class_mapping->student_class_id;
            $where['stream_id'] = $class_mapping->stream_id;
			$session_year_id = $this->Auth->user('session_year_id');
            $exam_master_id[] = $this->request->getData('exam_master_id');
            $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id[0]])->where(['ExamMasters.session_year_id'=>$session_year_id]);
            if(!empty($children->toArray()))
                foreach ($children as $key => $child)
                    $exam_master_id[] = $child->id;
            $subject_id = $this->request->getData('subject_id');
            
            if (!empty($subject_id))
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where(['id IN'=>$subject_id,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N','Subjects.session_year_id'=>$session_year_id])->order(['Subjects.order_number'=>'ASC']);
            else
            {
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N','Subjects.session_year_id'=>$session_year_id])->order(['Subjects.order_number'=>'ASC']);;
                $subject_ids = $this->StudentMarks->Subjects->find()->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N','Subjects.session_year_id'=>$session_year_id])->order(['Subjects.order_number'=>'ASC']);
            }
            if (!empty($subject_id)){}
            else
            {
                $subject_id =[];
                foreach ($subject_ids as $key => $sub)
                    $subject_id [] = $sub->id;
            }
            $condition = implode(' AND ',$this->array_map_assoc(function($k,$v){return "$k = $v";},$where));
            $exams = $this->StudentMarks->ExamMasters->find('threaded')->contain(['SubExams'])->where(['id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N',"ExamMasters.session_year_id"=>$session_year_id])->order(['ExamMasters.order_number'=>'ASC']);
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute("SELECT 
            students.name, 
            student_infos.id As student_info_id, 
            student_infos.roll_no As roll_no, 
            exam_masters.id,
            exam_masters.name As exam,
            sub_exams.name as sub_exam,
            sub_exams.id as sub_exam_id,
            subjects.name As subject,
            subjects.id As subject_id,
            student_marks.student_number,
            exam_masters.max_marks,
			exam_masters.name As examname,
            exam_masters.number_of_best,
            sub_exams.max_marks As sub_max,
            IF(sub_exams.id,1,0) as save_to
            FROM student_infos
            INNER JOIN students ON student_infos.student_id = students.id
            AND ".$condition." AND student_infos.section_id = ".$class_mapping->section_id." AND student_infos.session_year_id = ".$this->Auth->user('session_year_id')." AND 	student_infos.student_status='Continue'
            LEFT JOIN subjects ON subjects.student_class_id = student_infos.student_class_id 
            AND subjects.stream_id = student_infos.stream_id 
            AND subjects.rght-subjects.lft=1  
            AND subjects.subject_type_id = 1
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."
            LEFT JOIN exam_masters ON subjects.student_class_id = exam_masters.student_class_id 
            AND subjects.stream_id = exam_masters.stream_id 
            AND exam_masters.rght-exam_masters.lft=1
            AND exam_masters.id IN (".implode(',',$exam_master_id).")
            LEFT JOIN sub_exams ON sub_exams.exam_master_id = exam_masters.id
            LEFT JOIN student_marks ON (student_marks.exam_master_id = exam_masters.id OR student_marks.sub_exam_id = sub_exams.id)
            AND student_marks.student_info_id = student_infos.id 
            AND student_marks.subject_id = subjects.id 
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."
            ORDER BY student_infos.roll_no ASC,exam_masters.order_number,sub_exams.id,subjects.order_number;");
            $students = $stmt->fetchAll('assoc');
            //pr($students);exit;
            $subjects = json_decode(json_encode($subjects->toArray()),true);
            $exams = json_decode(json_encode($exams->toArray()),true);
            foreach ($students as $key => $student) {
                if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']]))
                    $students[$key]['max_marks'] = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()->where(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']])->first()->max_marks;
            }
            //pr($students);exit;
        }
        
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('studentMarks','studentMark','subjects','exams','students','classMappings','class_mapping'));
    }
    function array_map_assoc( $callback , $array ){
      $r = array();
      foreach ($array as $key=>$value)
        $r[$key] = $callback($key,$value);
      return $r;
    }

   /* public function examWiseReport()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if($this->request->is('post'))
        {
            $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'));
            
            $where['student_class_id'] = $class_mapping->student_class_id;
            $where['stream_id'] = $class_mapping->stream_id;

            $exam_master_id[] = $this->request->getData('exam_master_id');

            $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id[0]]);

            if(!empty($children->toArray()))
                foreach ($children as $key => $child)
                    $exam_master_id[] = $child->id;

            $subject_id = $this->request->getData('subject_id');

            if (!empty($subject_id))
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where(['id IN'=>$subject_id,'Subjects.subject_type_id' => 1]);
            else
            {
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N']);

                $subject_ids = $this->StudentMarks->Subjects->find()->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N']);
            }

            if (!empty($subject_id)){}
            else
            {
                $subject_id =[];
                foreach ($subject_ids as $key => $sub)
                    $subject_id [] = $sub->id;
            }

            $condition = implode(' AND ',$this->array_map_assoc(function($k,$v){return "$k = $v";},$where));
            $exams = $this->StudentMarks->ExamMasters->find('threaded')->contain(['SubExams'])->where(['id IN'=>$exam_master_id]);

            $conn = ConnectionManager::get('default');

            $stmt = $conn->execute("SELECT 
            students.name, student_infos.roll_no As roll_no,  
            student_infos.id As student_info_id, 
            exam_masters.id,exam_masters.name As exam,
            sub_exams.name as sub_exam,
            sub_exams.id as sub_exam_id,
            subjects.name As subject,
            subjects.id As subject_id,
            student_marks.student_number,
            exam_masters.max_marks,
            sub_exams.max_marks As sub_max,
            IF(sub_exams.id,1,0) as save_to
            FROM student_infos

            INNER JOIN students ON student_infos.student_id = students.id
            AND ".$condition." AND student_infos.section_id = ".$class_mapping->section_id."

            LEFT JOIN subjects ON subjects.student_class_id = student_infos.student_class_id 
            AND subjects.stream_id = student_infos.stream_id 
            AND subjects.rght-subjects.lft=1 
            AND subjects.subject_type_id = 1
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."

            LEFT JOIN exam_masters ON subjects.student_class_id = exam_masters.student_class_id 
            AND subjects.stream_id = exam_masters.stream_id 
            AND exam_masters.rght-exam_masters.lft=1 
            AND exam_masters.id IN (".implode(',',$exam_master_id).")

            LEFT JOIN sub_exams ON sub_exams.exam_master_id = exam_masters.id

            LEFT JOIN student_marks ON (student_marks.exam_master_id = exam_masters.id OR student_marks.sub_exam_id = sub_exams.id)
            AND student_marks.student_info_id = student_infos.id 
            AND student_marks.subject_id = subjects.id 
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."

            ORDER BY student_infos.roll_no ASC,subjects.order_number,exam_masters.order_number,sub_exams.id;");
            $students = $stmt->fetchAll('assoc');

            $subjects = json_decode(json_encode($subjects->toArray()),true);
            $exams = json_decode(json_encode($exams->toArray()),true);

            foreach ($students as $key => $student) {
                if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']]))
                    $students[$key]['max_marks'] = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()->where(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']])->first()->max_marks;
            }

            //pr($students);exit;
        }
        
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }

        $this->set(compact('studentMarks','studentMark','subjects','exams','students','classMappings'));
    }*/
    public function examWiseReport()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if($this->request->is('post'))
        {
            $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'));
            
            $where['student_class_id'] = $class_mapping->student_class_id;
            $where['stream_id'] = $class_mapping->stream_id;
            $session_year_id = $this->Auth->user('session_year_id');

            $exam_master_id[] = $this->request->getData('exam_master_id');
            //$exam_master_ids[] = $this->request->getData('exam_master_ids');
         //echo '<pre>';  print_r($exam_master_id);print_r($exam_master_ids);
            $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id[0]])->where(['ExamMasters.session_year_id'=>$session_year_id]);
           
            if(!empty($children->toArray()))
                foreach ($children as $key => $child)
                    $exam_master_id[] = $child->id;

            $subject_id = $this->request->getData('subject_id');

            if (!empty($subject_id))
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where(['id IN'=>$subject_id,'Subjects.subject_type_id' => 1,'Subjects.session_year_id'=>$session_year_id])->order(['Subjects.order_number'=>'ASC']);
            else
            {
                $subjects = $this->StudentMarks->Subjects->find('threaded')->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N','Subjects.session_year_id'=>$session_year_id])->order(['Subjects.order_number'=>'ASC']);

                $subject_ids = $this->StudentMarks->Subjects->find()->contain(['ExamMaxMarks'])->where([$where,'Subjects.subject_type_id' => 1,'Subjects.is_deleted'=>'N','Subjects.session_year_id'=>$session_year_id])->order(['Subjects.order_number'=>'ASC']);
            }

            if (!empty($subject_id)){}
            else
            {
                $subject_id =[];
                foreach ($subject_ids as $key => $sub)
                    $subject_id [] = $sub->id;
            }

            $condition = implode(' AND ',$this->array_map_assoc(function($k,$v){return "$k = $v";},$where));
            $exams = $this->StudentMarks->ExamMasters->find('threaded')->contain(['SubExams'])->where(['id IN'=>$exam_master_id,"ExamMasters.session_year_id"=>$session_year_id])->order(['ExamMasters.order_number'=>'ASC']);

            //echo '<pre>';  print_r($exams->toArray());exit;
	       
            $conn = ConnectionManager::get('default');

            $stmt = $conn->execute("SELECT 
            students.name, student_infos.roll_no As roll_no,  
            student_infos.id As student_info_id, 
            exam_masters.id,exam_masters.name As exam,
            sub_exams.name as sub_exam,
            sub_exams.id as sub_exam_id,
            subjects.name As subject,
            subjects.id As subject_id,
            student_marks.student_number,
            exam_masters.max_marks,
            sub_exams.max_marks As sub_max,
            IF(sub_exams.id,1,0) as save_to
            FROM student_infos

            INNER JOIN students ON student_infos.student_id = students.id
            AND ".$condition." AND student_infos.section_id = ".$class_mapping->section_id." AND student_infos.session_year_id = ".$this->Auth->user('session_year_id')." AND 	student_infos.student_status='Continue'

            LEFT JOIN subjects ON subjects.student_class_id = student_infos.student_class_id 
            AND subjects.stream_id = student_infos.stream_id 
            AND subjects.rght-subjects.lft=1 
            AND subjects.subject_type_id = 1
            ".(!empty($subject_id) ? 'AND subjects.id IN ('.implode(',',$subject_id).')':'')."

            LEFT JOIN exam_masters ON subjects.student_class_id = exam_masters.student_class_id 
            AND subjects.stream_id = exam_masters.stream_id 
            AND exam_masters.rght-exam_masters.lft=1 
            AND exam_masters.id IN (".implode(',',$exam_master_id).")

            LEFT JOIN sub_exams ON sub_exams.exam_master_id = exam_masters.id

            LEFT JOIN student_marks ON (student_marks.exam_master_id = exam_masters.id OR student_marks.sub_exam_id = sub_exams.id)
            AND student_marks.student_info_id = student_infos.id 
            AND student_marks.subject_id = subjects.id 
            ".(!empty($subject_id) ? ' AND subjects.id IN ('.implode(',',$subject_id).')':'')."

            ORDER BY student_infos.roll_no ASC,subjects.order_number,exam_masters.order_number,sub_exams.id;");
		
            $students = $stmt->fetchAll('assoc');
            //echo '<pre>';  print_r($students);exit;
            $subjects = json_decode(json_encode($subjects->toArray()),true);
            $exams = json_decode(json_encode($exams->toArray()),true);

            foreach ($students as $key => $student) {

                if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']]))
                    $students[$key]['max_marks'] = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()->where(['exam_master_id'=>$student['id'],'subject_id'=>$student['subject_id']])->first()->max_marks;
            }

            //pr($students);exit;
        }
        
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }

        $this->set(compact('studentMarks','studentMark','subjects','exams','students','classMappings'));
    }

    /**
     * View method
     *
     * @param string|null $id Student Mark id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $studentMark = $this->StudentMarks->get($id, [
            'contain' => ['SessionYears', 'StudentInfos', 'ExamMasters', 'Subjects']
        ]);

        $this->set('studentMark', $studentMark);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            foreach ($data['data'] as $key => $value) {
                $data['data'][$key]['session_year_id'] = $this->Auth->user('session_year_id');
                $data['data'][$key]['created_by'] = $this->Auth->user('id');
                $data['data'][$key]['exam_master_id'] = $this->request->getData('exam_master_id');
                $data['data'][$key]['subject_id'] = $this->request->getData('subject_id');
            }
            //pr($data['data']);exit;
            $studentMark = $this->StudentMarks->patchEntities($studentMark,$data['data']);
            //pr($studentMark);exit;
            if ($this->StudentMarks->saveMany($studentMark)) {
                $this->Flash->success(__('The student mark has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            else
            {
                $this->Flash->error(__('The student mark could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'add']);
            }
        }
        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('studentMark', 'sessionYears', 'studentInfos', 'examMasters', 'subjects','classMappings'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Student Mark id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $studentMark = $this->StudentMarks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $studentMark = $this->StudentMarks->patchEntity($studentMark, $this->request->getData());
            if ($this->StudentMarks->save($studentMark)) {
                $this->Flash->success(__('The student mark has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student mark could not be saved. Please, try again.'));
        }
        $sessionYears = $this->StudentMarks->SessionYears->find('list');
        $studentInfos = $this->StudentMarks->StudentInfos->find('list');
        $examMasters = $this->StudentMarks->ExamMasters->find('list');
        $subjects = $this->StudentMarks->Subjects->find('list');
        $this->set(compact('studentMark', 'sessionYears', 'studentInfos', 'examMasters', 'subjects'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Student Mark id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $studentMark = $this->StudentMarks->get($id);
        if ($this->StudentMarks->delete($studentMark)) {
            $this->Flash->success(__('The student mark has been deleted.'));
        } else {
            $this->Flash->error(__('The student mark could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getStudentsSingle()
    {
        $where['Students.is_deleted'] = 'N';
        $where2['StudentMarks.is_deleted'] = 'N';
		$session_year_id=$this->Auth->user('session_year_id');
		//pr($session_year_id);die;
        $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'));

        if(!empty($this->request->getData()))
            foreach ($this->request->getData() as $key => $value) {
                if(!empty($value) && $key != 'class_mapping_id')
                    $where2['StudentMarks.'.$key] = $value;
            }

        //pr($where2);exit;

        $subject_id = $where2['StudentMarks.subject_id'];
        $subject = $this->StudentMarks->Subjects->get($subject_id);
        $success = 0;

        if($subject->elective == 'Yes')
        {
            $response = $this->StudentMarks->StudentInfos->find();
            $response->select(['id'=>'StudentInfos.id','name'=>'Students.name','rollno'=>'StudentInfos.roll_no','scholer'=>'Students.scholar_no','marks'=>'StudentMarks.student_number','marks_id'=>'StudentMarks.id'])
            ->innerJoinWith('StudentElectiveSubjects',function($q)use($where2){return $q->where(['subject_id'=>$where2['StudentMarks.subject_id']]);})
            ->leftJoinWith('StudentMarks',function($q)use($where2){return $q->where($where2);})
            ->contain(['Students'])
            ->where(['StudentInfos.student_class_id'=>$class_mapping->student_class_id])
            ->where(['StudentInfos.stream_id'=>$class_mapping->stream_id])
            ->where(['StudentInfos.section_id'=>$class_mapping->section_id])
            ->where(['StudentInfos.session_year_id'=>$session_year_id])
            ->where(['StudentInfos.student_status'=>'Continue'])
            ->where(['Students.is_deleted'=>'N'])
            ->order(['StudentInfos.roll_no ASC']);
        }
        else
        {
            $response = $this->StudentMarks->StudentInfos->find();
            $response->select(['id'=>'StudentInfos.id','name'=>'Students.name','rollno'=>'StudentInfos.roll_no','scholer'=>'Students.scholar_no','marks'=>'StudentMarks.student_number','marks_id'=>'StudentMarks.id'])
            ->leftJoinWith('StudentMarks',function($q)use($where2){return $q->where($where2);})
            ->contain(['Students'])
            ->where(['StudentInfos.student_class_id'=>$class_mapping->student_class_id])
            ->where(['StudentInfos.stream_id'=>$class_mapping->stream_id])
            ->where(['StudentInfos.section_id'=>$class_mapping->section_id])
			->where(['StudentInfos.session_year_id'=>$session_year_id])
			->where(['StudentInfos.student_status'=>'Continue'])
            ->where(['Students.is_deleted'=>'N'])
            ->order(['StudentInfos.roll_no ASC']);

        }  

        if(!empty($response->toArray()))
            $success = 1;

        $this->set(compact('success','response'));
        $this->set('_serialize', ['response','success']);
    }

    public function getStudentsMultiple()
    {
        $where['Students.is_deleted'] = 'N';
        $where2['StudentMarks.is_deleted'] = 'N';
        foreach ($this->request->getData('StudentInfos') as $key => $value) {
            if(!empty($value))
                $where['StudentInfos.'.$key] = $value;
        }
        if(!empty($this->request->getData('ExamMasters')))
            foreach ($this->request->getData('ExamMasters') as $key => $value) {
                if(!empty($value))
                    $where2['StudentMarks.'.$key] = $value;
            }

        //pr($where2);exit;

        $subject_id = $where2['StudentMarks.subject_id'];
        $subject = $this->StudentMarks->Subjects->get($subject_id);
        $success = 0;

        if($subject->elective == 'Yes')
        {
            $response = $this->StudentMarks->StudentInfos->find();
            $response->select(['id'=>'StudentInfos.id','name'=>'Students.name','rollno'=>'StudentInfos.roll_no','scholer'=>'Students.scholar_no','marks'=>'StudentMarks.student_number','marks_id'=>'StudentMarks.id'])
            ->innerJoinWith('StudentElectiveSubjects',function($q)use($where2){return $q->where(['subject_id'=>$where2['StudentMarks.subject_id']]);})
            ->leftJoinWith('StudentMarks',function($q)use($where2){return $q->where($where2);})
            ->contain(['Students'])
            ->where([$where]);
        }
        else
        {
            $response = $this->StudentMarks->StudentInfos->find();
            $response->select(['id'=>'StudentInfos.id','name'=>'Students.name','rollno'=>'StudentInfos.roll_no','scholer'=>'Students.scholar_no','marks'=>'StudentMarks.student_number','marks_id'=>'StudentMarks.id'])
            ->leftJoinWith('StudentMarks',function($q)use($where2){return $q->where($where2);})
            ->contain(['Students'])
            ->where([$where]);
        }  

        if(!empty($response->toArray()))
            $success = 1;

        $this->set(compact('success','response'));
        $this->set('_serialize', ['response','success']);
    }

    public function excelUpload()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if ($this->request->is('post')) {
            $tmpName = $_FILES['csv']['tmp_name'];
            $csvAsArray = array_map('str_getcsv', file($tmpName));

            //pr($csvAsArray);exit;

            foreach ($csvAsArray as $key => $data) {
                if($key > 0)
                {
                    foreach ($data as $key2 => $value) {
                        if($key2 > 0)
                        {
                            if($csvAsArray[0][$key2] == 'Marks')
                                $csvAsArray[0][$key2] = 'student_number';
                            $studentMarks[$key][$csvAsArray[0][$key2]] = $value;
                        }
                    }
                }
            }
            //pr($studentMarks);
            $save = $this->StudentMarks->patchEntities($studentMark,$studentMarks);
            //pr($save);exit;
            foreach ($save as $key => $value) {
                if(isset($value->id))
                    $value->edited_by = $this->Auth->user('id');
                else
                {
                    $value->created_by = $this->Auth->user('id');
                    $value->session_year_id = $this->Auth->user('session_year_id');
                }
            }
            //pr($save);exit;
            if($this->StudentMarks->saveMany($save))
                $this->Flash->success('Data has been saved');
            else
                $this->Flash->error('Data could not be saved');
        }

        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
           
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('studentMark', 'examMasters', 'subjects','classMappings'));
    }

/*public function excelUpload()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if ($this->request->is('post')) {
            $tmpName = $_FILES['csv']['tmp_name'];
            $csvAsArray = array_map('str_getcsv', file($tmpName));

           // pr($csvAsArray);exit;

            foreach ($csvAsArray as $key => $data) {
                if($key > 0)
                {
                    foreach ($data as $key2 => $value) {
                        if($key2 > 0)
                        {
                            if($csvAsArray[0][$key2] == 'Marks')
                                $csvAsArray[0][$key2] = 'student_number';
                            $studentMarks[$key][$csvAsArray[0][$key2]] = $value;
                        }
                    }
                }
            }
           //pr($studentMarks);die;
           foreach($studentMarks as $studen)
           {
             //  pr($studen['subject_id']);die;
            $studentMarkss=$this->StudentMarks->find()->where(['StudentMarks.subject_id'=>$studen['subject_id'],'StudentMarks.student_info_id'=>$studen['student_info_id']]);
             $aa=$studentMarkss->toArray()[0]->student_number;
            if($aa=='')
            {
            $save = $this->StudentMarks->patchEntities($studentMark,$studentMarks);
            }else{
                $save ='';
            }
           }
            
            
         //   pr($save);exit;
            if($save)
            {
            foreach ($save as $key => $value) {
                if(isset($value->id))
                    $value->edited_by = $this->Auth->user('id');
                else
                {
                    $value->created_by = $this->Auth->user('id');
                    $value->session_year_id = $this->Auth->user('session_year_id');
                }
            }
            }
            //pr($save);exit;
            if($save){
            if($this->StudentMarks->saveMany($save))
                $this->Flash->success('Data has been saved');
            }
            else
                $this->Flash->error('Data could not be saved');
        }

        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
           
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }
        $this->set(compact('studentMark', 'examMasters', 'subjects','classMappings'));
    }*/
    public function excelDownload()
    {
        $tables = '';
        $table = [];
        $this->viewBuilder()->setLayout('');
        
        if($this->request->is('post'))
        {
            $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'));
            $data = $this->request->getData();
            $exam_id = $data['exam_master_id'];
            unset($data['exam_master_id']);
            $data[''.$data['save_to']] = $exam_id;
            unset($data['save_to']);
            unset($data['class_mapping_id']);

            array_push($table,'Sr. No.','id','exam_master_id','sub_exam_id','subject_id','student_info_id','Student','Scoller No.','Roll No.','Marks');
            $tables.=implode($table,',');
            $tables.="\n";

            $where2['StudentMarks.is_deleted'] = 'N';

            foreach ($data as $key => $value) {
                if(!empty($value))
                    $where2['StudentMarks.'.$key] = $value;
            }

            $success = 0;
            $response = $this->StudentMarks->StudentInfos->find();
            $response->select(['id'=>'StudentInfos.id','name'=>'Students.name','rollno'=>'StudentInfos.roll_no','scholer'=>'Students.scholar_no','marks'=>'StudentMarks.student_number','marks_id'=>'StudentMarks.id'])
            ->leftJoinWith('StudentMarks',function($q)use($where2)
                {
                    return $q->where($where2);
                }
            )
            ->contain(['Students'])
            ->where(['StudentInfos.student_class_id'=>$class_mapping->student_class_id])
            ->where(['StudentInfos.stream_id'=>$class_mapping->stream_id])
            ->where(['StudentInfos.section_id'=>$class_mapping->section_id])
            ->where(['StudentInfos.session_year_id'=>$this->Auth->user('session_year_id')])
            ->where(['Students.is_deleted'=>'N'])
            ->order(['StudentInfos.roll_no ASC']);

            foreach ($response as $key => $data) {
                $table[0]= $key;
                $table[1]= (!empty($data->marks_id)? $data->marks_id : '');
                $table[2]= (@$where2['StudentMarks.exam_master_id']) ? $where2['StudentMarks.exam_master_id'] : '';
                $table[3]= (@$where2['StudentMarks.sub_exam_id']) ? $where2['StudentMarks.sub_exam_id'] : '';
                $table[4]= $where2['StudentMarks.subject_id'];
                $table[5]= (!empty($data->id) ? $data->id : '');
                $table[6]= $data->name;
                $table[7]= $data->scholer;
                $table[8]= $data->rollno;
                $table[9]= ($data->marks !== null ? $data->marks : '');
                $tables.=implode($table,',');
                $tables.="\n";
            }

            if(!empty($response->toArray()))
                $success = 1;
        }
        

        $this->set(compact('success','response','tables'));
        $this->set('_serialize', ['response','success']);
    }
/* back up 20/2/2020
 public function viewMarkSheet1($student_info_id,$student_class_id,$exam_master_id,$last,$stream_id=null,$section_id=null)
    { 
    
        $where['student_class_id'] = $student_class_id;
        
        if($stream_id==0)
        {
             $where['stream_id'] = '';
        }else{
            $where['stream_id'] = $stream_id;
        }
       $infodata=$this->StudentMarks->ClassMappings->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id,'section_id'=>$section_id])->contain(['employees']);
       
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id]);
     // pr($infogread->toArray());die;
        $sy_id = $this->Auth->user('session_year_id');
        $where = array_filter($where, function($value) { return $value != ''; });
        $this->viewBuilder()->setLayout('pdf');

        
        $student = $this->StudentMarks->StudentInfos->get($student_info_id, [
            'contain' => ['Students','StudentClasses','Sections','Streams']
        ]);
//pr($student['student']->id);die;
   $examattendances = $this->StudentMarks->ExamAttendances->find()->where(['ExamAttendances.student_id'=>$student['student']->id]);
   $att=$examattendances->toArray();
        $marks_type = $student->student_class->grade_type;

       if($last == 0)
        {
            $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id])->contain(['SubExams']);
        }
      else{  
            $children = $this->StudentMarks->ExamMasters->find()->where([$where,'session_year_id'=>$sy_id])->order(['ExamMasters.order_number'=>'ASC'])->contain(['SubExams']);
          }  
    
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
       
      
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N']);

        $marks = $this->StudentMarks->Results->find()->where(['student_info_id'=>$student_info_id,'exam_master_id IN'=>$exam_master_id])->contain(['ResultRows'=>function($q){
                return $q->order(['ExamMasters.order_number'=>'ASC'])->contain(['ExamMasters']);
            }]); 
        
        

        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id,'Subjects.is_deleted'=>'N'])->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);

        $non_scholastic_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>2,'Subjects.is_deleted ='=>'N']);

        $non_scholastic_subjects = json_decode(json_encode($non_scholastic_subjects->toArray()),true);
  
        foreach ($non_scholastic_subjects as $key => $subject)
            if(empty($subject['student_marks']))
            {
                unset($non_scholastic_subjects[$key]);
            }
 
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    
        $this->set(compact('student','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }*/
		public function viewMarkSheetixx($student_info_id,$student_class_id,$exam_master_id,$last,$stream_id=null,$section_id=null)
    { 
    
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
      // pr($infodata);die;
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id,'session_year_id'=>$sy_id]);
     // pr($infogread->toArray());die;
       
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
				$children = $this->StudentMarks->ExamMasters->find()->where(['ExamMasters.id'=>$exam_master_id])->contain(['SubExams']);
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
       
//       $examattendances = $this->StudentMarks->ExamAttendances->find()->where(['ExamAttendances.student_id'=>$student['student']->id,'ExamAttendances.exam_id IN'=>$exam_master_id]);
//    $att=$examattendances->toArray();

   $examattendances = $this->StudentMarks->ExamAttendances->find()->where([
        'ExamAttendances.student_id' => $student_info_id,
        'ExamAttendances.exam_id IN' => $exam_master_id]);
    $att=$examattendances->toArray();




  // pr($att);die;
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N']);

        $marks = $this->StudentMarks->Results->find()->where(['student_info_id'=>$student_info_id,'exam_master_id IN'=>$exam_master_id])->contain(['ResultRows'=>function($q){
                return $q->order(['ExamMasters.order_number'=>'ASC'])->contain(['ExamMasters']);
            }]); 
        $electiveSubject = $this->StudentMarks->Subjects->StudentElectiveSubjects->find()
									->select(['subject_id'])
									->where(['StudentElectiveSubjects.student_info_id'=>$student_info_id])->first();
		if(!empty($electiveSubject))
		{
			$whcondition['Subjects.id'] = $electiveSubject->subject_id;
		}
       // pr($whcondition);die;

        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id,'Subjects.is_deleted'=>'N'])
		->orWhere(@$whcondition)
		->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);
  // pr($scholastic_subjects);die;
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
		@$prashantsubject=$this->StudentMarks->Subjects->find()->where(['id'=>$subject['parent_id']]);
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
  //  pr($non_scholastic_subjects);die;
        foreach ($personality_subjects as $key => $subject)
		{ 
            if(empty($subject['student_marks']))
            {
                unset($personality_subjects[$key]);
            }
 }
 //pr($ii);die;
 //pr($non_scholastic_subjects);die;
 $attitude_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>5,'Subjects.is_deleted ='=>'N','Subjects.session_year_id'=>$sy_id]);
        
        $attitude_subjects = json_decode(json_encode($attitude_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($attitude_subjects as $key => $subject)
		{ 
            if(empty($subject['student_marks']))
            {
                unset($attitude_subjects[$key]);
            }
 }
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //pr($att);die;
        $this->set(compact('sy_name','attitude_subjects','personality_subjects','ii','student','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }
	public function viewAllMarksheetixx($class_mapping_id,$exam_master_id,$last)
    { 
       $class_map=$this->StudentMarks->ClassMappings->get($class_mapping_id);
       // pr($class_map);exit;
        $where['student_class_id'] = $class_map->student_class_id;
        $com = $this->loadComponent('Grade');
        if($class_map)
        {
             $where['stream_id'] = '';
        }else{
            $where['stream_id'] = $class_map->stream_id;
        }
        $sy_id = $this->Auth->user('session_year_id');
       $infodata=$this->StudentMarks->ClassMappings->find()->where(['ClassMappings.student_class_id'=>$class_map->student_class_id,'ClassMappings.stream_id'=>$class_map->stream_id,'ClassMappings.section_id'=>$class_map->section_id,'ClassMappings.session_year_id'=>$sy_id])->contain(['Employees']);
      //pr($infodata->toArray());exit;
       
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$class_map->student_class_id,'stream_id IN'=>$class_map->stream_id,'session_year_id'=>$sy_id]);
    //pr($infogread->toArray());die;
       
		$sy_name = $this->Auth->user('session_name'); 
        $where = array_filter($where, function($value) { return $value != ''; });
        $this->viewBuilder()->setLayout('pdf');

        
        $students = $this->StudentMarks->StudentInfos->find()
        ->where(['StudentInfos.student_class_id'=>$class_map->student_class_id,'StudentInfos.stream_id'=>$class_map->stream_id,'StudentInfos.section_id'=>$class_map->section_id,'StudentInfos.result_hold'=>'Unhold','StudentInfos.session_year_id'=>$sy_id,'StudentInfos.Continue'=>'Continue'])
        ->contain(['Students','StudentClasses','Sections','Streams'])->order(['Students.name'=>'ASC']);
//pr($students->toArray());die;
$student_info_ids=[];
        foreach ($students as $student) {
			
            $student_info_ids[]=$student->id;
   
   //pr($examattendances->toArray());exit;
        $marks_type = $student['student_class']->grade_type;
		}
		
        if($last == 0)
        {
          $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id])->where(['ExamMasters.session_year_id'=>$sy_id])->contain(['SubExams']);
		  if($student_class_id==1 or $student_class_id==2 or $student_class_id==3 or $student_class_id==4 or $student_class_id==5 ){
				if($exam_master_id==133 or $exam_master_id==134 or $exam_master_id==135 or $exam_master_id==136 or $exam_master_id==137)
				{
				$children = $this->StudentMarks->ExamMasters->find()->where(['ExamMasters.id'=>$exam_master_id])->contain(['SubExams']);
				}
			}
       }
       else{  
            $children = $this->StudentMarks->ExamMasters->find()->where([$where,'session_year_id'=>$sy_id])->order(['ExamMasters.order_number'=>'ASC'])->contain(['SubExams']);
         }  
    
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
       $examattendances = $this->StudentMarks->ExamAttendances->find()->where(['ExamAttendances.student_id IN'=>$student_info_ids,'ExamAttendances.exam_id IN'=>$exam_master_id]);
   $att=$examattendances->toArray();
      
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id,'ExamMasters.session_year_id'=>$sy_id]);
 
		   foreach ($students as $student) {	
          
        $marks[$student->id] = $this->StudentMarks->Results->find()->where(['student_info_id'=>$student->id,'exam_master_id IN'=>$exam_master_id])->contain(['ResultRows'=>function($q){
                return $q->order(['ExamMasters.order_number'=>'ASC'])->contain(['ExamMasters']);
            }])->toArray(); 
		   }
$scholastic_subjectsss = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id])->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjectsss = json_decode(json_encode($scholastic_subjectsss->toArray()),true);
$subjectArr1=[];
 foreach ($students as $student) {	
    $electiveSubject = $this->StudentMarks->Subjects->StudentElectiveSubjects->find()
									->select(['subject_id'])
									->where(['StudentElectiveSubjects.student_info_id'=>$student->id])->first();
		$subjectArr1[@$student->id][]=$electiveSubject['subject_id'];
		foreach($scholastic_subjectsss as $scholasbjectsss)
		{
			//pr($scholasbjectsss);die;
			$subjectArr1[@$student->id][]=$scholasbjectsss['id'];
		}
 }
// pr($subjectArr1);die;
 
 
        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
        ->where([$where,'subject_type_id'=>1,'Subjects.session_year_id'=>$sy_id])->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);
//pr($scholastic_subjects);die;
        $non_scholastic_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_ids,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number','StudentMarks.student_info_id'])->where(['student_info_id IN'=>$student_info_ids,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>2,'Subjects.is_deleted ='=>'N','Subjects.session_year_id'=>$sy_id]);

        $non_scholastic_subjects = json_decode(json_encode($non_scholastic_subjects->toArray()),true);
  
        foreach ($non_scholastic_subjects as $key => $subject)
		{
			@$ii[$subject['parent_id']]+=1;
		@$prashantsubject=$this->StudentMarks->Subjects->find()->where(['id'=>$subject['parent_id']]);
		//pr();die;
		$non_scholastic_subjects[$key]['parentname']=@$prashantsubject->toArray()[0]->name;
            if(empty($subject['student_marks']))
            {
                unset($non_scholastic_subjects[$key]);
            }
         //  pr($non_scholastic_subjects);exit;
        }
 

      
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //pr($infodata->toArray());die;
        $this->set(compact('sy_name','sy_id','com','subjectArr1','ii','students','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }


    // @coder-kabir 08-03-2022 ---------------------------------------------------------------------------------------------

    public function newAllMarksheetXI($classMappingID,$examMasterID,$last){

        $getSessionYearID = $this->Auth->user('session_year_id');
        $getSessionName   = $this->Auth->user('session_name'); 
        $schooledatas     = $this->StudentMarks->Schools->find()->first();
        $component        = $this->loadComponent('Grade');

        $this->viewBuilder()->setLayout('pdf');

        // @class-mapping-data -----------------------------------------------------------------------------------

            $getClassMapping = $this->StudentMarks->ClassMappings->get($classMappingID);

            $getClassMappingAndEmployee = $this->StudentMarks->ClassMappings->find()->where([
                'student_class_id'              => $getClassMapping->student_class_id,
                'stream_id'                     => $getClassMapping->stream_id,
                'section_id'                    => $getClassMapping->section_id,
                'ClassMappings.session_year_id' => $getSessionYearID
            ])->contain(['employees'])->first();

        // @get-grade-masters -------------------------------------------------------------------------------------------
                
            $getGradeMasters = $this->StudentMarks->GradeMasters->find()->where([
                'student_class_id' => $getClassMapping->student_class_id,
                'stream_id'        => $getClassMapping->stream_id,
                'session_year_id'  => $getSessionYearID
            ])->toArray();

        // --------------------------------------------------------------------------------------------------------------

            $getStudentsList = $this->StudentMarks->StudentInfos->find()->where([
                'student_class_id' => $getClassMapping->student_class_id,
                'section_id'       => $getClassMapping->section_id,
                'stream_id'        => $getClassMapping->stream_id,
                'StudentInfos.session_year_id' => $getSessionYearID,
                'Students.is_deleted'          => 'N'
            ])->contain(['Students','StudentClasses','Sections','Streams'])
              ->order(['Students.name ASC'])->toArray();

        // @sort exams masters ids ------------------------------------------------------------------------------------------

            if($last == 0){

                $getExamMasters = $this->StudentMarks->ExamMasters->find('children', ['for' => $examMasterID])
                    ->where(['ExamMasters.session_year_id'=>$getSessionYearID])
                    ->contain(['SubExams'])
                    ->toArray();
            }
            else {   
                
                $getExamMasters = $this->StudentMarks->ExamMasters->find()->where([
                    'student_class_id' => $getClassMapping->student_class_id,
                    'stream_id'        => $getClassMapping->stream_id,
                    'session_year_id'  => $getSessionYearID
                ])->order(['ExamMasters.order_number' => 'ASC'])->contain(['SubExams'])->toArray();
            }  


            foreach ($getExamMasters as $idx => $examMaster) {
              
                $examMasterMainIDArray[] = $examMaster->id;

                if(!$examMaster['sub_exams']) array_merge($examMasterMainIDArray,array_column($examMaster['sub_exams'],'id'));
            }

            $examMasterMainIDArray[] = $examMasterID;

        // ---------------------------------------------------------------------------------------------------------------------

        // @store-students-exams ---------------------------------------------------------------------------------------------------

            $storeStudentExams = $this->StudentMarks->ExamMasters->find('threaded')
                ->order(['ExamMasters.order_number'=>'ASC'])->where([
                    'id IN'                  => $examMasterMainIDArray,
                    'ExamMasters.is_deleted' =>'N',
                    'student_class_id' => $getClassMapping->student_class_id,
                    'stream_id'        => $getClassMapping->stream_id,
                    'session_year_id'  => $getSessionYearID
                ])->toArray();

        // -----------------------------------------------------------------------------------------------------------------------

            $storeStudentExamAttendances = [];
            $storeNoneScholasticSubjects = [];
            $storeScholasticSubjects     = [];
            $storeStudentMarks = [];

            foreach ($getStudentsList as $idx => $studentInfos) {

                $storeStudentExamAttendances[] = $this->StudentMarks->ExamAttendances->find()->where([
                    'ExamAttendances.student_id' => $studentInfos->id,
                    'ExamAttendances.exam_id IN' => $examMasterMainIDArray
                ])->toArray();


                // @store-student-marks ---------------------------------------------------------------------------------

                    $getStudentMarks = $this->StudentMarks->find()->where([
                        'StudentMarks.student_info_id'   => $studentInfos->id,
                        'StudentMarks.exam_master_id IN' => $examMasterMainIDArray
                    ])->toArray();

                    foreach($getStudentMarks as $idx => $marks){
                  
                        $getMaxMarks  = $this->StudentMarks->ExamMaxMarks->find()->where([
                            'ExamMaxMarks.exam_master_id' => $marks->exam_master_id,
                            'ExamMaxMarks.subject_id'     => $marks->subject_id
                        ])->first();
                    
                        $getStudentMarks[$idx]->marksmax = $getMaxMarks->max_marks;
                    } 

                    $storeStudentMarks[] = $getStudentMarks; 
                
                // @store-student-marks done :) ------------------------------------------------------------------------------------

                // @store-scholastic-subjects ------------------------------------------------------------------------------------------------


                    $electiveSubject = $this->StudentMarks->Subjects->StudentElectiveSubjects->find()
									->select(['subject_id'])
									->where(['StudentElectiveSubjects.student_info_id'=>$studentInfos->id])
                                    ->toArray();
		            $subjects_id = [];
                    

                    if(!empty($electiveSubject)) { 

                        $subjects_parent_id = [];
                        $subjects_id        = [];     
                        
                        foreach($electiveSubject as $subject){ $subjects_id[] = $subject->subject_id; }

                        $whcondition['Subjects.id IN'] = $subjects_id;

                        $getprent_id = $this->StudentMarks->Subjects->find()->where($whcondition)->toArray();

                        foreach($getprent_id as $getpr) { $subjects_parent_id[] = $getpr->parent_id;}
		
		                if(!empty($getprent_id)) { $whconditionss['Subjects.id IN'] = $subjects_parent_id; }
                    }

                    $scholasticSubjects = $this->StudentMarks->Subjects->find('threaded')
                        ->contain(['Exams'=>function($q) use($examMasterMainIDArray){
                            return $q->where(['rght-lft'=>1,'Exams.id IN'=>$examMasterMainIDArray])
                                    ->order(['Exams.order_number'=>'ASC']);
                        }])->where([
                                'student_class_id' => $getClassMapping->student_class_id,
                                'stream_id'        => $getClassMapping->stream_id,
                                'subject_type_id'  => 1,
                                'elective'         => 'No',
                                'Subjects.session_year_id' => $getSessionYearID,
                                'Subjects.is_deleted'=>'N'])
                        ->orWhere(@$whconditionss)
                        ->orWhere(@$whcondition)
                        ->order(['Subjects.order_number'=>'ASC']); 

                    $storeScholasticSubjects[] = $scholasticSubjects;

                // @store-scholastic-subjects done :) ----------------------------------------------------------------------------------------

                // @store-none-scholastic-subjects ---------------------------------------------------------------------------------------

                    $noneScholasticSubjects = $this->StudentMarks->Subjects->find()
                        ->select($this->StudentMarks->Subjects)
                        ->select(['type'=>'SubjectTypes.name'])
                        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($query)use($studentInfos,$examMasterMainIDArray){
                            return $query
                                ->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])
                                ->where(['student_info_id' => $studentInfos->id,'exam_master_id IN' => $examMasterMainIDArray])
                                ->contain(['ExamMasters']);
                
                        }])->where([
                            'student_class_id'    => $getClassMapping->student_class_id,
                            'stream_id'           => $getClassMapping->stream_id,
                            'rght-lft'            => 1,
                            'subject_type_id'     => 2,
                            'Subjects.is_deleted' =>'N'
                        ])->toArray();

                    foreach ($noneScholasticSubjects as $key => $subject){ 

		                @$ii[$subject['parent_id']] += 1;
		                @$prashantsubject=$this->StudentMarks->Subjects->find()->where(['id'=>$subject['parent_id']]);
		                $noneScholasticSubjects[$key]['parentname']=@$prashantsubject->toArray()[0]->name;
            
                        if(empty($subject['student_marks'])) unset($noneScholasticSubjects[$key]);
                    }

                    $storeNoneScholasticSubjects[] = $noneScholasticSubjects;

                // @store-none-scholastic-subjects done :) ------------------------------------------------------------------------ 

            }

            $getStudentsListFirst[] = $getStudentsList[0];

        $this->set(compact(
            'getStudentsList','getSessionName','storeStudentExams','storeScholasticSubjects',
            'storeStudentMarks','getGradeMasters','getClassMappingAndEmployee','component',
            'getStudentsListFirst','storeStudentExamAttendances','storeNoneScholasticSubjects',
        
        
        'sy_name','sy_id','attitude_subjects','personality_subjects','ii','student','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
 
        }

    // ---------------------------------------------------------------------------------------------------------------------










	public function viewMarkSheetxi($student_info_id,$student_class_id,$exam_master_id,$last,$stream_id=null,$section_id=null)
    { 
    $com = $this->loadComponent('Grade');
        $where['student_class_id'] = $student_class_id;
        
        if($stream_id==0)
        {
             $where['stream_id'] = '';
        }else{
            $where['stream_id'] = $stream_id;
        }
		 $sy_id = $this->Auth->user('session_year_id');
       $infodata=$this->StudentMarks->ClassMappings->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id,'section_id'=>$section_id,'ClassMappings.session_year_id'=>$sy_id])->contain(['employees']);
   //    pr($infodata);die;
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id,'session_year_id'=>$sy_id]);
     // pr($infogread->toArray());die;
       
		$sy_name = $this->Auth->user('session_name'); 
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
       
//       $examattendances = $this->StudentMarks->ExamAttendances->find()->where(['ExamAttendances.student_id'=>$student['student']->id,'ExamAttendances.exam_id IN'=>$exam_master_id]);
//    $att=$examattendances->toArray();

$examattendances = $this->StudentMarks->ExamAttendances->find()->where([
    'ExamAttendances.student_id' => $student_info_id,
    'ExamAttendances.exam_id IN' => $exam_master_id]);
$att=$examattendances->toArray();
  
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N','ExamMasters.session_year_id'=>$sy_id]);
 //pr($exams->toArray());die;
        $marks = $this->StudentMarks->find()->where(['StudentMarks.student_info_id'=>$student_info_id,'StudentMarks.exam_master_id IN'=>$exam_master_id])->toArray();
               
     
	  foreach($marks as $key => $marksss)
	  {
		
		$maxmarkss  = $this->StudentMarks->ExamMaxMarks->find()->where(['ExamMaxMarks.exam_master_id'=>$marksss->exam_master_id,'ExamMaxMarks.subject_id'=>$marksss->subject_id])->toArray();
	$marks[$key]->marksmax=$maxmarkss[0]->max_marks;
	 
	 }
	// pr($marks);die;
         $electiveSubject = $this->StudentMarks->Subjects->StudentElectiveSubjects->find()
									->select(['subject_id'])
									->where(['StudentElectiveSubjects.student_info_id'=>$student_info_id]);
	
		$subjects_id = [];
		foreach($electiveSubject as $elec)
		{
			$subjects_id[]=$elec->subject_id;
		}
		if(!empty($electiveSubject))
		{
			$whcondition['Subjects.id IN'] = $subjects_id;
		}
      $subjects_parent_id = [];
       $getprent_id=$this->StudentMarks->Subjects->find()->where($whcondition);
	   foreach($getprent_id as $getpr)
		{
			$subjects_parent_id[]=$getpr->parent_id;
		}
		if(!empty($getprent_id))
		{
			$whconditionss['Subjects.id IN'] = $subjects_parent_id;
		}
	  // pr($getprent_id->toArray());die;
        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
		
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id,'Subjects.is_deleted'=>'N'])
		->orWhere(@$whconditionss)
		->orWhere(@$whcondition)
		->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);
   //pr($scholastic_subjects);die;
        $non_scholastic_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'exam_master_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>2,'Subjects.is_deleted ='=>'N']);
        
        $non_scholastic_subjects = json_decode(json_encode($non_scholastic_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($non_scholastic_subjects as $key => $subject)
		{ 
		@$ii[$subject['parent_id']]+=1;
		@$prashantsubject=$this->StudentMarks->Subjects->find()->where(['id'=>$subject['parent_id']]);
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
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'exam_master_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>4,'Subjects.is_deleted ='=>'N']);
        
        $personality_subjects = json_decode(json_encode($personality_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($personality_subjects as $key => $subject)
		{ 
            if(empty($subject['student_marks']))
            {
                unset($personality_subjects[$key]);
            }
 }
 //pr($ii);die;
 //pr($non_scholastic_subjects);die;
 $attitude_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>5,'Subjects.is_deleted ='=>'N']);
        
        $attitude_subjects = json_decode(json_encode($attitude_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($attitude_subjects as $key => $subject)
		{ 
            if(empty($subject['student_marks']))
            {
                unset($attitude_subjects[$key]);
            }
 }
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //pr($att);die;
        $this->set(compact('sy_name','sy_id','com','attitude_subjects','personality_subjects','ii','student','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }
	
	/*public function viewAllMarksheetxixii($student_info_id,$student_class_id,$exam_master_id,$last,$stream_id=null,$section_id=null)
    { 
    $com = $this->loadComponent('Grade');
        $where['student_class_id'] = $student_class_id;
        
        if($stream_id==0)
        {
             $where['stream_id'] = '';
        }else{
            $where['stream_id'] = $stream_id;
        }
		 $sy_id = $this->Auth->user('session_year_id');
       $infodata=$this->StudentMarks->ClassMappings->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id,'section_id'=>$section_id,'ClassMappings.session_year_id'=>$sy_id])->contain(['employees']);
   //    pr($infodata);die;
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id,'session_year_id'=>$sy_id]);
     // pr($infogread->toArray());die;
       
		$sy_name = $this->Auth->user('session_name'); 
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
       
      $examattendances = $this->StudentMarks->ExamAttendances->find()->where(['ExamAttendances.student_id'=>$student['student']->id,'ExamAttendances.exam_id IN'=>$exam_master_id]);
   $att=$examattendances->toArray();
  
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N','ExamMasters.session_year_id'=>$sy_id]);
 //pr($exams->toArray());die;
        $marks = $this->StudentMarks->find()->where(['StudentMarks.student_info_id'=>$student_info_id,'StudentMarks.exam_master_id IN'=>$exam_master_id])->toArray();
               
     
	  foreach($marks as $key => $marksss)
	  {
		
		$maxmarkss  = $this->StudentMarks->ExamMaxMarks->find()->where(['ExamMaxMarks.exam_master_id'=>$marksss->exam_master_id,'ExamMaxMarks.subject_id'=>$marksss->subject_id])->toArray();
	$marks[$key]->marksmax=$maxmarkss[0]->max_marks;
	 
	 }
	// pr($marks);die;
         $electiveSubject = $this->StudentMarks->Subjects->StudentElectiveSubjects->find()
									->select(['subject_id'])
									->where(['StudentElectiveSubjects.student_info_id'=>$student_info_id]);
	
		$subjects_id = [];
		foreach($electiveSubject as $elec)
		{
			$subjects_id[]=$elec->subject_id;
		}
		if(!empty($electiveSubject))
		{
			$whcondition['Subjects.id IN'] = $subjects_id;
		}
      $subjects_parent_id = [];
       $getprent_id=$this->StudentMarks->Subjects->find()->where($whcondition);
	   foreach($getprent_id as $getpr)
		{
			$subjects_parent_id[]=$getpr->parent_id;
		}
		if(!empty($getprent_id))
		{
			$whconditionss['Subjects.id IN'] = $subjects_parent_id;
		}
	  // pr($getprent_id->toArray());die;
        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
		
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id,'Subjects.is_deleted'=>'N'])
		->orWhere(@$whconditionss)
		->orWhere(@$whcondition)
		->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);
   //pr($scholastic_subjects);die;
        $non_scholastic_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'exam_master_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>2,'Subjects.is_deleted ='=>'N']);
        
        $non_scholastic_subjects = json_decode(json_encode($non_scholastic_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($non_scholastic_subjects as $key => $subject)
		{ 
		@$ii[$subject['parent_id']]+=1;
		@$prashantsubject=$this->StudentMarks->Subjects->find()->where(['id'=>$subject['parent_id']]);
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
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'exam_master_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>4,'Subjects.is_deleted ='=>'N']);
        
        $personality_subjects = json_decode(json_encode($personality_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($personality_subjects as $key => $subject)
		{ 
            if(empty($subject['student_marks']))
            {
                unset($personality_subjects[$key]);
            }
 }
 //pr($ii);die;
 //pr($non_scholastic_subjects);die;
 $attitude_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>5,'Subjects.is_deleted ='=>'N']);
        
        $attitude_subjects = json_decode(json_encode($attitude_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($attitude_subjects as $key => $subject)
		{ 
            if(empty($subject['student_marks']))
            {
                unset($attitude_subjects[$key]);
            }
 }
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //pr($att);die;
        $this->set(compact('sy_name','com','attitude_subjects','personality_subjects','ii','student','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }*/
	public function viewAllMarksheetxixii($class_mapping_id,$exam_master_id,$last)
    { 
	     $class_map=$this->StudentMarks->ClassMappings->get($class_mapping_id);
       // pr($class_map);exit;
        $where['student_class_id'] = $class_map->student_class_id;
        $com = $this->loadComponent('Grade');
        if($class_map)
        {
            $where['stream_id'] = $class_map->stream_id;
			
        }else{
            $where['stream_id'] = '';
        }
        $sy_id = $this->Auth->user('session_year_id');
       $infodata=$this->StudentMarks->ClassMappings->find()->where(['ClassMappings.student_class_id'=>$class_map->student_class_id,'ClassMappings.stream_id'=>$class_map->stream_id,'ClassMappings.section_id'=>$class_map->section_id,'ClassMappings.session_year_id'=>$sy_id])->contain(['Employees']);
      //pr($infodata->toArray());exit;
       
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$class_map->student_class_id,'stream_id IN'=>$class_map->stream_id,'session_year_id'=>$sy_id]);
    //pr($infogread->toArray());die;
       
		$sy_name = $this->Auth->user('session_name'); 
        $where = array_filter($where, function($value) { return $value != ''; });
        $this->viewBuilder()->setLayout('pdf');

        
        $students = $this->StudentMarks->StudentInfos->find()
        ->where(['StudentInfos.student_class_id'=>$class_map->student_class_id,'StudentInfos.stream_id'=>$class_map->stream_id,'StudentInfos.section_id'=>$class_map->section_id,'StudentInfos.result_hold'=>'Unhold','StudentInfos.session_year_id'=>$sy_id])
        ->contain(['Students','StudentClasses','Sections','Streams'])->order(['Students.name'=>'ASC']);
	//pr($students->toArray());die;
$student_info_ids=[];
        foreach ($students as $student) {
			
            $student_info_ids[]=$student->id;
   
   //pr($examattendances->toArray());exit;
        $marks_type = $student['student_class']->grade_type;
		}
		
        if($last == 0)
        {
          $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id])->where(['ExamMasters.session_year_id'=>$sy_id])->contain(['SubExams']);
		  if($student_class_id==1 or $student_class_id==2 or $student_class_id==3 or $student_class_id==4 or $student_class_id==5 ){
				if($exam_master_id==133 or $exam_master_id==134 or $exam_master_id==135 or $exam_master_id==136 or $exam_master_id==137)
				{
				$children = $this->StudentMarks->ExamMasters->find()->where(['ExamMasters.id'=>$exam_master_id])->contain(['SubExams']);
				}
			}
       }
       else{  
            $children = $this->StudentMarks->ExamMasters->find()->where([$where,'session_year_id'=>$sy_id])->order(['ExamMasters.order_number'=>'ASC'])->contain(['SubExams']);
         }  
    
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
       $examattendances = $this->StudentMarks->ExamAttendances->find()->where(['ExamAttendances.student_id IN'=>$student_info_ids,'ExamAttendances.exam_id IN'=>$exam_master_id]);
   $att=$examattendances->toArray();
      
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N','ExamMasters.session_year_id'=>$sy_id]);
    //pr($where);die;
	$marks=[];
		   foreach ($students as $student) {	
          
        $marks[$student->id] = $this->StudentMarks->find()->where(['StudentMarks.student_info_id'=>$student->id,'StudentMarks.exam_master_id IN'=>$exam_master_id])->toArray();
               
     
	 
	 
		   }
		 // pr($marks);die;
$scholastic_subjectsss = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
        ->where([$where,'subject_type_id'=>1,'Subjects.session_year_id'=>$sy_id])->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjectsss = json_decode(json_encode($scholastic_subjectsss->toArray()),true);
$subjectArr1=[];
 foreach ($students as $student) {	
    $electiveSubject = $this->StudentMarks->Subjects->StudentElectiveSubjects->find()
									->select(['subject_id'])
									->where(['StudentElectiveSubjects.student_info_id'=>$student->id])->first();
		$subjectArr1[@$student->id][]=$electiveSubject['subject_id'];
		foreach($scholastic_subjectsss as $scholasbjectsss)
		{
			//pr($scholasbjectsss);die;
			$subjectArr1[@$student->id][]=$scholasbjectsss['id'];
		}
 }
// pr($subjectArr1);die;
 
 
        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
        ->where([$where,'subject_type_id'=>1,'Subjects.session_year_id'=>$sy_id])->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);
//pr($scholastic_subjects);die;
        $non_scholastic_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_ids,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number','StudentMarks.student_info_id'])->where(['student_info_id IN'=>$student_info_ids,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>2,'Subjects.is_deleted ='=>'N','Subjects.session_year_id'=>$sy_id]);

        $non_scholastic_subjects = json_decode(json_encode($non_scholastic_subjects->toArray()),true);
  
        foreach ($non_scholastic_subjects as $key => $subject)
		{
			@$ii[$subject['parent_id']]+=1;
		@$prashantsubject=$this->StudentMarks->Subjects->find()->where(['id'=>$subject['parent_id']]);
		//pr();die;
		$non_scholastic_subjects[$key]['parentname']=@$prashantsubject->toArray()[0]->name;
            if(empty($subject['student_marks']))
            {
                unset($non_scholastic_subjects[$key]);
            }
         //  pr($non_scholastic_subjects);exit;
        }
 

      
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //pr($infodata->toArray());die;
        $this->set(compact('sy_name','com','subjectArr1','ii','students','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }

    public function markSheetScholar()
    {
        $studentMark = $this->StudentMarks->newEntity();
        $user_id=$this->Auth->User('id');
       
        if($this->request->is('post'))
        {  

            $students = $this->StudentMarks->StudentInfos->find()
            ->select($this->StudentMarks->StudentInfos)
            ->select(['name'=>'Students.name','scholer_no'=>'Students.scholar_no'])            
            ->where(['StudentInfos.session_year_id'=>3,'StudentInfos.roll_no'=>$this->request->data('roll_no'),'Students.scholar_no'=>$this->request->data('scholar_no')])
            ->where(['is_deleted'=>'N'])
            ->contain(['Students'])
            ->order(['Students.name ASC'])->first(); 

            if(empty($students->result_hold == 'Hold')){
                $this->Flash->success(__('Student Marksheet Is On Hold.'));

                return $this->redirect(['action' => 'markSheetScholar']);

            }

            if(empty($students)){
                $this->Flash->success(__('Student Record Not Found.'));

                return $this->redirect(['action' => 'markSheetScholar']);

            }
            $ClassMappings = $this->StudentMarks->ClassMappings->find()
                            ->where(['ClassMappings.session_year_id'=>3])
                            ->where(['ClassMappings.student_class_id'=>$students->student_class_id])
                            ->where(['ClassMappings.stream_id'=>$students->stream_id])
                            ->where(['ClassMappings.section_id'=>$students->section_id])
                            ->where(['ClassMappings.medium_id'=>$students->medium_id])
                            ->where(['ClassMappings.is_deleted'=>'N'])
                            ->contain(['Mediums','StudentClasses','Streams','Sections'])->first();

             

            $response = $this->StudentMarks->ExamMasters->find('threaded')
                        ->where(['ExamMasters.student_class_id'=>$ClassMappings->student_class_id,'ExamMasters.session_year_id'=>3,'ExamMasters.parent_id'=>0,'is_deleted'=>'N','stream_id'=>@$ClassMappings->stream_id])->order(['ExamMasters.order_number'=>'DESC'])->first();

            $student_info_id=$students->id;
            $student_class_id=$students->student_class_id;
            $exam_master_id=$response->id;
            $last=1;
            $stream_id=$students->stream_id;
            $section_id=$students->section_id;

            // echo "<pre>";print_r($ClassMappings);exit;
            if(strtoupper($ClassMappings->student_class->name) == 'NINTH' || strtoupper($ClassMappings->student_class->name) == 'TENTH'){

                 return $this->redirect(['controller'=>'StudentMarks','action' => 'viewMarkSheetixxWeb/'.$student_info_id,$student_class_id,$exam_master_id,$last,$stream_id,$section_id]);
            }
            else if(strtoupper($ClassMappings->student_class->name) == 'ELEVENTH'){
                return $this->redirect(['controller'=>'StudentMarks','action' => 'viewMarkSheetxiWeb/'.$student_info_id,$student_class_id,$exam_master_id,$last,$stream_id,$section_id]);
            }
            else{
                return $this->redirect(['controller'=>'StudentMarks','action' => 'viewMarkSheet1Web/'.$student_info_id,$student_class_id,$exam_master_id,$last,$stream_id,$section_id]);
             }              
           
        }
        //$mediums = $this->StudentMarks->Mediums->find('list');
        $this->set(compact('studentMark', 'sessionYears', 'studentInfos', 'examMasters', 'subjects','classMappings','students','ClassMappingssss'));
    }

    //---------------------------- Website Functions Start Here ----------------------------

    public function viewMarkSheet1Web($student_info_id,$student_class_id,$exam_master_id,$last,$stream_id=null,$section_id=null)
    { 
    
        $where['student_class_id'] = $student_class_id;
        $sy_id = 3;
        $sy_name = '(2021 - 2022)'; 
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
// pr($student);die;
   
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
       
      $sessionYearID = 3;
      $examattendances = $this->StudentMarks->ExamAttendances->find()
        ->where([
            'ExamAttendances.student_id' => $student->id,
            'ExamAttendances.exam_id IN' => $exam_master_id
        ])->order(['ExamMasters.order_number'=>'ASC'])
        ->contain(['ExamMasters' => function(\Cake\ORM\Query $query) use($sessionYearID){
            return $query->where(['ExamMasters.session_year_id' => $sessionYearID]);
        }]);
   $att=$examattendances->toArray();

 
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N','ExamMasters.session_year_id'=>$sy_id]);

        $marks = $this->StudentMarks->Results->find()->where(['student_info_id'=>$student_info_id,'exam_master_id IN'=>$exam_master_id])->contain(['ResultRows'=>function($q){
                return $q->order(['ExamMasters.order_number'=>'ASC'])->contain(['ExamMasters']);
            }]); 
        
        // $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
        //     ->contain(['Exams'=>function($q)use($exam_master_id){
        //         return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
        //     }])

        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id,'Exams.session_year_id'=>3])->order(['Exams.order_number'=>'ASC']);
            }])
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id,'Subjects.is_deleted'=>'N'])->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);
   // echo "<pre>"; print_r($scholastic_subjects);die;
        $non_scholastic_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>2,'Subjects.is_deleted ='=>'N','Subjects.session_year_id'=>$sy_id]);
        
        $non_scholastic_subjects = json_decode(json_encode($non_scholastic_subjects->toArray()),true);
  // pr($non_scholastic_subjects);die;
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
 //pr($ii);die;
 //pr($non_scholastic_subjects);die;
 $attitude_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>5,'Subjects.is_deleted ='=>'N','Subjects.session_year_id'=>$sy_id]);
        
        $attitude_subjects = json_decode(json_encode($attitude_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($attitude_subjects as $key => $subject)
        { 
            if(empty($subject['student_marks']))
            {
                unset($attitude_subjects[$key]);
            }
 }
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //echo '<pre>'; print_r($marks->toArray());die;
     

        $this->set(compact('sy_name','attitude_subjects','personality_subjects','ii','student','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }


    public function viewMarkSheetxiWeb($student_info_id,$student_class_id,$exam_master_id,$last,$stream_id=null,$section_id=null){ 

        $com = $this->loadComponent('Grade');

    
        $where['student_class_id'] = $student_class_id;
        
        if($stream_id==0)
        {
             $where['stream_id'] = '';
        }else{
            $where['stream_id'] = $stream_id;
        }
         $sy_id = 3;
       $infodata=$this->StudentMarks->ClassMappings->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id,'section_id'=>$section_id,'ClassMappings.session_year_id'=>$sy_id])->contain(['employees']);
   //    pr($infodata);die;
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id,'session_year_id'=>$sy_id]);
     // pr($infogread->toArray());die;
       
        $sy_name = '(2021 - 2022)'; 
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
       
       
      $examattendances = $this->StudentMarks->ExamAttendances->find()->where([
            'ExamAttendances.student_id' => $student_info_id,
            'ExamAttendances.exam_id IN' => $exam_master_id]);
   $att=$examattendances->toArray();

        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N','ExamMasters.session_year_id'=>$sy_id]);
 //pr($exams->toArray());die;
        $marks = $this->StudentMarks->find()->where(['StudentMarks.student_info_id'=>$student_info_id,'StudentMarks.exam_master_id IN'=>$exam_master_id])->toArray();
               
     
      foreach($marks as $key => $marksss)
      {
        
        $maxmarkss  = $this->StudentMarks->ExamMaxMarks->find()->where(['ExamMaxMarks.exam_master_id'=>$marksss->exam_master_id,'ExamMaxMarks.subject_id'=>$marksss->subject_id])->toArray();
    $marks[$key]->marksmax=$maxmarkss[0]->max_marks;
     
     }
    // pr($marks);die;
         $electiveSubject = $this->StudentMarks->Subjects->StudentElectiveSubjects->find()
                                    ->select(['subject_id'])
                                    ->where(['StudentElectiveSubjects.student_info_id'=>$student_info_id]);
    
        $subjects_id = [];
        foreach($electiveSubject as $elec)
        {
            $subjects_id[]=$elec->subject_id;
        }
        if(!empty($electiveSubject))
        {
            $whcondition['Subjects.id IN'] = $subjects_id;
        }
      $subjects_parent_id = [];
       $getprent_id=$this->StudentMarks->Subjects->find()->where($whcondition);
       foreach($getprent_id as $getpr)
        {
            $subjects_parent_id[]=$getpr->parent_id;
        }
        if(!empty($getprent_id))
        {
            $whconditionss['Subjects.id IN'] = $subjects_parent_id;
        }
      // pr($getprent_id->toArray());die;
        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
        
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id,'Subjects.is_deleted'=>'N'])
        ->orWhere(@$whconditionss)
        ->orWhere(@$whcondition)
        ->order(['Subjects.order_number'=>'ASC']);


        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);
   //pr($scholastic_subjects);die;
        $non_scholastic_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'exam_master_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>2,'Subjects.is_deleted ='=>'N']);
        
        $non_scholastic_subjects = json_decode(json_encode($non_scholastic_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($non_scholastic_subjects as $key => $subject)
        { 
        @$ii[$subject['parent_id']]+=1;
        @$prashantsubject=$this->StudentMarks->Subjects->find()->where(['id'=>$subject['parent_id']]);
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
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'exam_master_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>4,'Subjects.is_deleted ='=>'N']);
        
        $personality_subjects = json_decode(json_encode($personality_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($personality_subjects as $key => $subject)
        { 
            if(empty($subject['student_marks']))
            {
                unset($personality_subjects[$key]);
            }
 }
 //pr($ii);die;
 //pr($non_scholastic_subjects);die;
 $attitude_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>5,'Subjects.is_deleted ='=>'N']);
        
        $attitude_subjects = json_decode(json_encode($attitude_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($attitude_subjects as $key => $subject)
        { 
            if(empty($subject['student_marks']))
            {
                unset($attitude_subjects[$key]);
            }
 }
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //pr($att);die;
        $this->set(compact('sy_name','sy_id','com','attitude_subjects','personality_subjects','ii','student','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }

    public function viewMarkSheetixxWeb($student_info_id,$student_class_id,$exam_master_id,$last,$stream_id=null,$section_id=null)
    { 
    
        $where['student_class_id'] = $student_class_id;
         $sy_id = 3;
        $sy_name = '(2021 - 2022)'; 
        if($stream_id==0)
        {
             $where['stream_id'] = '';
        }else{
            $where['stream_id'] = $stream_id;
        }
       $infodata=$this->StudentMarks->ClassMappings->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id,'section_id'=>$section_id,'ClassMappings.session_year_id'=>$sy_id])->contain(['employees']);
      // pr($infodata);die;
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id,'session_year_id'=>$sy_id]);
     // pr($infogread->toArray());die;
       
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
                $children = $this->StudentMarks->ExamMasters->find()->where(['ExamMasters.id'=>$exam_master_id])->contain(['SubExams']);
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
       
      $examattendances = $this->StudentMarks->ExamAttendances->find()->where(['ExamAttendances.student_id'=>$student['student']->id,'ExamAttendances.exam_id IN'=>$exam_master_id]);
   $att=$examattendances->toArray();
  // pr($att);die;
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N']);

        $marks = $this->StudentMarks->Results->find()->where(['student_info_id'=>$student_info_id,'exam_master_id IN'=>$exam_master_id])->contain(['ResultRows'=>function($q){
                return $q->order(['ExamMasters.order_number'=>'ASC'])->contain(['ExamMasters']);
            }]); 
        $electiveSubject = $this->StudentMarks->Subjects->StudentElectiveSubjects->find()
                                    ->select(['subject_id'])
                                    ->where(['StudentElectiveSubjects.student_info_id'=>$student_info_id])->first();
        if(!empty($electiveSubject))
        {
            $whcondition['Subjects.id'] = $electiveSubject->subject_id;
        }
       // pr($whcondition);die;

        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id,'Subjects.is_deleted'=>'N'])
        ->orWhere(@$whcondition)
        ->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);
  // pr($scholastic_subjects);die;
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
        @$prashantsubject=$this->StudentMarks->Subjects->find()->where(['id'=>$subject['parent_id']]);
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
  //  pr($non_scholastic_subjects);die;
        foreach ($personality_subjects as $key => $subject)
        { 
            if(empty($subject['student_marks']))
            {
                unset($personality_subjects[$key]);
            }
 }
 //pr($ii);die;
 //pr($non_scholastic_subjects);die;
 $attitude_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>5,'Subjects.is_deleted ='=>'N','Subjects.session_year_id'=>$sy_id]);
        
        $attitude_subjects = json_decode(json_encode($attitude_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($attitude_subjects as $key => $subject)
        { 
            if(empty($subject['student_marks']))
            {
                unset($attitude_subjects[$key]);
            }
 }
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //pr($att);die;
        $this->set(compact('sy_name','attitude_subjects','personality_subjects','ii','student','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }


    //--------------------------------Website Function End Here------------------------------------------------

	public function viewMarkSheet1($student_info_id,$student_class_id,$exam_master_id,$last,$stream_id=null,$section_id=null)
    { 
    
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

        $student_image = $this->StudentMarks->StudentInfos->find()->where(['student_id'=> $student->student->id,'session_year_id'=>3])->first()->student_image;
// pr($student_image);die;
   
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
//   pr($children->toArray());die;
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
       
//       $examattendances = $this->StudentMarks->ExamAttendances->find()->where(['ExamAttendances.student_id'=>$student->id,'ExamAttendances.exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
//    $att=$examattendances->toArray();

   $sessionYearID = $this->Auth->user('session_year_id');
   $examattendances = $this->StudentMarks->ExamAttendances->find()
     ->where([
         'ExamAttendances.student_id' => $student->id,
         'ExamAttendances.exam_id IN' => $exam_master_id
     ])->order(['ExamMasters.order_number'=>'ASC'])
     ->contain(['ExamMasters' => function(\Cake\ORM\Query $query) use($sessionYearID){
         return $query->where(['ExamMasters.session_year_id' => $sessionYearID]);
     }]);
$att=$examattendances->toArray();



 // pr($att);die;
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id,'ExamMasters.is_deleted'=>'N','ExamMasters.session_year_id'=>$sy_id]);
    //  pr($exams->toArray());die;
        $marks = $this->StudentMarks->Results->find()->where(['student_info_id'=>$student_info_id,'exam_master_id IN'=>$exam_master_id])->contain(['ResultRows'=>function($q){
                return $q->order(['ExamMasters.order_number'=>'ASC'])->contain(['ExamMasters']);
            }]); 
        
        
// pr($marks->toArray());die;
        // $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
        //     ->contain(['Exams'=>function($q)use($exam_master_id){
        //         return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
        //     }])
        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id,'Exams.session_year_id'=>$this->Auth->user('session_year_id')])->order(['Exams.order_number'=>'ASC']);
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
 //pr($ii);die;
 //pr($non_scholastic_subjects);die;
 $attitude_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>5,'Subjects.is_deleted ='=>'N','Subjects.session_year_id'=>$sy_id]);
        
        $attitude_subjects = json_decode(json_encode($attitude_subjects->toArray()),true);
  //  pr($non_scholastic_subjects);die;
        foreach ($attitude_subjects as $key => $subject)
		{ 
            if(empty($subject['student_marks']))
            {
                unset($attitude_subjects[$key]);
            }
 }
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //pr($att);die;
        $this->set(compact('sy_name','attitude_subjects','personality_subjects','ii','student','student_image','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }
/*public function viewAllMarksheet($class_mapping_id,$exam_master_id)
    { 
       $class_map=$this->StudentMarks->ClassMappings->get($class_mapping_id);
       // pr($class_map);exit;
        $where['student_class_id'] = $class_map->student_class_id;
        
        if($class_map)
        {
             $where['stream_id'] = '';
        }else{
            $where['stream_id'] = $class_map->stream_id;
        }
       
       $infodata=$this->StudentMarks->ClassMappings->find()->where(['ClassMappings.student_class_id'=>$class_map->student_class_id,'ClassMappings.stream_id'=>$class_map->stream_id])->contain(['Employees']);
      //pr($infodata->toArray());exit;
       
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$class_map->student_class_id,'stream_id IN'=>$class_map->stream_id]);
    //pr($infogread->toArray());die;
        $sy_id = $this->Auth->user('session_year_id');
        $where = array_filter($where, function($value) { return $value != ''; });
        $this->viewBuilder()->setLayout('pdf');

        
        $students = $this->StudentMarks->StudentInfos->find()
        ->where(['StudentInfos.student_class_id IN'=>$class_map->student_class_id,'StudentInfos.stream_id IN'=>$class_map->stream_id])
        ->contain(['Students','StudentClasses','Sections','Streams']);
//pr($students->toArray());die;
$student_info_ids=[];
        foreach ($students as $student) {
            
            $student_info_ids[]=$student->id;
   $examattendances = $this->StudentMarks->ExamAttendances->find()->where(['ExamAttendances.student_id IN'=>$student['student']->id]);
   $att=$examattendances->toArray();
   //pr($examattendances->toArray());exit;
        $marks_type = $student['student_class']->grade_type;
        }
       // if($last == 0)
        //{
           // $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id])->contain(['SubExams']);
        //}
       // else{  
            $children = $this->StudentMarks->ExamMasters->find()->where([$where,'session_year_id'=>$sy_id])->order(['ExamMasters.order_number'=>'ASC'])->contain(['SubExams']);
        //  }  
    
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
       
      
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id]);

        $marks = $this->StudentMarks->Results->find()->where(['student_info_id IN'=>$student_info_ids,'exam_master_id IN'=>$exam_master_id])->contain(['ResultRows'=>function($q){
                return $q->order(['ExamMasters.order_number'=>'ASC'])->contain(['ExamMasters']);
            }]); 
        

        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id])->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);

        $non_scholastic_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_ids,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id IN'=>$student_info_ids,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>2,'Subjects.is_deleted ='=>'N']);

        $non_scholastic_subjects = json_decode(json_encode($non_scholastic_subjects->toArray()),true);
  
        foreach ($non_scholastic_subjects as $key => $subject)
            if(empty($subject['student_marks']))
            {
                unset($non_scholastic_subjects[$key]);
            }
           // pr($scholastic_subjects);exit;
        
 
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //pr($marks->toArray());die;
        $this->set(compact('students','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }*/
	public function viewAllMarksheet($class_mapping_id,$exam_master_id,$last)
    { 
	 $com = $this->loadComponent('Grade');
       $class_map=$this->StudentMarks->ClassMappings->get($class_mapping_id);
       // pr($class_map);exit;
        $where['student_class_id'] = $class_map->student_class_id;
        
        if($class_map)
        {
             $where['stream_id'] = '';
        }else{
            $where['stream_id'] = $class_map->stream_id;
            $where['section_id'] = $class_map->section_id;
        }
      // pr($where);
	   $sy_id = $this->Auth->user('session_year_id'); 
       $infodata=$this->StudentMarks->ClassMappings->find()->where(['ClassMappings.student_class_id'=>$class_map->student_class_id,'ClassMappings.stream_id'=>$class_map->stream_id,'ClassMappings.section_id'=>$class_map->section_id,'ClassMappings.session_year_id'=>$sy_id])->contain(['Employees']);
      //pr($infodata->toArray());exit;
       
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$class_map->student_class_id,'stream_id IN'=>$class_map->stream_id,'session_year_id'=>$sy_id]);
    //pr($infogread->toArray());die;
       
        $sy_name = $this->Auth->user('session_name'); 
		//pr();die;
		
        $where = array_filter($where, function($value) { return $value != ''; });
        $this->viewBuilder()->setLayout('pdf');

        
        $students = $this->StudentMarks->StudentInfos->find()
        ->where(['StudentInfos.student_class_id'=>$class_map->student_class_id,'StudentInfos.stream_id'=>$class_map->stream_id,'StudentInfos.section_id'=>$class_map->section_id,'StudentInfos.result_hold'=>'Unhold','StudentInfos.session_year_id'=>$sy_id,'StudentInfos.student_status'=>'Continue'])
        ->contain(['Students','StudentClasses','Sections','Streams','StudentElectiveSubjects'])->order(['Students.name'=>'ASC']);

$student_info_ids=[];
        foreach ($students as $student) {



			
            $student_info_ids[]=$student->id;
   
   //pr($examattendances->toArray());exit;
        $marks_type = $student['student_class']->grade_type;
		}
		
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
       $examattendances = $this->StudentMarks->ExamAttendances->find()->where(['ExamAttendances.student_id IN'=>$student_info_ids,'ExamAttendances.exam_id IN'=>$exam_master_id,'ExamAttendances.class_id'=>$class_map->student_class_id,'ExamAttendances.stream_id'=>$class_map->stream_id,'ExamAttendances.section_id'=>$class_map->section_id])->contain(['ExamMasters']);
   $att=$examattendances->toArray();
      
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id,'ExamMasters.session_year_id'=>$sy_id]);
 
		   foreach ($students as $student) {	
          
        $marks[$student->id] = $this->StudentMarks->Results->find()->where(['student_info_id'=>$student->id,'exam_master_id IN'=>$exam_master_id])->contain(['ResultRows'=>function($q){
                return $q->order(['ExamMasters.order_number'=>'ASC'])->contain(['ExamMasters']);
            }])->toArray(); 
		   }
//pr($marks);die;
        // $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
        //     ->contain(['Exams'=>function($q)use($exam_master_id){
        //         return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
        //     }])
        // ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id])->order(['Subjects.order_number'=>'ASC']);



        if($class_map->student_class_id == 12) {
            
            $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where([
                    'rght-lft'=>1,
                    'Exams.id IN'=>$exam_master_id,
                    'Exams.session_year_id' => $this->Auth->user('session_year_id'
                )])->order(['Exams.order_number'=>'ASC']);
            }])
            ->where([$where,'subject_type_id'=>1,'Subjects.session_year_id'=>$sy_id])->order(['Subjects.order_number'=>'ASC']);

        }


       else {
            $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where([
                    'rght-lft'=>1,
                    'Exams.id IN'=>$exam_master_id,
                    'Exams.session_year_id' => $this->Auth->user('session_year_id'
                )])->order(['Exams.order_number'=>'ASC']);
            }])
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id])->order(['Subjects.order_number'=>'ASC']);

       }


        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);
//pr($scholastic_subjects);die;
        $non_scholastic_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_ids,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number','StudentMarks.student_info_id'])->where(['student_info_id IN'=>$student_info_ids,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>2,'Subjects.is_deleted ='=>'N','Subjects.session_year_id'=>$sy_id]);

        $non_scholastic_subjects = json_decode(json_encode($non_scholastic_subjects->toArray()),true);
  //echo '<pre>'; print_r($non_scholastic_subjects);die;
        foreach ($non_scholastic_subjects as $key => $subject)
		{
			@$ii[$subject['parent_id']]+=1;
		@$prashantsubject=$this->StudentMarks->Subjects->find()->where(['id'=>$subject['parent_id']]);
		//pr();die;
		$non_scholastic_subjects[$key]['parentname']=@$prashantsubject->toArray()[0]->name;
            if(empty($subject['student_marks']))
            {
                unset($non_scholastic_subjects[$key]);
            }
         //  pr($non_scholastic_subjects);exit;
        }
 
//pr($scholastic_subjects);die;
        $personality_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_ids,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number','StudentMarks.student_info_id'])->where(['student_info_id IN'=>$student_info_ids,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>4,'Subjects.is_deleted ='=>'N','Subjects.session_year_id'=>$sy_id]);

        $personality_subjects = json_decode(json_encode($personality_subjects->toArray()),true);
  
        foreach ($personality_subjects as $key => $subject)
		{
			
            if(empty($subject['student_marks']))
            {
                unset($personality_subjects[$key]);
            }
         //  pr($non_scholastic_subjects);exit;
        }
		
		$attitude_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_ids,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number','StudentMarks.student_info_id'])->where(['student_info_id IN'=>$student_info_ids,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>5,'Subjects.is_deleted ='=>'N','Subjects.session_year_id'=>$sy_id]);

        $attitude_subjects = json_decode(json_encode($attitude_subjects->toArray()),true);
  
        foreach ($attitude_subjects as $key => $subject)
		{
			
            if(empty($subject['student_marks']))
            {
                unset($attitude_subjects[$key]);
            }
         //  pr($non_scholastic_subjects);exit;
        }
 
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //pr($infodata->toArray());die;
        $this->set(compact('sy_name','sy_id','com','ii','attitude_subjects','personality_subjects','students','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }
	
	
	public function crossClassReport1($class_mapping_id,$exam_master_id,$last)
    { 
	$class_mapping_id=84;
	$exam_master_id=133;
	$last=0;
       $class_map=$this->StudentMarks->ClassMappings->get($class_mapping_id);
       // pr($class_map);exit;
        $where['student_class_id'] = $class_map->student_class_id;
        
        if($class_map)
        {
             $where['stream_id'] = '';
        }else{
            $where['stream_id'] = $class_map->stream_id;
        }
       
       $infodata=$this->StudentMarks->ClassMappings->find()->where(['ClassMappings.student_class_id'=>$class_map->student_class_id,'ClassMappings.stream_id'=>$class_map->stream_id])->contain(['Employees']);
      //pr($infodata->toArray());exit;
       
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$class_map->student_class_id,'stream_id IN'=>$class_map->stream_id]);
    //pr($infogread->toArray());die;
        $sy_id = $this->Auth->user('session_year_id');
        $where = array_filter($where, function($value) { return $value != ''; });
        $this->viewBuilder()->setLayout('pdf');

        
        $students = $this->StudentMarks->StudentInfos->find()
        ->where(['StudentInfos.student_class_id'=>$class_map->student_class_id,'StudentInfos.stream_id'=>$class_map->stream_id,'StudentInfos.section_id'=>$class_map->section_id])
        ->contain(['Students','StudentClasses','Sections','Streams'])->order(['Students.name'=>'ASC']);
//pr($students->toArray());die;
$student_info_ids=[];
        foreach ($students as $student) {
			
            $student_info_ids[]=$student->id;
   
   //pr($examattendances->toArray());exit;
        $marks_type = $student['student_class']->grade_type;
		}
		
        if($last == 0)
        {
          $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id])->contain(['SubExams']);
		  if($student_class_id==1 or $student_class_id==2 or $student_class_id==3 or $student_class_id==4 or $student_class_id==5 ){
				if($exam_master_id==133 or $exam_master_id==134 or $exam_master_id==135 or $exam_master_id==136 or $exam_master_id==137)
				{
				$children = $this->StudentMarks->ExamMasters->find()->where(['ExamMasters.id'=>$exam_master_id])->contain(['SubExams']);
				}
			}
       }
       else{  
            $children = $this->StudentMarks->ExamMasters->find()->where([$where,'session_year_id'=>$sy_id])->order(['ExamMasters.order_number'=>'ASC'])->contain(['SubExams']);
         }  
    
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
       $examattendances = $this->StudentMarks->ExamAttendances->find()->where(['ExamAttendances.student_id IN'=>$student_info_ids,'ExamAttendances.exam_id IN'=>$exam_master_id]);
   $att=$examattendances->toArray();
      
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id]);
 
		   foreach ($students as $student) {	
          
        $marks[$student->id] = $this->StudentMarks->Results->find()->where(['student_info_id'=>$student->id,'exam_master_id IN'=>$exam_master_id])->contain(['ResultRows'=>function($q){
                return $q->order(['ExamMasters.order_number'=>'ASC'])->contain(['ExamMasters']);
            }])->toArray(); 
		   }
//pr($marks);die;
        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id])->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);
//pr($scholastic_subjects);die;
        $non_scholastic_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_ids,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number','StudentMarks.student_info_id'])->where(['student_info_id IN'=>$student_info_ids,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>2,'Subjects.is_deleted ='=>'N']);

        $non_scholastic_subjects = json_decode(json_encode($non_scholastic_subjects->toArray()),true);
  
        foreach ($non_scholastic_subjects as $key => $subject)
		{
			@$ii[$subject['parent_id']]+=1;
		@$prashantsubject=$this->StudentMarks->Subjects->find()->where(['id'=>$subject['parent_id']]);
		//pr();die;
		$non_scholastic_subjects[$key]['parentname']=@$prashantsubject->toArray()[0]->name;
            if(empty($subject['student_marks']))
            {
                unset($non_scholastic_subjects[$key]);
            }
         //  pr($non_scholastic_subjects);exit;
        }
 
//pr($scholastic_subjects);die;
        $personality_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_ids,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number','StudentMarks.student_info_id'])->where(['student_info_id IN'=>$student_info_ids,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>4,'Subjects.is_deleted ='=>'N']);

        $personality_subjects = json_decode(json_encode($personality_subjects->toArray()),true);
  
        foreach ($personality_subjects as $key => $subject)
		{
			
            if(empty($subject['student_marks']))
            {
                unset($personality_subjects[$key]);
            }
         //  pr($non_scholastic_subjects);exit;
        }
		
		$attitude_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_ids,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number','StudentMarks.student_info_id'])->where(['student_info_id IN'=>$student_info_ids,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>5,'Subjects.is_deleted ='=>'N']);

        $attitude_subjects = json_decode(json_encode($attitude_subjects->toArray()),true);
  
        foreach ($attitude_subjects as $key => $subject)
		{
			
            if(empty($subject['student_marks']))
            {
                unset($attitude_subjects[$key]);
            }
         //  pr($non_scholastic_subjects);exit;
        }
 
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //pr($infodata->toArray());die;
        $this->set(compact('com','ii','attitude_subjects','personality_subjects','students','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }
	/* back up on 20_2_2020*//*
public function viewAllMarksheet($class_mapping_id,$exam_master_id,$last)
    { 
       $class_map=$this->StudentMarks->ClassMappings->get($class_mapping_id);
       // pr($class_map);exit;
        $where['student_class_id'] = $class_map->student_class_id;
        
        if($class_map)
        {
             $where['stream_id'] = '';
        }else{
            $where['stream_id'] = $class_map->stream_id;
        }
       
       $infodata=$this->StudentMarks->ClassMappings->find()->where(['ClassMappings.student_class_id'=>$class_map->student_class_id,'ClassMappings.stream_id'=>$class_map->stream_id])->contain(['Employees']);
      //pr($infodata->toArray());exit;
       
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$class_map->student_class_id,'stream_id IN'=>$class_map->stream_id]);
    //pr($infogread->toArray());die;
        $sy_id = $this->Auth->user('session_year_id');
        $where = array_filter($where, function($value) { return $value != ''; });
        $this->viewBuilder()->setLayout('pdf');

        
        $students = $this->StudentMarks->StudentInfos->find()
        ->where(['StudentInfos.student_class_id'=>$class_map->student_class_id,'StudentInfos.stream_id'=>$class_map->stream_id,'StudentInfos.section_id'=>$class_map->section_id])
        ->contain(['Students','StudentClasses','Sections','Streams'])->order(['Students.name'=>'ASC']);
//pr($students->toArray());die;
$student_info_ids=[];
        foreach ($students as $student) {
			
            $student_info_ids[]=$student->id;
   
   //pr($examattendances->toArray());exit;
        $marks_type = $student['student_class']->grade_type;
		}
		$examattendances = $this->StudentMarks->ExamAttendances->find()->where(['ExamAttendances.student_id IN'=>$student_info_ids]);
   $att=$examattendances->toArray();
        if($last == 0)
        {
          $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id])->contain(['SubExams']);
       }
       else{  
            $children = $this->StudentMarks->ExamMasters->find()->where([$where,'session_year_id'=>$sy_id])->order(['ExamMasters.order_number'=>'ASC'])->contain(['SubExams']);
         }  
    
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
       
      
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->order(['ExamMasters.order_number'=>'ASC'])->where([$where,'id IN'=>$exam_master_id]);
 
		   foreach ($students as $student) {	
          
        $marks[$student->id] = $this->StudentMarks->Results->find()->where(['student_info_id'=>$student->id,'exam_master_id IN'=>$exam_master_id])->contain(['ResultRows'=>function($q){
                return $q->order(['ExamMasters.order_number'=>'ASC'])->contain(['ExamMasters']);
            }])->toArray(); 
		   }
//pr($marks);die;
        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id])->order(['Exams.order_number'=>'ASC']);
            }])
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id])->order(['Subjects.order_number'=>'ASC']);

        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);
//pr($scholastic_subjects);die;
        $non_scholastic_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_ids,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number','StudentMarks.student_info_id'])->where(['student_info_id IN'=>$student_info_ids,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>2,'Subjects.is_deleted ='=>'N']);

        $non_scholastic_subjects = json_decode(json_encode($non_scholastic_subjects->toArray()),true);
  
        foreach ($non_scholastic_subjects as $key => $subject)
            if(empty($subject['student_marks']))
            {
                unset($non_scholastic_subjects[$key]);
            }
         //  pr($non_scholastic_subjects);exit;
        
 
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //pr($marks->toArray());die;
        $this->set(compact('students','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread','att'));
    }*/
    public function markSheet()
    {
        $studentMark = $this->StudentMarks->newEntity();
        if ($this->request->is('post')) {
            $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'));
//pr($class_mapping);die;
            $students = $this->StudentMarks->StudentInfos->find()
            ->select($this->StudentMarks->StudentInfos)
            ->select(['name'=>'Students.name','scholer_no'=>'Students.scholar_no'])
            ->where(['student_class_id'=>$class_mapping->student_class_id])
            ->where(['section_id'=>$class_mapping->section_id])
            ->where(['stream_id'=>$class_mapping->stream_id])
			->where(['StudentInfos.session_year_id'=>$this->Auth->user('session_year_id')])
            ->where(['is_deleted'=>'N'])
            ->contain(['Students'])
            ->order(['Students.name ASC']);
				$ClassMappingssss = $this->StudentMarks->ClassMappings->find()->where(['ClassMappings.id'=>$this->request->getData('class_mapping_id')])->contain(['Mediums','StudentClasses','Streams','Sections']);
            
        }

        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }

        //$mediums = $this->StudentMarks->Mediums->find('list');
        $this->set(compact('studentMark', 'sessionYears', 'studentInfos', 'examMasters', 'subjects','classMappings','students','ClassMappingssss'));
    }
	
	 public function uploadPhoto()
    {
        $studentMark = $this->StudentMarks->newEntity();
		
			
        if ($this->request->is('post')) {
			//pr($std_id);exit;
			@$std_image=$this->request->getData('student_image');
			@$std_id=$this->request->getData('std_id');
			@$class_mapping_id=$this->request->getData('class_mapping_id');
			$class_mapping = $this->StudentMarks->ClassMappings->get($class_mapping_id, [
            'contain' => ['StudentClasses', 'Sections', 'Streams' ,'Mediums']
        ]);
//pr($class_mapping);exit;
			
			if(!empty($std_image['name']))
			{
				$file = $std_image;
				$file_name=$file['name'];
				$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
				$arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
				$setNewFileName = uniqid();
				$image_name= $setNewFileName.'.'.$ext;
				//move_uploaded_file($file['tmp_name'], WWW_ROOT .$img_name);
				//$uploads_dir =new Folder();
				//$uploads_dir->create(WWW_ROOT . '/img/studentimage/'.$class_mapping->student_class->name.' '.$class_mapping->stream->name.' '.$class_mapping->section->name);
				//move_uploaded_file($file['tmp_name'],'img/studentimage/'.$class_mapping->student_class->name.' '.$class_mapping->stream->name.' '.$class_mapping->section->name.'/'.$image_name);
				$keyname = 'StudentImage/'.$class_mapping->student_class->name.' '.$class_mapping->stream->name.' '.$class_mapping->section->name.'/'.$image_name;
				$this->AwsFile->putObjectFile($keyname,$file['tmp_name'],$file['type']);
				$img_name = 'StudentImage/'.$class_mapping->student_class->name.' '.$class_mapping->stream->name.' '.$class_mapping->section->name.'/'.$image_name;
				$query = $this->StudentMarks->StudentInfos->query();
				$result = $query->update()
						->set(['student_image' => $img_name])
						->where(['id' => $std_id])
						->execute();
			}
           
            $students = $this->StudentMarks->StudentInfos->find()
            ->select($this->StudentMarks->StudentInfos)
            ->select(['name'=>'Students.name','scholer_no'=>'Students.scholar_no'])
            ->where(['student_class_id'=>$class_mapping->student_class_id])
            ->where(['section_id'=>$class_mapping->section_id])
            ->where(['stream_id'=>$class_mapping->stream_id])
			 ->where(['StudentInfos.session_year_id'=>$this->Auth->user('session_year_id')])
            ->where(['is_deleted'=>'N'])
            ->contain(['Students'])
            ->order(['Students.name ASC']);
			
			$ClassMappingssss = $this->StudentMarks->ClassMappings->find()->where(['ClassMappings.id'=>$this->request->getData('class_mapping_id')])->contain(['Mediums','StudentClasses','Streams','Sections']);
			
       
        }

        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
            
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }

        //$mediums = $this->StudentMarks->Mediums->find('list');
        $this->set(compact('class_mapping','class_mapping_id','studentMark', 'sessionYears', 'studentInfos', 'examMasters', 'subjects','classMappings','students','ClassMappingssss'));
    }

/*    public function viewMarkSheet1($student_info_id,$student_class_id,$exam_master_id,$last,$stream_id=null)
    { 
    
        $where['student_class_id'] = $student_class_id;
        
        if($stream_id==0)
        {
             $where['stream_id'] = '';
        }else{
            $where['stream_id'] = $stream_id;
        }
       $infodata=$this->StudentMarks->ClassMappings->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id])->contain(['employees']);
       
        $infogread=$this->StudentMarks->GradeMasters->find()->where(['student_class_id'=>$student_class_id,'stream_id'=>$stream_id]);
     // pr($infogread->toArray());die;
        $sy_id = $this->Auth->user('session_year_id');
        $where = array_filter($where, function($value) { return $value != ''; });
        $this->viewBuilder()->setLayout('pdf');

        
        $student = $this->StudentMarks->StudentInfos->get($student_info_id, [
            'contain' => ['Students','StudentClasses','Sections','Streams']
        ]);

        $marks_type = $student->student_class->grade_type;

        /*  if($last == 0)
        {
            $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id])->contain(['SubExams']);
        }
        else{  
            $children = $this->StudentMarks->ExamMasters->find()->where([$where,'session_year_id'=>$sy_id])->contain(['SubExams']);
        }
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
       
     //  pr($exam_master_id);die;
        $exams = $this->StudentMarks->ExamMasters->find('threaded')->where([$where,'id IN'=>$exam_master_id]);

        $marks = $this->StudentMarks->ExamMasters->Results->find()->where(['student_info_id'=>$student_info_id,'exam_master_id IN'=>$exam_master_id])->contain(['ResultRows']);
        
        //  pr($marks->toArray());die;
        //
//
        $scholastic_subjects = $this->StudentMarks->Subjects->find('threaded')
            ->contain(['Exams'=>function($q)use($exam_master_id){
                return $q->where(['rght-lft'=>1,'Exams.id IN'=>$exam_master_id]);
            }])
        ->where([$where,'subject_type_id'=>1,'elective'=>'No','Subjects.session_year_id'=>$sy_id]);
//pr($scholastic_subjects->toArray());exit;
        $scholastic_subjects = json_decode(json_encode($scholastic_subjects->toArray()),true);

        $non_scholastic_subjects = $this->StudentMarks->Subjects->find()
        ->select($this->StudentMarks->Subjects)
        ->select(['type'=>'SubjectTypes.name'])
        ->contain(['SubjectTypes','ExamMaxMarks','StudentMarks'=>function($q)use($student_info_id,$exam_master_id){
                    return $q->select(['StudentMarks.id','StudentMarks.subject_id','exam'=>'ExamMasters.name','StudentMarks.student_number'])->where(['student_info_id'=>$student_info_id,'sub_exam_id IN'=>$exam_master_id])->contain(['ExamMasters']);
                }])->where([$where,'rght-lft' => 1,'subject_type_id = '=>2,'Subjects.is_deleted ='=>'N']);

        $non_scholastic_subjects = json_decode(json_encode($non_scholastic_subjects->toArray()),true);
  
        foreach ($non_scholastic_subjects as $key => $subject)
            if(empty($subject['student_marks']))
            {
                unset($non_scholastic_subjects[$key]);
            }
  // pr($non_scholastic_subjects);exit;
       $schooledata=$this->StudentMarks->Schools->find();
        $schooledatas=$schooledata->toArray()[0];
    //  pr($infogread->toArray());die;
        $this->set(compact('student','exams','scholastic_subjects','non_scholastic_subjects','marks_type','marks','last','schooledatas','infodata','infogread'));
    }
*/
    public function saveMarks()
    {
        $data = $this->request->getData();
        unset($data['student_number']);
        $data['session_year_id'] = $this->Auth->user('session_year_id');
        if($this->StudentMarks->exists([$data]))
        {
            $mark = $this->StudentMarks->find()->where($data)->first();
            $mark->edited_by = $this->Auth->user('id');
        }
        else
        {
            $mark = $this->StudentMarks->newEntity();
            $mark->session_year_id = $data['session_year_id'];
            $mark->created_by = $this->Auth->user('id');
        }

        $mark_patch = $this->StudentMarks->patchEntity($mark,$this->request->getData());

        if($this->request->getData('student_number'))
            $save = $this->StudentMarks->save($mark_patch);
        else
            $save = $this->StudentMarks->delete($mark);

        if($save)
            $success = true;
        else
            $success = false;

        $this->set(compact('success','response'));
        $this->set('_serialize', ['response','success']);
    }

    public function getMaxMarks()
    {
		$this->loadModel('');
        $where['ExamMaxMarks.is_deleted'] = 'N';
        $where['ExamMaxMarks.session_year_id'] = $this->Auth->user('session_year_id');
        $save_to = $this->request->getData('save_to');
		$subject_id=$this->request->getData('subject_id');
		$exam_id=$this->request->getData('exam_master_id');
        foreach ($this->request->getData() as $key => $value) {
            if(!empty($value) && $key != 'save_to')
                $where['ExamMaxMarks.'.$key] = $value;
        }
         
		$success = 1;
		$response = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()->where(['ExamMaxMarks.subject_id'=>$subject_id,'ExamMaxMarks.exam_master_id'=>$exam_id])->first()->max_marks;
		//$response=$$responsenew[''];
      /*  if($save_to == 'exam_master_id')
        {
            if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists($where))
            {
                $success = 1;
                $response = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()->where($where)->first()->max_marks;
            }
            else
            {
                $success = 1;
                $response = $this->StudentMarks->ExamMasters->get($this->request->getData('exam_master_id'))->max_marks;
            }
        }
        else
        {
            if($this->StudentMarks->ExamMasters->SubExams->exists(['id'=>$this->request->getData('exam_master_id')]))
            {
                $success = 1;
                $response = $this->StudentMarks->ExamMasters->SubExams->get($this->request->getData('exam_master_id'))->max_marks;
            }
        }*/
		

        $this->set(compact('success','response'));
        $this->set('_serialize', ['success','response']);
    }

    public function createMarkSheet()
    { 
        $studentMark = $this->StudentMarks->newEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
           
            $class_mapping = $this->StudentMarks->ClassMappings->get($data['class_mapping_id']);
            $student_class_id = $class_mapping->student_class_id;
            $stream_id = $class_mapping->stream_id;
            $section_id = $class_mapping->section_id;
            $exam_master_id = $data['exam_master_id'];

            $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id]);
 //pr($children->toArray());die;
            if(!empty($children->toArray()))
            {
                foreach ($children as $key => $child) {
                    $exam_master_ids[] = $child->id;
                }

                $studentInfos = $this->StudentMarks->StudentInfos->find()->select(['StudentInfos.id','name'=>'Students.name','StudentInfos.roll_no','scholer_no'=>'Students.scholar_no','StudentInfos.student_class_id','StudentInfos.stream_id','StudentInfos.section_id','StudentInfos.session_year_id'])->where(['StudentInfos.student_class_id'=>$student_class_id,'StudentInfos.stream_id'=>$stream_id,'StudentInfos.section_id'=>$section_id,'StudentInfos.student_status'=>'Continue','StudentInfos.session_year_id'=>$this->Auth->user('session_year_id')])
                ->contain(['Students','Exams'=>function($q)use($exam_master_ids){
                    return $q->where(['Exams.id IN' => $exam_master_ids])->contain(['Subjects']);
                }]);
            }
            else
            {
                $studentInfos = $this->StudentMarks->StudentInfos->find()->select(['StudentInfos.id','name'=>'Students.name','StudentInfos.roll_no','scholer_no'=>'Students.scholar_no','StudentInfos.student_class_id','StudentInfos.stream_id','StudentInfos.section_id','StudentInfos.session_year_id'])->where(['StudentInfos.student_class_id'=>$student_class_id,'StudentInfos.stream_id'=>$stream_id,'StudentInfos.section_id'=>$section_id,'StudentInfos.student_status'=>'Continue','StudentInfos.session_year_id'=>$this->Auth->user('session_year_id')])
                ->contain(['Students','Exams'=>function($q)use($exam_master_id){
                    return $q->where(['Exams.id' => $exam_master_id])->contain(['Subjects']);
                }]);
            }
            $studentInfos = json_decode(json_encode($studentInfos->toArray()),true);
            $result_rows = [];
            $results = [];
            
           // pr($studentInfos);exit;
            foreach ($studentInfos as $info_key => $studentInfo)
            { 
                $results[$info_key]['student_info_id'] = $studentInfo['id'];
                $results[$info_key]['exam_master_id'] = $exam_master_id;

                foreach ($studentInfo['exams'] as $exam_key => $exam)
                {
                    //pr($exam);
                    foreach ($exam['subjects'] as $sub_key => $subject) 
                    {
                        //check if exam has sub exams
                        if($this->StudentMarks->SubExams->exists(['exam_master_id'=>$exam['id']]))
                        {
                            
                            $sub_exams = $this->StudentMarks->SubExams->find()->where(['exam_master_id'=>$exam['id']]);
                            $total_marks = [];
                            $obtain_marks = [];
                           // pr($sub_exams->toArray());die;
                            foreach ($sub_exams as $key => $sub_exam) {
                                if($this->StudentMarks->exists(['student_info_id'=>$studentInfo['id'],'sub_exam_id'=>$sub_exam['id'],'subject_id'=>$subject['id']]))
                                {
                                    
                                    $total_marks[] = $sub_exam['max_marks'];
                                //  pr($sub_exam['id']);die;
                                    $obtain_marks[] = $this->StudentMarks->find()->where(['student_info_id'=>$studentInfo['id'],'sub_exam_id'=>$sub_exam['id'],'subject_id'=>$subject['id']])->first()->student_number;
                                    //pr($obtain_marks);
                                }
                            }
                        
                            //get max marks either from exam_max_marks or from exam_master
                            //pr($obtain_marks);die;
                            if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['subject_id'=>$subject['id'],'exam_master_id'=>$sub_exam['id'],'session_year_id'=>$this->Auth->user('session_year_id')]))
                            {
                                $total = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()
                                ->where(['subject_id'=>$subject['id'],
                                            'exam_master_id'=>$sub_exam['id'],
                                            'session_year_id'=>$this->Auth->user('session_year_id')])
                                ->first()->max_marks;
                                //pr($total);die;
                            }
                            
                            
                            if(!empty($obtain_marks))
                            {
                                //pr($obtain_marks);
                                
                                $results[$info_key]['result_rows'][$exam_key][$sub_key]['subject_id'] = $subject['id'];
                                $results[$info_key]['result_rows'][$exam_key][$sub_key]['subject_name'] = $subject['name'];
                                $results[$info_key]['result_rows'][$exam_key][$sub_key]['exam_master_id'] = $exam['id'];
                                $results[$info_key]['result_rows'][$exam_key][$sub_key]['exam_master_name'] = $exam['name'];
                                
                                $results[$info_key]['result_rows'][$exam_key][$sub_key]['number_of_best'] = $exam['number_of_best'];
                                if($exam['max_marks'])
                                {
                                    $results[$info_key]['result_rows'][$exam_key][$sub_key]['total'] = $exam['max_marks'];
                                }else{
                                     $results[$info_key]['result_rows'][$exam_key][$sub_key]['total'] = (Int)$total;
                                }
                               
                                @$results[$info_key]['result_rows'][$exam_key][$sub_key]['obtain'] = is_numeric($obtain_marks)?(Int)round($obtain_marks):$obtain_marks;
                                
                                $percent = round(array_sum($obtain_marks)/array_sum($total_marks)) * 100;
                             //pr( $percent );die;
                                $results[$info_key]['result_rows'][$exam_key][$sub_key]['grade'] = $this->Grade->getGrade($student_class_id,$stream_id,$percent);
                            }
                        }
                        else
                        {
                            //find obtain marks
                            if($this->StudentMarks->exists(['student_info_id'=>$studentInfo['id'],'exam_master_id'=>$exam['id'],'subject_id'=>$subject['id']]))
                            {
                                $obtain_marks = $this->StudentMarks->find()
                                            ->where(['student_info_id'=>$studentInfo['id'],'exam_master_id'=>$exam['id'],'subject_id'=>$subject['id']])
                                            ->first()->student_number;

                                //get max marks either from exam_max_marks or from exam_master
                                if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['subject_id'=>$subject['id'],'exam_master_id'=>$exam['id'],'session_year_id'=>$this->Auth->user('session_year_id')]))
                                {
                                    $total_marks = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()
                                    ->where(['subject_id'=>$subject['id'],
                                                'exam_master_id'=>$exam['id'],
                                                'session_year_id'=>$this->Auth->user('session_year_id')])
                                    ->first()->max_marks;
                                }
                                else
                                    $total_marks = $exam['max_marks'];

                                if(!empty($obtain_marks))
                                {
                                    $results[$info_key]['result_rows'][$exam_key][$sub_key]['subject_id'] = $subject['id'];
                                    $results[$info_key]['result_rows'][$exam_key][$sub_key]['subject_name'] = $subject['name'];
                                    $results[$info_key]['result_rows'][$exam_key][$sub_key]['exam_master_id'] = $exam['id'];
                                    $results[$info_key]['result_rows'][$exam_key][$sub_key]['exam_master_name'] = $exam['name'];
                                    $results[$info_key]['result_rows'][$exam_key][$sub_key]['total'] = (Int)$total_marks;
                                    @$results[$info_key]['result_rows'][$exam_key][$sub_key]['obtain'] += is_numeric($obtain_marks)?(Int)round($obtain_marks):$obtain_marks;
                                    $percent = round($obtain_marks)/$total_marks * 100;

                                    $results[$info_key]['result_rows'][$exam_key][$sub_key]['grade'] = $this->Grade->getGrade($student_class_id,$stream_id,$percent);
                                }
                            }
                        }
                    }
                }
            }
            //die;
//pr($obtain_marks);die;
            foreach ($results as $key => $result)
            {
                $total = 0;
                $obtain = 0;
                $subject_total = [];
                $subject_obtain = [];
                $fail = [];
                $supplementary = [];
                $distinction = [];
                if(isset($result['result_rows']))
                {
                
                    foreach ($result['result_rows'] as $key2 => $result_row) {
                        //pr($result_row);die;
                        
                        foreach ($result_row as $data) {
                        
                           @$subject_total[$data['subject_id']]+= $data['total'];
                            @$subject_obtain[$data['subject_id']]+= array_sum($data['obtain']);
                            $total+= $data['total'];
                            $obtain+= array_sum($data['obtain']);
                            @$number_of_best+=$data['number_of_best'];
                            $results[$key]['result_rows'][] = $data;
                                
                        }
                    
                       unset($results[$key]['result_rows'][$key2]);
                    }
              // pr($obtain);die;
                    /* $percent = ($obtain/$total)*100;
                    $results[$key]['total'] = $total;
                    $results[$key]['obtain'] = $obtain;

                    if($percent < 36)
                        $results[$key]['status'] = 'Fail';
                    else
                        $results[$key]['status'] = 'Pass';

                    if($percent >= 36 && $percent < 49)
                        $results[$key]['division'] = 'Third';
                    if($percent >= 50 && $percent < 60)
                        $results[$key]['division'] = 'Second';
                    if($percent >= 60)
                        $results[$key]['division'] = 'First';

                    $results[$key]['percentage'] = $percent;
                    $results[$key]['number_of_best'] = $number_of_best;
                    $results[$key]['grade'] = $this->Grade->getGrade($student_class_id,$stream_id,$percent); */
                }

                // calculate subject wise fail supplementary and distinction
               /*  foreach ($subject_total as $sub_total_key => $total) {
                    $percent = $subject_obtain[$sub_total_key] / $total * 100;
                    if($percent < 22)
                        $fail[] = $sub_total_key;
                    if($percent >= 22 && $percent < 36)
                        $supplementary[] = $sub_total_key;
                    if($percent > 80)
                        $distinction[] = $sub_total_key;
                }

                if(!empty($fail))
                    $results[$key]['fail'] = implode(',', $fail);

                if(!empty($supplementary))
                    $results[$key]['supplementary'] = implode(',', $supplementary);

                if(!empty($distinction))
                    $results[$key]['distinction'] = implode(',', $distinction);
 */
                
            }

         
            foreach(@$results as $key1 => $rowss)
           {
               if(!empty($rowss['result_rows']))
               {
              foreach(@$rowss['result_rows'] as $key =>$rowsss)
              {
                 // pr($rowsss);die;
                  $rowss['result_rows'][$key]['obtain']=array_sum($rowsss['obtain']);
                  $rowss['result_rows'][$key]['number_of_best']=$rowsss['number_of_best'];
                  
                  //die;
              }
            // pr($rowss['result_rows']);die;
             // pr($results[$key1]['result_rows']);die;
               @$results[$key1]['result_rows']=$rowss['result_rows'];
               }
           }
          
            //$old_result=[];
          $studentInfos_id=[];
          
          foreach($studentInfos as $student_nifo_id)
          { 
               // pr();die;
              $studentInfos_id[]=$student_nifo_id['id'];
         }
         // pr($studentInfos_id);die;
            $old_result = $this->StudentMarks->ExamMasters->Results->find()->where(['exam_master_id' =>$exam_master_id,'student_info_id IN'=>$studentInfos_id]);
            
            $rr = $this->StudentMarks->ExamMasters->Results->newEntity();
            $rr = $this->StudentMarks->ExamMasters->Results->patchEntities($rr,$results);

          // pr($old_result->toArray());exit;

            foreach ($old_result as $key => $old) {

                $this->StudentMarks->ExamMasters->Results->delete($old);
            }

            if($this->StudentMarks->ExamMasters->Results->saveMany($rr))
                $this->Flash->success('Mark Sheet Created');
            else
                $this->Flash->error('Unable to create Mark Sheet');
        }

        $data = $this->StudentMarks->ClassMappings->find();
        $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
            ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
          
            ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
        foreach ($data as $key => $clss) {
            $name = '';
            foreach ($clss->toArray() as $key2 => $value)
            {
                if(!empty($value) && $key2 != 'id')
                {
                    if($key2 != 'Mname')
                        $name.=" > ";
                    $name.=$value;
                }
            }
            $classMappings[$clss->id] = $name;
        }

        $this->set(compact('studentMark', 'sessionYears', 'studentInfos', 'examMasters', 'subjects','classMappings','students'));
    }

//     public function createMarkSheet()
//     { 
//         $studentMark = $this->StudentMarks->newEntity();
//         //pr($_POST);die;
//         if ($this->request->is('post')) {
//             $data = $this->request->getData();
           
//             $class_mapping = $this->StudentMarks->ClassMappings->get($data['class_mapping_id']);
//             $student_class_id = $class_mapping->student_class_id;
//             $stream_id = $class_mapping->stream_id;
//             $section_id = $class_mapping->section_id;
//             $exam_master_id = $data['exam_master_id'];

//             $children = $this->StudentMarks->ExamMasters->find('children', ['for' => $exam_master_id]);
//  //pr($children->toArray());die;
//             if(!empty($children->toArray()))
//             {
//                 foreach ($children as $key => $child) {
//                     $exam_master_ids[] = $child->id;
//                 }

//                 $studentInfos = $this->StudentMarks->StudentInfos->find()->select(['StudentInfos.id','name'=>'Students.name','StudentInfos.roll_no','scholer_no'=>'Students.scholar_no','StudentInfos.student_class_id','StudentInfos.stream_id','StudentInfos.section_id','StudentInfos.session_year_id'])->where(['StudentInfos.student_class_id'=>$student_class_id,'StudentInfos.stream_id'=>$stream_id])
//                 ->contain(['Students','Exams'=>function($q)use($exam_master_ids){
//                     return $q->where(['Exams.id IN' => $exam_master_ids])->contain(['Subjects']);
//                 }]);
//             }
//             else
//             {
//                 $studentInfos = $this->StudentMarks->StudentInfos->find()->select(['StudentInfos.id','name'=>'Students.name','StudentInfos.roll_no','scholer_no'=>'Students.scholar_no','StudentInfos.student_class_id','StudentInfos.stream_id','StudentInfos.section_id','StudentInfos.session_year_id'])->where(['StudentInfos.student_class_id'=>$student_class_id,'StudentInfos.stream_id'=>$stream_id])
//                 ->contain(['Students','Exams'=>function($q)use($exam_master_id){
//                     return $q->where(['Exams.id' => $exam_master_id])->contain(['Subjects']);
//                 }]);
//             }
//             $studentInfos = json_decode(json_encode($studentInfos->toArray()),true);
//             $result_rows = [];
//             $results = [];
            
//            // pr($studentInfos);exit;
//             foreach ($studentInfos as $info_key => $studentInfo)
//             { 
//                 $results[$info_key]['student_info_id'] = $studentInfo['id'];
//                 $results[$info_key]['exam_master_id'] = $exam_master_id;

//                 foreach ($studentInfo['exams'] as $exam_key => $exam)
//                 {
//                     //pr($exam);
//                     foreach ($exam['subjects'] as $sub_key => $subject) 
//                     {
//                         //check if exam has sub exams
//                         if($this->StudentMarks->SubExams->exists(['exam_master_id'=>$exam['id']]))
//                         {
                            
//                             $sub_exams = $this->StudentMarks->SubExams->find()->where(['exam_master_id'=>$exam['id']]);
//                             $total_marks = [];
//                             $obtain_marks = [];
//                            // pr($sub_exams->toArray());die;
//                             foreach ($sub_exams as $key => $sub_exam) {
//                                 if($this->StudentMarks->exists(['student_info_id'=>$studentInfo['id'],'sub_exam_id'=>$sub_exam['id'],'subject_id'=>$subject['id']]))
//                                 {
                                    
//                                     $total_marks[] = $sub_exam['max_marks'];
//                                 //  pr($sub_exam['id']);die;
//                                     $obtain_marks[] = $this->StudentMarks->find()->where(['student_info_id'=>$studentInfo['id'],'sub_exam_id'=>$sub_exam['id'],'subject_id'=>$subject['id']])->first()->student_number;
//                                     //pr($obtain_marks);
//                                 }
//                             }
                        
//                             //get max marks either from exam_max_marks or from exam_master
//                             //pr($obtain_marks);die;
//                             if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['subject_id'=>$subject['id'],'exam_master_id'=>$sub_exam['id'],'session_year_id'=>$this->Auth->user('session_year_id')]))
//                             {
//                                 $total = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()
//                                 ->where(['subject_id'=>$subject['id'],
//                                             'exam_master_id'=>$sub_exam['id'],
//                                             'session_year_id'=>$this->Auth->user('session_year_id')])
//                                 ->first()->max_marks;
//                                 //pr($total);die;
//                             }
                            
                            
//                             if(!empty($obtain_marks))
//                             {
//                                 //pr($obtain_marks);
                                
//                                 $results[$info_key]['result_rows'][$exam_key][$sub_key]['subject_id'] = $subject['id'];
//                                 $results[$info_key]['result_rows'][$exam_key][$sub_key]['subject_name'] = $subject['name'];
//                                 $results[$info_key]['result_rows'][$exam_key][$sub_key]['exam_master_id'] = $exam['id'];
//                                 $results[$info_key]['result_rows'][$exam_key][$sub_key]['exam_master_name'] = $exam['name'];
                                
//                                 $results[$info_key]['result_rows'][$exam_key][$sub_key]['number_of_best'] = $exam['number_of_best'];
//                                 if($exam['max_marks'])
//                                 {
//                                     $results[$info_key]['result_rows'][$exam_key][$sub_key]['total'] = $exam['max_marks'];
//                                 }else{
//                                      $results[$info_key]['result_rows'][$exam_key][$sub_key]['total'] = (Int)$total;
//                                 }
                               
//                                 @$results[$info_key]['result_rows'][$exam_key][$sub_key]['obtain'] = is_numeric($obtain_marks)?(Int)round($obtain_marks):$obtain_marks;
                                
//                                 $percent = round(array_sum($obtain_marks)/array_sum($total_marks)) * 100;
//                              //pr( $percent );die;
//                                 $results[$info_key]['result_rows'][$exam_key][$sub_key]['grade'] = $this->Grade->getGrade($student_class_id,$stream_id,$percent);
//                             }
//                         }
//                         else
//                         {
//                             //find obtain marks
//                             if($this->StudentMarks->exists(['student_info_id'=>$studentInfo['id'],'exam_master_id'=>$exam['id'],'subject_id'=>$subject['id']]))
//                             {
//                                 $obtain_marks = $this->StudentMarks->find()
//                                             ->where(['student_info_id'=>$studentInfo['id'],'exam_master_id'=>$exam['id'],'subject_id'=>$subject['id']])
//                                             ->first()->student_number;

//                                 //get max marks either from exam_max_marks or from exam_master
//                                 if($this->StudentMarks->ExamMasters->ExamMaxMarks->exists(['subject_id'=>$subject['id'],'exam_master_id'=>$exam['id'],'session_year_id'=>$this->Auth->user('session_year_id')]))
//                                 {
//                                     $total_marks = $this->StudentMarks->ExamMasters->ExamMaxMarks->find()
//                                     ->where(['subject_id'=>$subject['id'],
//                                                 'exam_master_id'=>$exam['id'],
//                                                 'session_year_id'=>$this->Auth->user('session_year_id')])
//                                     ->first()->max_marks;
//                                 }
//                                 else
//                                     $total_marks = $exam['max_marks'];

//                                 if(!empty($obtain_marks))
//                                 {
//                                     $results[$info_key]['result_rows'][$exam_key][$sub_key]['subject_id'] = $subject['id'];
//                                     $results[$info_key]['result_rows'][$exam_key][$sub_key]['subject_name'] = $subject['name'];
//                                     $results[$info_key]['result_rows'][$exam_key][$sub_key]['exam_master_id'] = $exam['id'];
//                                     $results[$info_key]['result_rows'][$exam_key][$sub_key]['exam_master_name'] = $exam['name'];
//                                     $results[$info_key]['result_rows'][$exam_key][$sub_key]['total'] = (Int)$total_marks;
//                                     @$results[$info_key]['result_rows'][$exam_key][$sub_key]['obtain'] += is_numeric($obtain_marks)?(Int)round($obtain_marks):$obtain_marks;
//                                     $percent = round($obtain_marks)/$total_marks * 100;

//                                     $results[$info_key]['result_rows'][$exam_key][$sub_key]['grade'] = $this->Grade->getGrade($student_class_id,$stream_id,$percent);
//                                 }
//                             }
//                         }
//                     }
//                 }
//             }
//             //die;
// //pr($obtain_marks);die;
//             foreach ($results as $key => $result)
//             {
//                 $total = 0;
//                 $obtain = 0;
//                 $subject_total = [];
//                 $subject_obtain = [];
//                 $fail = [];
//                 $supplementary = [];
//                 $distinction = [];
//                 if(isset($result['result_rows']))
//                 {
                
//                     foreach ($result['result_rows'] as $key2 => $result_row) {
//                         //pr($result_row);die;
                        
//                         foreach ($result_row as $data) {
                        
//                            @$subject_total[$data['subject_id']]+= $data['total'];
//                             @$subject_obtain[$data['subject_id']]+= array_sum($data['obtain']);
//                             $total+= $data['total'];
//                             $obtain+= array_sum($data['obtain']);
//                             @$number_of_best+=$data['number_of_best'];
//                             $results[$key]['result_rows'][] = $data;
                                
//                         }
                    
//                        unset($results[$key]['result_rows'][$key2]);
//                     }
//               // pr($obtain);die;
//                     /* $percent = ($obtain/$total)*100;
//                     $results[$key]['total'] = $total;
//                     $results[$key]['obtain'] = $obtain;

//                     if($percent < 36)
//                         $results[$key]['status'] = 'Fail';
//                     else
//                         $results[$key]['status'] = 'Pass';

//                     if($percent >= 36 && $percent < 49)
//                         $results[$key]['division'] = 'Third';
//                     if($percent >= 50 && $percent < 60)
//                         $results[$key]['division'] = 'Second';
//                     if($percent >= 60)
//                         $results[$key]['division'] = 'First';

//                     $results[$key]['percentage'] = $percent;
//                     $results[$key]['number_of_best'] = $number_of_best;
//                     $results[$key]['grade'] = $this->Grade->getGrade($student_class_id,$stream_id,$percent); */
//                 }

//                 // calculate subject wise fail supplementary and distinction
//                /*  foreach ($subject_total as $sub_total_key => $total) {
//                     $percent = $subject_obtain[$sub_total_key] / $total * 100;
//                     if($percent < 22)
//                         $fail[] = $sub_total_key;
//                     if($percent >= 22 && $percent < 36)
//                         $supplementary[] = $sub_total_key;
//                     if($percent > 80)
//                         $distinction[] = $sub_total_key;
//                 }

//                 if(!empty($fail))
//                     $results[$key]['fail'] = implode(',', $fail);

//                 if(!empty($supplementary))
//                     $results[$key]['supplementary'] = implode(',', $supplementary);

//                 if(!empty($distinction))
//                     $results[$key]['distinction'] = implode(',', $distinction);
//  */
                
//             }

         
//             foreach(@$results as $key1 => $rowss)
//            {
//                if(!empty($rowss['result_rows']))
//                {
//               foreach(@$rowss['result_rows'] as $key =>$rowsss)
//               {
//                  // pr($rowsss);die;
//                   $rowss['result_rows'][$key]['obtain']=array_sum($rowsss['obtain']);
//                   $rowss['result_rows'][$key]['number_of_best']=$rowsss['number_of_best'];
                  
//                   //die;
//               }
//             // pr($rowss['result_rows']);die;
//              // pr($results[$key1]['result_rows']);die;
//                @$results[$key1]['result_rows']=$rowss['result_rows'];
//                }
//            }
//            // pr($results);die;
//             $old_result = $this->StudentMarks->ExamMasters->Results->find()->where(['exam_master_id' => $exam_master_id]);

//             $rr = $this->StudentMarks->ExamMasters->Results->newEntity();
//             $rr = $this->StudentMarks->ExamMasters->Results->patchEntities($rr,$results);

//            //pr($rr);exit;

//             foreach ($old_result as $key => $old) {
//                 $this->StudentMarks->ExamMasters->Results->delete($old);
//             }

//             if($this->StudentMarks->ExamMasters->Results->saveMany($rr))
//                 $this->Flash->success('Mark Sheet Created');
//             else
//                 $this->Flash->error('Unable to create Mark Sheet');
//         }

//         $data = $this->StudentMarks->ClassMappings->find();
//         $data->select(['id'=>'ClassMappings.id','Mname'=>'Mediums.name','Cname'=>'StudentClasses.name','Sname'=>'Streams.name','SCname'=>'Sections.name'])
//             ->where(['ClassMappings.session_year_id'=>$this->Auth->user('session_year_id')])
          
//             ->contain(['Mediums','StudentClasses','Streams','Sections']);
        
//         foreach ($data as $key => $clss) {
//             $name = '';
//             foreach ($clss->toArray() as $key2 => $value)
//             {
//                 if(!empty($value) && $key2 != 'id')
//                 {
//                     if($key2 != 'Mname')
//                         $name.=" > ";
//                     $name.=$value;
//                 }
//             }
//             $classMappings[$clss->id] = $name;
//         }

//         $this->set(compact('studentMark', 'sessionYears', 'studentInfos', 'examMasters', 'subjects','classMappings','students'));
//     }

    public function getParentExams()
    {
		$session_year_id=$this->Auth->user('session_year_id');
        $class_mapping = $this->StudentMarks->ClassMappings->get($this->request->getData('class_mapping_id'));
        $response = $this->StudentMarks->ExamMasters->find('threaded')
        ->where(['ExamMasters.student_class_id'=>$class_mapping->student_class_id,'ExamMasters.session_year_id'=>$session_year_id,'ExamMasters.parent_id'=>0]);
		//pr($response->toArray());die;
        if(@$class_mapping->stream_id)
        {
       $response->where(['stream_id'=>@$class_mapping->stream_id]);
        }
        $response->where(['is_deleted'=>'N']);
        if($response)
            $success = 1;
        else
            $success = 0;

        $this->set(compact('success','response'));
        $this->set('_serialize', ['success','response']);
    }
}
