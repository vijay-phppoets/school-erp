<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Genders Controller
 *
 * @property \App\Model\Table\GendersTable $Genders
 *
 * @method \App\Model\Entity\Gender[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GendersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id=null)
    {
        $user_id = $this->Auth->User('id');
		if(!$id){
			$gender = $this->Genders->newEntity();
		}
		else{
			 $id = $this->EncryptingDecrypting->decryptData($id);
			 $gender = $this->Genders->get($id, [
			'contain' => []
			]);
			} 
        if ($this->request->is(['patch', 'post', 'put']))
		{
            $gender =  $this->Genders->patchEntity($gender, $this->request->getData());
			if(!$id)
            {
                $gender->created_by =$user_id;
            }
            else
            {
                $gender->edited_by =$user_id;
            }
			$error='';
			try 
            {
				if ($this->Genders->save($gender)) {
					$this->Flash->success(__('The gender has been saved.'));
					return $this->redirect(['action' => 'index']);
				}
			} catch (\Exception $e) {
               $error = $e->getMessage();
            }
			if (strpos($error, '1062') !== false) 
            {
                $error_data='Duplicate entry. Please, try again.';
            }
            else
            {
                $error_data='The gender could not be saved. Please, try again.';
            }
            $this->Flash->error(__($error_data));
        }
		$status[]=['value'=>'N','text'=>'Active'];
		$status[]=['value'=>'Y','text'=>'Deactive'];
		$Genders  = $this->paginate($this->Genders->find()->order(['Genders.id'=>'DESC']),['limit'=>10]);
        $this->set(compact('gender','id','Genders','status'));
    }

    /**
     * View method
     *
     * @param string|null $id Gender id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $gender = $this->Genders->get($id, [
            'contain' => ['Employees', 'FeeTypes', 'Students']
        ]);

        $this->set('gender', $gender);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $gender = $this->Genders->newEntity();
        if ($this->request->is('post')) {
            $gender = $this->Genders->patchEntity($gender, $this->request->getData());
            if ($this->Genders->save($gender)) {
                $this->Flash->success(__('The gender has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gender could not be saved. Please, try again.'));
        }
        $this->set(compact('gender'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Gender id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $gender = $this->Genders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gender = $this->Genders->patchEntity($gender, $this->request->getData());
            if ($this->Genders->save($gender)) {
                $this->Flash->success(__('The gender has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gender could not be saved. Please, try again.'));
        }
        $this->set(compact('gender'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Gender id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gender = $this->Genders->get($id);
        if ($this->Genders->delete($gender)) {
            $this->Flash->success(__('The gender has been deleted.'));
        } else {
            $this->Flash->error(__('The gender could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
