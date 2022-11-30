<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Holidays Controller
 *
 * @property \App\Model\Table\HolidaysTable $Holidays
 *
 * @method \App\Model\Entity\Holiday[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HolidaysController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		
		   $Cid=$this->request->getQuery('CID');
        
        $holidays = $this->Holidays->find();
        $holidays->where(['Holidays.is_deleted'=>'N']);
        if(!empty($Cid)){
             $holidays->where(['Holidays.holidays_name'=>$Cid]);
        }
        if(!empty($this->request->getQuery('daterange'))){
            $daterange=explode('/',$this->request->getQuery('daterange'));
            $date_from=date('Y-m-d',strtotime($daterange[0])); 
            $date_to=date('Y-m-d',strtotime($daterange[1])); 
            $holidays->where(['Holidays.date >=' =>$date_from,'Holidays.date <=' =>$date_to]);
        }
        $holidays->order(['Holidays.id'=>'DESC']);
        $holidays = $this->paginate($holidays);

        
        //$holidays = $this->paginate($this->Holidays);

        $this->set(compact('holidays'));
    }

    /**
     * View method
     *
     * @param string|null $id Holiday id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $holiday = $this->Holidays->get($id, [
            'contain' => ['Holidays']
        ]);

        $this->set('holiday', $holiday);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $holiday = $this->Holidays->newEntity();
		$user_id = $this->Auth->User('id');
		$session_year_id = $this->Auth->User('session_year_id');
        if ($this->request->is('post')) {
          $date = array_filter($this->request->getData('date'));
          $holidays_name = array_filter($this->request->getData('holidays_name'));
        //    $description = array_filter($this->request->getData('description'));
		$c=0;
            $result=0;
            foreach ($date as $newdate) {
                $Holiday = $this->Holidays->newEntity();
                $Holiday->date=date('Y-m-d',strtotime($newdate));
                $Holiday->created_by=$user_id;
                $Holiday->holidays_name=$holidays_name[$c];
                $Holiday->session_year_id=$session_year_id;
               
                if ($this->Holidays->save($Holiday)) {
					
                    $result=1;
                }
                $c++;
            }
           /*  if ($this->Holidays->save($holiday)) {
                

               
            } */
			  $this->Flash->success(__('The holiday has been saved.'));
			 return $this->redirect(['action' => 'index']);
          
        }
        $this->set(compact('holiday'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Holiday id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $holiday = $this->Holidays->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $holiday = $this->Holidays->patchEntity($holiday, $this->request->getData());
			
			 $holiday->date=date('Y-m-d',strtotime($this->request->getData('date')));
			 $holiday->holidays_name=$this->request->getData('holidays_name');
			 $holiday->is_deleted=$this->request->getData('is_deleted');
		//	 pr($holiday);die;
            if ($this->Holidays->save($holiday)) {
                $this->Flash->success(__('The holiday has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The holiday could not be saved. Please, try again.'));
        }
        $this->set(compact('holiday'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Holiday id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $holiday = $this->Holidays->get($id);
        if ($this->Holidays->delete($holiday)) {
            $this->Flash->success(__('The holiday has been deleted.'));
        } else {
            $this->Flash->error(__('The holiday could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
