<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DailyThoughts Controller
 *
 * @property \App\Model\Table\DailyThoughtsTable $DailyThoughts
 *
 * @method \App\Model\Entity\DailyThought[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DailyThoughtsController extends AppController
{

    /*
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id=null)
    {
        $user_id = $this->Auth->User('id');
        if(!$id){
              $dailyThought = $this->DailyThoughts->newEntity();
              }
          else
            {
                $id = $this->EncryptingDecrypting->decryptData($id);

                $dailyThought = $this->DailyThoughts->get($id, [
                'contain' => []
                ]);
                //pr($dailyThought);exit;
            }
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
           $dailyThought = $this->DailyThoughts->patchEntity($dailyThought, $this->request->getData());
            if(!$id)
            {
                $dailyThought->created_by =$user_id;
            }
            else
            {
                $dailyThought->edited_by =$user_id;
            }
            $error='';
            try 
            {
                if ($this->DailyThoughts->save($dailyThought)) 
                {
					
					$role_type=$dailyThought->role_type;
				if($role_type=='All'){
					$user_type=['Employee','Student'];
				}elseif($role_type=='Teacher'){
					$user_type=['Employee'];
				}elseif($role_type=='Student'){
					$user_type=['Student'];
				}
				
				$Usersdatas=$this->DailyThoughts->Users->find()->where(['user_type IN'=>$user_type,'device_token !='=>'','is_deleted'=>'N'])->toArray();
				//	pr($Usersdatas);die;
				$Notifications=$this->DailyThoughts->Notifications->newEntity();
				$Notifications->title='DailyThoughts';
				$Notifications->message=$dailyThought->description;
				$Notifications->df_link='Alok://home';
				$Notifications->notify_date=date("Y-m-d");
				$Notifications->notify_time=date("h:i: A");
				$Notifications->status=0;
				$Notifications->created_by=$user_id;
				$this->DailyThoughts->Notifications->save($Notifications);
			
				foreach($Usersdatas as $Usersdata){
					$NotificationRows=$this->DailyThoughts->Notifications->NotificationRows->newEntity();
					$NotificationRows->notification_id=$Notifications->id;
					$NotificationRows->user_id=$Usersdata->id;
					$NotificationRows->df_link='Alok://home';
					$NotificationRows->sent=0;
					$NotificationRows->status=0;
					$this->DailyThoughts->Notifications->NotificationRows->save($NotificationRows);
				}
					
					
					
					
					
                    $this->Flash->success(__('The daily thought has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            catch (\Exception $e) {
               $error = $e->getMessage();
            }
            
            if (strpos($error, '1062') !== false) 
            {
                $error_data='Duplicate entry. Please, try again.';
            }
            else
            {
                $error_data='The daily thought could not be saved. Please, try again.';
            }
            //pr($studentRedDiary);exit;
            $this->Flash->error(__($error_data));
        }
        $status=['Y'=>'Deactive','N'=>'Active'];
        $roleTypes=['All'=>'All','Teacher'=>'Teacher','Student'=>'Student'];
        $where = array(); 
        if(!empty($this->request->getQuery('role'))){
            $where['DailyThoughts.role_type']=$this->request->getQuery('role');
        }
        $dailyThoughts = $this->paginate($this->DailyThoughts->find()->where($where)->order(['id'=>'DESC']));
        $this->set(compact('dailyThoughts','dailyThought','id','status','roleTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Daily Thought id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function studentView($id = null)
    {
        $where['role_type']='Student'; 
        $where['is_deleted']='N'; 
        $dailyThoughts = $this->paginate($this->DailyThoughts->find()->where($where)->order(['id'=>'DESC']));
        $this->set(compact('dailyThoughts'));  
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dailyThought = $this->DailyThoughts->newEntity();
        if ($this->request->is('post')) {
            $dailyThought = $this->DailyThoughts->patchEntity($dailyThought, $this->request->getData());
            if ($this->DailyThoughts->save($dailyThought)) {
				
				
                $this->Flash->success(__('The daily thought has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The daily thought could not be saved. Please, try again.'));
        }
        $this->set(compact('dailyThought'));

       
    }

    /**
     * Edit method
     *
     * @param string|null $id Daily Thought id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dailyThought = $this->DailyThoughts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dailyThought = $this->DailyThoughts->patchEntity($dailyThought, $this->request->getData());
            if ($this->DailyThoughts->save($dailyThought)) {
                $this->Flash->success(__('The daily thought has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The daily thought could not be saved. Please, try again.'));
        }
        $this->set(compact('dailyThought'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Daily Thought id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dailyThought = $this->DailyThoughts->get($id);
        if ($this->DailyThoughts->delete($dailyThought)) {
            $this->Flash->success(__('The daily thought has been deleted.'));
        } else {
            $this->Flash->error(__('The daily thought could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
