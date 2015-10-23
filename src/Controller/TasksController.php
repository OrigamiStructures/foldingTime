<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TasksController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Projects']
        ];
        $this->set('tasks', $this->paginate($this->Tasks));
        $this->set('_serialize', ['tasks']);
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['Projects', 'Times']
        ]);
        $this->set('task', $task);
        $this->set('_serialize', ['task']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($proj = NULL, $redir = FALSE)
    {
        $task = $this->Tasks->newEntity();
        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->data);
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));
                if(isset($this->request->data['redir'])){
                    $redir = $this->request->data['redir'] . "/task_id:{$task->id}";
                    return $this->redirect($redir);
                } else {
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        }
        if(!is_null($proj)){
            $task->project_id = $proj;
        }
        if($redir){
            $this->Tasks->schema()->addColumn('redir', 'string');
            $task->redir = $this->request->referer();
        }
		
		// JASON JASON JASON JASON JASON JASON
		// ===================================
		// I would recommend something like this to avoid the overhead of 
		// calling CrudData->load() multiple times. Slightly shorter too
		$tasksConfig = $this->_CrudData->load('Tasks');
        $tasksConfig->whitelist(['project_id', 'name', 'note', 'state', 'redir']);
        $tasksConfig->addAttributes('redir', ['input' => ['type'=> 'hidden']]);
		
        $projects = $this->Tasks->Projects->find('list', ['limit' => 200]);
        $projects->where(['Projects.state' => 'active']);
        $states = ['active', 'inactive'];
        $this->set(compact('task', 'projects', 'states'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->request->data);
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        }
        $projects = $this->Tasks->Projects->find('list', ['limit' => 200]);
        $this->set(compact('task', 'projects'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $task = $this->Tasks->get($id);
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__('The task has been deleted.'));
        } else {
            $this->Flash->error(__('The task could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
