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
        $this->layout = 'base';
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
        $projects = $this->Activities->Projects->find('list')
                ->where(['state' => 'active']);
        $groups = $this->Activities->Groups->find('list', ['limit' => 200]);
        $tasks = $this->Activities->Tasks->find('list')
                ->where(['state' => 'active']);
        $statuses = [
            1 => 'OPEN',
            2 => 'REVEIW',
            4 => 'CLOSED',
            8 => 'PAUSED'
        ];
        $this->set(compact('activity', 'users', 'projects', 'groups', 'tasks', 'statuses'));
        $this->set('_serialize', ['activity']);
        $this->layout = 'base';
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
        $this->layout = 'base';
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
    
    
    
    public function saveField() {
        $result = array();
        $this->layout = 'ajax';
        $this->Activity->id = $this->request->data['id'];
        if($this->request->data['fieldName'] == 'duration'){
            $this->saveDuration();
        } else {
            $this->saveStandard();
        }
        $result['result'] = $this->Activity->save($this->request->data);
        $result['duration'] = substr($this->Activity->field('Activity.duration', array('Activity.id' => $this->request->data['Activity']['id'])),0,5);
        $this->set('result', $result);
        $this->render('/Elements/json_return');
    }
    
    private function saveDuration() {
        $time = explode(':', $this->request->data['value']);
        if (count($time) == 1) {
            $durSeconds = ($time[0] * MINUTE);
        }  else {
            $durSeconds = ($time[0] * HOUR + $time[1] * MINUTE);
        }      
        $timeIn = date('Y-m-d H:i:s', time() - $durSeconds);
        $timeOut = date('Y-m-d H:i:s', time());
        $this->request->data= array(
            'Activity' => array(
                'id' => $this->request->data['id'],
                'time_in' => $timeIn,
                'time_out' => $timeOut
            )
        );
    }
    
    private function saveStandard() {
        $this->request->data = array(
            'Activity' => array(
                'id' => $this->request->data['id'],
                $this->request->data['fieldName'] => $this->request->data['value']
        ));
    }
    
	/**
	 * Close a time record
	 * 
	 * Same as pause, but with a different state
	 * 
	 * @param string $id
	 * @param int $state
	 */
    public function timeStop($id, $state = CLOSED) {
        $this->layout = 'ajax';
        $time = new \Cake\I18n\Time;
        $activity = $this->Activities->get($id);
        if($activity->status != PAUSED){
            $activity->time_out = $time;
        }
        $activity->status = $state;
        $element = $this->saveActivityChange($activity);
        $this->render($element, ['activity', $this->Activities->get($id)]);
    }
    
	/**
	 * Pause a time record
	 * 
	 * @param string $id
	 */
    public function timePause($id) {
		$this->timeStop($id, PAUSED);
    }
    
	/**
	 * Restart a stopped or paused time record
	 * 
	 * @param string $id
	 */
    public function timeRestart($id) {
        $this->layout = 'ajax';
        $duration = $this->Activity->field('duration', array('Activity.id' => $id));
        $this->request->data('id', $id)
                ->data('value', $duration);
        $this->saveDuration();
        $this->request->data('Activity.status', OPEN);
        $element = $this->saveActivityChange($id);
        $this->render($element, ['activity' => $this->request->data[$id]]);
    }

    /**
	 * Save time record and choose prepare view based on save result
	 * 
	 * @param string $id
	 * @return string The element to render
	 */
    private function saveActivityChange($activity) {
        if(!$this->Activities->save($activity)){
            $this->Session->setFlash('The record update failed, please try again.');
            $element = '/Element/ajax_flash';
        } else {
            $element = '/Element/track_row';
        }
        return $element;
    }

    /**
	 * Set the users, projects and tasks viewVars for UI forms
	 * 
	 * @param string $type filtering desired for project/task lists
	 */
	private function setUiSelects($type = 'all') {
        $UsersTable = \Cake\ORM\TableRegistry::get('Users');
        $users = $UsersTable->find('list')
                ->toArray();
        $ProjectsTable = \Cake\ORM\TableRegistry::get('Projects');
		$projects = $this->Activities->Projects->find('list')
                ->where(['state' => 'active'])
                ->toArray();
        $TasksTable = \Cake\ORM\TableRegistry::get('Tasks');
		$tasks = $this->Task->groupedTaskList($type);
        $this->set(compact('users', 'projects', 'tasks'));
		
	}



}
