<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Times Controller
 *
 * @property \App\Model\Table\TimesTable $Times
 */
class TimesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
		$request = $this->request;

        $customFinderOptions = [
            'request' => $request
        ];
        $query = $this->Times->find('UserTimes', $customFinderOptions);
        $this->set('times', $this->paginate($query));
        $this->set('_serialize', ['times']);
		$TimesObj = $this->_CrudData->load('Times');
		$TimesObj->addColumn('duration', ['type' => 'decimal', 'precision' => 2]);
		$TimesObj->whitelist(['user_id', 'project_id', 'activity', 'time_in', 'time_out', 'duration'], TRUE);
        $this->render('index');
    }

    /**
     * View method
     *
     * @param string|null $id Time id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $time = $this->Times->get($id, [
            'contain' => ['Users', 'Projects', 'Tasks']
        ]);
        $this->set('time', $time);
        $this->set('_serialize', ['time']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $time = $this->Times->newEntity();
        if ($this->request->is('post')) {
            $time = $this->Times->patchEntity($time, $this->request->data);
            if ($this->Times->save($time)) {
                $this->Flash->success(__('The time has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The time could not be saved. Please, try again.'));
            }
        }
        $users = $this->Times->Users->find('list', ['limit' => 200]);
        $projects = $this->Times->Projects->find('list', ['limit' => 200]);
        $groups = $this->Times->Groups->find('list', ['limit' => 200]);
        $tasks = $this->Times->Tasks->find('list', ['limit' => 200]);
        $statuses = [
            1 => 'OPEN',
            2 => 'REVEIW',
            4 => 'CLOSED',
            8 => 'PAUSED'
        ];
        $this->set(compact('time', 'users', 'projects', 'groups', 'tasks', 'statuses'));
        $this->set('_serialize', ['time']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Time id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $time = $this->Times->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $time = $this->Times->patchEntity($time, $this->request->data);
            if ($this->Times->save($time)) {
                $this->Flash->success(__('The time has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The time could not be saved. Please, try again.'));
            }
        }
        $users = $this->Times->Users->find('list', ['limit' => 200]);
        $projects = $this->Times->Projects->find('list', ['limit' => 200]);
        $groups = $this->Times->Groups->find('list', ['limit' => 200]);
        $tasks = $this->Times->Tasks->find('list', ['limit' => 200]);
        $statuses = [
            1 => 'OPEN',
            2 => 'REVEIW',
            4 => 'CLOSED',
            8 => 'PAUSED'
        ];
        $this->_CrudData->load('Times')->override(['status' => 'select']);
        $this->set(compact('time', 'users', 'projects', 'groups', 'tasks', 'statuses'));
        $this->set('_serialize', ['time']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Time id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $time = $this->Times->get($id);
        if ($this->Times->delete($time)) {
            $this->Flash->success(__('The time has been deleted.'));
        } else {
            $this->Flash->error(__('The time could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
