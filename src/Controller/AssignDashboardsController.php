<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\View\View;
use Cake\Event\Event;

/**
 * AssignDashboards Controller
 *
 * @property \App\Model\Table\AssignDashboardsTable $AssignDashboards
 *
 * @method \App\Model\Entity\AssignDashboard[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AssignDashboardsController extends AppController
{
     public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
         $this->Security->setConfig('unlockedActions', ['employeeUserRight','roleUserRight']);
    } 

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Employees', 'Roles', 'DdashboardSections']
        ];
        $assignDashboards = $this->paginate($this->AssignDashboards);

        $this->set(compact('assignDashboards'));
    }

    /**
     * View method
     *
     * @param string|null $id Assign Dashboard id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $assignDashboard = $this->AssignDashboards->get($id, [
            'contain' => ['Employees', 'Roles', 'DdashboardSections']
        ]);

        $this->set('assignDashboard', $assignDashboard);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userRight = $this->AssignDashboards->newEntity();
        $employees = $this->AssignDashboards->Employees->find('list');
        $roles = $this->AssignDashboards->Roles->find('list');
        $this->set(compact('userRight', 'employees', 'roles'));
    }

    public function addEmployeeRights()
    {
       
        if ($this->request->is('post')) {
            //pr($this->request->getData());exit;
            $employee_id=$this->request->getData('employee_id');
            $userRights = $this->AssignDashboards->find()->where(['employee_id'=>$employee_id])->first();
            if($userRights->id)
            {
                $userRight = $this->AssignDashboards->get($userRights->id);
            }
            else
            {
                $userRight = $this->AssignDashboards->newEntity();
            }
            
           
            $userRight = $this->AssignDashboards->patchEntity($userRight, $this->request->getData());
            if(!empty($this->request->getData('dashboard_section_id')))
            {
                $userRight->dashboard_section_ids=implode(',',$this->request->getData('dashboard_section_id'));
            }
            else
            {
                $userRight->dashboard_section_ids='';
            }
            if ($this->AssignDashboards->save($userRight)) {
                $this->Flash->success(__('The user right has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The user right could not be saved. Please, try again.'));
        }
    }
    public function addRoleRights()
    {
       
        if ($this->request->is('post')) {
            
            $role_id=$this->request->getData('role_id');
            $userRights = $this->AssignDashboards->find()->where(['role_id'=>$role_id])->first();
            if($userRights->id)
            {
                $userRight = $this->AssignDashboards->get($userRights->id);
            }
            else
            {
                $userRight = $this->AssignDashboards->newEntity();
            }
            $userRight = $this->AssignDashboards->patchEntity($userRight, $this->request->getData());
            if(!empty($this->request->getData('dashboard_section_id')))
            {
                $userRight->dashboard_section_ids=implode(',',$this->request->getData('dashboard_section_id'));
            }
            else
            {
                $userRight->dashboard_section_ids='';
            }
            if ($this->AssignDashboards->save($userRight)) {
                $this->Flash->success(__('The user right has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The user right could not be saved. Please, try again.'));
        }
    }


     public function employeeUserRight()
    {
        
        $employee_id=$this->request->Data('employee_id');
        $menus =  $this->AssignDashboards->DashboardSections->find();
        @$employee =  $this->AssignDashboards->Employees->get($employee_id);
        $role_id=$employee->role_id;
        $userRights = $this->AssignDashboards->find()->where(['OR'=>['employee_id'=>$employee_id,'role_id'=>$role_id]]);
        $menu_ids=[];
        $userRightsIds=[];
        foreach ($userRights as $userRight) 
        {
                $menu_ids[]=explode(',',$userRight->dashboard_section_ids);
        }
        foreach ($menu_ids as $key => $value) 
        {
            foreach ($value as $key1 => $value1) 
            {
                $userRightsIds[]=$value1;
            }
        }
        //pr($menus->toArray());exit;
        $this->set(compact('menus','userRightsIds'));
    }
    
    public function roleUserRight()
    {
        $role_id=$this->request->getData('role_id');
        $menus =  $this->AssignDashboards->DashboardSections->find();
        $userRights = $this->AssignDashboards->find()->where(['role_id'=>$role_id]);
        $menu_ids=[];
        $userRightsIds=[];
        foreach ($userRights as $userRight) 
        {
                $menu_ids[]=explode(',',$userRight->dashboard_section_ids);
        }
        foreach ($menu_ids as $key => $value) 
        {
            foreach ($value as $key1 => $value1) 
            {
                $userRightsIds[]=$value1;
            }
        }
        $this->set(compact('menus','userRightsIds'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Assign Dashboard id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $assignDashboard = $this->AssignDashboards->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $assignDashboard = $this->AssignDashboards->patchEntity($assignDashboard, $this->request->getData());
            if ($this->AssignDashboards->save($assignDashboard)) {
                $this->Flash->success(__('The assign dashboard has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The assign dashboard could not be saved. Please, try again.'));
        }
        $employees = $this->AssignDashboards->Employees->find('list', ['limit' => 200]);
        $roles = $this->AssignDashboards->Roles->find('list', ['limit' => 200]);
        $ddashboardSections = $this->AssignDashboards->DdashboardSections->find('list', ['limit' => 200]);
        $this->set(compact('assignDashboard', 'employees', 'roles', 'ddashboardSections'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Assign Dashboard id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $assignDashboard = $this->AssignDashboards->get($id);
        if ($this->AssignDashboards->delete($assignDashboard)) {
            $this->Flash->success(__('The assign dashboard has been deleted.'));
        } else {
            $this->Flash->error(__('The assign dashboard could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
