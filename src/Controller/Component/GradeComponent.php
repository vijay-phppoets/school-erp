<?php
namespace App\Controller\Component;
use App\Controller\AppController;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class GradeComponent extends Component
{
	function initialize(array $config) 
	{
		parent::initialize($config);
	}
	
	function getGrade($student_class_id,$stream_id = null,$percent)
    {
        $abc = new AppController;

        $this->GradeMasters = TableRegistry::get('GradeMasters'); //cakephp 3.6
        //$this->GradeMasters = TableRegistry::getTableLocator()->get('GradeMasters'); // cakephp 3.7+ 
        
        $where['student_class_id'] = $student_class_id;
        $where['is_deleted'] = 'N';
        $where['session_year_id'] = $abc->Auth->user('session_year_id');
        $where['min_marks <='] = $percent;
        $where['max_marks >='] = $percent;
        if($stream_id)
            $where['stream_id'] = $stream_id;
        if($this->GradeMasters->exists($where))
            $grade = $this->GradeMasters->find()->where($where)->first()->grade;
        else
            $grade = '';

        return $grade;
  	}
	function insertData($data=null){
		$this->StudentRecords = TableRegistry::get('StudentRecords');
		
		if(count($data)>0)
		{
			
			if(!empty($data['stream_id']) && !empty($data['section_id']) && !empty($data['student_class_id']) && !empty($data['student_id']))
			{
				$check = $this->StudentRecords->find()
				->where(['StudentRecords.session_year_id'=>@$data['session_year_id'],'StudentRecords.stream_id'=>@$data['stream_id'],'StudentRecords.section_id'=>@$data['section_id'],'StudentRecords.student_class_id'=>@$data['student_class_id'],'StudentRecords.student_id'=>@$data['student_id']])->first();
				
				if(!empty($check))
				{
					$query = $this->StudentRecords->query();
									$query->update()
									->set(['marks' =>@$data['marks'],'marksmax'=>@$data['marksmax'],'percentage'=>@$data['percentage'],'grade'=>@$data['grade'],'status'=>@$data['status'],'meeting'=>@$data['meeting'],'attend'=>@$data['attend'],'remark'=>@$data['remark'],'session_year_id'=>@$data['session_year_id']])
				->where(['student_id' => @$data['student_id'],'section_id'=>@$data['section_id'],'student_class_id'=>@$data['student_class_id'],'stream_id'=>@$data['stream_id'],'session_year_id'=>@$data['session_year_id']])
									->execute();
				}
				else{
					$StudentRecord = $this->StudentRecords->newEntity();
					$StudentRecord->stream_id = @$data['stream_id'];
					$StudentRecord->student_class_id  = @$data['student_class_id'];
					$StudentRecord->section_id = @$data['section_id'];
					$StudentRecord->student_id     = @$data['student_id'];
					$StudentRecord->marks    = @$data['marks'];
					$StudentRecord->marksmax      = @$data['marksmax'];
					$StudentRecord->percentage  = @$data['percentage'];
					$StudentRecord->grade = @$data['grade'];
					$StudentRecord->status     = @$data['status'];
					$StudentRecord->meeting     = @$data['meeting'];
					$StudentRecord->attend     = @$data['attend'];
					$StudentRecord->remark     = @$data['remark'];
					$StudentRecord->session_year_id     = @$data['session_year_id'];
					
				
					$this->StudentRecords->save(@$StudentRecord);
					//pr($StudentRecord);die;
				}
			}
		}
	}
}
?>