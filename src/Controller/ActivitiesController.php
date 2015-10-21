<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

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
            $activity->time_in = new Time();
            $activity->time_out = $activity->time_in;
            $activity->status = 1;
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The activity could not be saved. Please, try again.'));
            }
        }
        $users = $this->Activities->Users->find('list');
        $projects = $this->Activities->Projects->find('list')
                ->where(['state' => 'active']);
        $tasks = $this->Activities->Tasks->find('tasksByProject', ['where' => ['state' => 'active']]);
        $allTasks = $this->jsonTasks($this->Activities->Tasks->find('tasksByProject'));
        $statuses = [
            1 => 'OPEN',
            2 => 'REVEIW',
            4 => 'CLOSED',
            8 => 'PAUSED'
        ];
        $this->set(compact('activity', 'users', 'projects', 'tasks', 'statuses', 'allTasks'));
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
            if($activity->getOriginal('duration') != $this->request->data['duration']){
                $activity = $this->changeDuration($activity, $this->request->data['duration']);
            } else {
                $activity->time_in = new Time($activity->time_in_view);
                $activity->time_out = new Time($activity->time_out_view);
            }
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The activity could not be saved. Please, try again.'));
            }
        }
        \App\Lib\dmDebug::ddd($this->request->params);
        if(isset($this->request->named['project_id'])){
            $activity->project_id = $this->request->named['project_id'];
        }
        $users = $this->Activities->Users->find('list', ['limit' => 200]);
        $projects = $this->Activities->Projects->find('list', ['limit' => 200]);
        $tasks = $this->Activities->Tasks->find('list', ['limit' => 200]);
        $allTasks = $this->jsonTasks($this->Activities->Tasks->find('tasksByProject'));
        $statuses = [
            1 => 'OPEN',
            2 => 'REVEIW',
            4 => 'CLOSED',
            8 => 'PAUSED'
        ];
        $activity->time_in_view = $activity->time_in->i18nFormat();
        $activity->time_out_view = $activity->time_out->i18nFormat();
        $this->set(compact('activity', 'users', 'projects', 'tasks', 'statuses', 'allTasks'));
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
            $this->changeDuration();
        } else {
            $this->saveStandard();
        }
        $result['result'] = $this->Activity->save($this->request->data);
        $result['duration'] = substr($this->Activity->field('Activity.duration', array('Activity.id' => $this->request->data['Activity']['id'])),0,5);
        $this->set('result', $result);
        $this->render('/Elements/json_return');
    }
    
    private function changeDuration($activity, $durr = FALSE) {
        $durr = $durr ? $durr * HOUR : $activity->duration * HOUR;
        $activity->time_in = new Time("$durr seconds ago");
        $activity->time_out = new Time();
        return $activity;
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
        $activity = $this->Activities->get($id, [
            'contain' => ['Projects', 'Tasks']
        ]);
        if($activity->status != PAUSED){
            $activity->time_out = $time;
        }
        $activity->status = $state;
        $this->saveActivityChange($activity);
        $this->set(compact('activity'));
        $this->render('/Element/json_return');
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
        $activity = $this->Activities->get($id, [
            'contain' => ['Projects', 'Tasks']
        ]);
        $activity = $this->changeDuration($activity);
        $activity->status = OPEN;
        $this->saveActivityChange($activity);
        $this->set(compact('activity'));
        $this->render('/Element/json_return');
    }

    /**
	 * Save time record and choose prepare view based on save result
	 * 
	 * @param string $id
	 * @return string The element to render
	 */
    private function saveActivityChange($activity) {
        if(!$this->Activities->save($activity)){
            $this->Flash->set('The record update failed, please try again.');
            $this->set('success', FALSE);
            $this->set('element', 'error');
        } else {
            $this->set('success', TRUE);
            $this->set('element', 'track_row');
        }
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
    
	/**
	 * Duplicate a record for a new activity record
	 */
    public function duplicateActivityRow($id) {
        $this->layout = 'ajax';
        $activity = $this->Activities->get($id, [
            'contain' => ['Projects', 'Tasks']
        ]);
        $dupe = $this->Activities->newEntity();
        $dupe->activity = $activity->activity;
        $dupe->project_id = $activity->project_id;
        $dupe->task_id = $activity->task_id;
        $dupe->user_id = $this->request->session()->read('Auth.User.id');
        $dupe->time_in = new Time();
        $dupe->time_out = $dupe->time_in;
        $dupe->status = 1;
        $this->saveActivityChange($dupe);
        $id = $dupe->id;
        $activity = $this->Activities->get($id, [
            'contain' => ['Projects', 'Tasks']
        ]);
        $this->set('activity', $activity);
        $this->render('/Element/json_return');
    }
    
    /**
     * Delete an activity row
     */
    public function deleteActivityRow($id) {
        $this->layout = 'ajax';
        $activity = $this->Activities->get($id, [
            'contain' => ['Projects', 'Tasks']
        ]);
        $this->set('activity', $activity);
        if ($this->Activities->delete($activity)) {
            $this->set('success', TRUE);
            $this->set('element', 'track_row');
        } else {
            $this->Flash->set('The delete failed, please try again.');
            $this->set('success', FALSE);
            $this->set('element', 'error');
        }
        $this->render('/Element/json_return');
    }
    
    public function jsonTasks($tasks) {
        $output = '{';
        foreach ($tasks as $proj_id => $proj_tasks) {
            $output .= "'$proj_id':{\n";
            foreach ($proj_tasks as $key => $value) {
                $html_val = h($value);
                $output .= "'$key':'{$html_val}',\n";
            }
            trim($output, ",\n");
            $output .= "},\n";
        }
        trim($output,",\n");
        $output .= "}";
        return $output;
    }



}
