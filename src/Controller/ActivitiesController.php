<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Activities Controller
 *
 * @property \App\Model\Table\ActivitiesTable $Activities
 */
class ActivitiesController extends AppController
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
        $query = $this->Activities->find('UserActivities', $customFinderOptions);
        $this->set('activities', $this->paginate($query));
        $this->set('_serialize', ['activities']);
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
        $activity = $this->Activities->get($id, [
            'contain' => ['Users', 'Projects', 'Tasks']
        ]);
        $this->set('activity', $activity);
        $this->set('_serialize', ['activity']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activity = $this->Activities->newEntity();
        if ($this->request->is('post')) {
            $activity = $this->Activities->patchEntity($activity, $this->request->data);
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The activity could not be saved. Please, try again.'));
            }
        }
        $users = $this->Activities->Users->find('list', ['limit' => 200]);
        $projects = $this->Activities->Projects->find('list', ['limit' => 200]);
        $groups = $this->Activities->Groups->find('list', ['limit' => 200]);
        $tasks = $this->Activities->Tasks->find('list', ['limit' => 200]);
        $statuses = [
            1 => 'OPEN',
            2 => 'REVEIW',
            4 => 'CLOSED',
            8 => 'PAUSED'
        ];
        $this->set(compact('activity', 'users', 'projects', 'groups', 'tasks', 'statuses'));
        $this->set('_serialize', ['activity']);
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
        $activity = $this->Activities->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->data);
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The activity could not be saved. Please, try again.'));
            }
        }
        $users = $this->Activities->Users->find('list', ['limit' => 200]);
        $projects = $this->Activities->Projects->find('list', ['limit' => 200]);
        $groups = $this->Activities->Groups->find('list', ['limit' => 200]);
        $tasks = $this->Activities->Tasks->find('list', ['limit' => 200]);
        $statuses = [
            1 => 'OPEN',
            2 => 'REVEIW',
            4 => 'CLOSED',
            8 => 'PAUSED'
        ];
        $this->set(compact('activity', 'users', 'projects', 'groups', 'tasks', 'statuses'));
        $this->set('_serialize', ['activity']);
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
        $activity = $this->Activities->get($id);
        if ($this->Activities->delete($activity)) {
            $this->Flash->success(__('The activity has been deleted.'));
        } else {
            $this->Flash->error(__('The activity could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
