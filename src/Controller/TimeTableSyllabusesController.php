<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * TimeTableSyllabuses Controller
 *
 * @property \App\Model\Table\TimeTableSyllabusesTable $TimeTableSyllabuses
 *
 * @method \App\Model\Entity\TimeTableSyllabus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TimeTableSyllabusesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['add','addImages']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {       
        $medium_id= $this->request->query('medium_id');
        $student_class_id= $this->request->query('student_class_id');
        $stream_id= $this->request->query('stream_id');
        $section_id= $this->request->query('section_id');
        $condition=[];
        if(!empty($medium_id)){
            $condition['TimeTableSyllabuses.medium_id']=$medium_id;
        }
        if(!empty($student_class_id)){
            $condition['TimeTableSyllabuses.class_id']=$student_class_id;
        }
        if(!empty($stream_id)){
            $condition['TimeTableSyllabuses.stream_id']=$stream_id;
        }
        if(!empty($section_id)){
            $condition['TimeTableSyllabuses.section_id']=$section_id;
        }
        $timeTableSyllabuses = $this->TimeTableSyllabuses->find()
            ->contain(['Mediums', 'StudentClasses', 'Streams', 'Sections', 'Subjects'])->where($condition);
            
       
        $mediums = $this->TimeTableSyllabuses->Mediums->find('list')->where(['Mediums.is_deleted'=>'N']);
        $studentClasses = $this->TimeTableSyllabuses->StudentClasses->find('list')->where(['StudentClasses.is_deleted'=>'N']);
        $streams = $this->TimeTableSyllabuses->Streams->find('list')->where(['Streams.is_deleted'=>'N']);
        $sections = $this->TimeTableSyllabuses->Sections->find('list')->where(['Sections.is_deleted'=>'N']);
        $subjects = $this->TimeTableSyllabuses->Subjects->find('list')->where(['Subjects.is_deleted'=>'N']);
        
        // $this->paginate = [
        //     'contain' => ['Mediums', 'StudentClasses', 'Sections', 'Streams', 'Subjects']
        // ];
        // $timeTableSyllabuses = $this->paginate($this->TimeTableSyllabuses);        

        $this->set(compact('timeTableSyllabuses','mediums','studentClasses','streams','sections','subjects'));
    }

    /**
     * View method
     *
     * @param string|null $id Time Table Syllabus id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $timeTableSyllabus = $this->TimeTableSyllabuses->get($id, [
            'contain' => ['Mediums', 'StudentClasses', 'Sections', 'Streams', 'Subjects']
        ]);

        $this->set('timeTableSyllabus', $timeTableSyllabus);
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
        $timeTableSyllabus = $this->TimeTableSyllabuses->newEntity();

        if ($this->request->is('post')){
            $map_id = $this->request->data('class_mapping_id');
           $classmappingsss= $this->TimeTableSyllabuses->ClassMappings->get($map_id);
           // pr($classmappingsss);die;
            $exam_id = $this->request->data('exam_master_id');
            
            $subjectsss=$this->request->data('subject_id');
            $date=$this->request->data('date');
            $timefrom=$this->request->data('time_from');
            $timeto=$this->request->data('time_to');
            $timeTableSyllabus=[];
            $i=0;
             foreach($subjectsss as $su)
             {   
                    $timeTableSyllabus = $this->TimeTableSyllabuses->newEntity();
                  $timeTableSyllabus['subject_id']=$su;
                  $timeTableSyllabus['medium_id']=$classmappingsss['medium_id'];
                  $timeTableSyllabus['class_id']=$classmappingsss['student_class_id'];
                  $timeTableSyllabus['stream_id']=$classmappingsss['stream_id'];
                  $timeTableSyllabus['section_id']=$classmappingsss['section_id'];
                  $timeTableSyllabus['exam_id']=$exam_id;
                  $timeTableSyllabus['date']=date('Y-m-d',strtotime($date[$i]));
                  $timeTableSyllabus['time_from']=$timefrom[$i];
                  $timeTableSyllabus['time_to']=$timeto[$i];
                 // pr($timeTableSyllabus);die;
                  $this->TimeTableSyllabuses->save($timeTableSyllabus);
                  $i++;
             }
            
            $timeTableSyllabus = $this->TimeTableSyllabuses->patchEntity($timeTableSyllabus, $this->request->getData());
            // if($this->TimeTableSyllabuses->save($timeTableSyllabus)){
                $this->Flash->success(__('The time table syllabus has been saved.'));
                return $this->redirect(['action' => 'add']);
            // }
            // else{
            //     $this->Flash->error(__('The time table syllabus could not be saved. Please, try again.'));
            // }
                
          
           
        }


        $mediums = $this->TimeTableSyllabuses->Mediums->find('list');
        $StudentClasses = $this->TimeTableSyllabuses->StudentClasses->find('list');
        $sections = $this->TimeTableSyllabuses->Sections->find('list');
        $streams = $this->TimeTableSyllabuses->Streams->find('list');
        $subjects = $this->TimeTableSyllabuses->Subjects->find('list');
        $data = $this->TimeTableSyllabuses->ClassMappings->find();
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


        $this->set(compact('timeTableSyllabus','classMappings', 'mediums', 'StudentClasses', 'sections', 'streams', 'subjects'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Time Table Syllabus id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $timeTableSyllabus = $this->TimeTableSyllabuses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $timeTableSyllabus = $this->TimeTableSyllabuses->patchEntity($timeTableSyllabus, $this->request->getData());
            if ($this->TimeTableSyllabuses->save($timeTableSyllabus)) {
                $this->Flash->success(__('The time table syllabus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The time table syllabus could not be saved. Please, try again.'));
        }
        $mediums = $this->TimeTableSyllabuses->Medium->find('list');
        $StudentClasses = $this->TimeTableSyllabuses->StudentClasses->find('list');
        $sections = $this->TimeTableSyllabuses->Section->find('list');
        $streams = $this->TimeTableSyllabuses->Stream->find('list');
        $subjects = $this->TimeTableSyllabuses->Subject->find('list');
        $this->set(compact('timeTableSyllabus', 'mediums', 'StudentClasses', 'sections', 'streams', 'subjects'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Time Table Syllabus id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $timeTableSyllabus = $this->TimeTableSyllabuses->get($id);
        if ($this->TimeTableSyllabuses->delete($timeTableSyllabus)) {
            $this->Flash->success(__('The time table syllabus has been deleted.'));
        } else {
            $this->Flash->error(__('The time table syllabus could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
