<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 */
class ProjectsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clients']
        ];
        $this->set('projects', $this->paginate($this->Projects));
        $this->set('_serialize', ['projects']);
    }

    /**
     * View method
     *
     * @param string|null $id Project id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => [
                'Clients', 
                'Tasks', 
                'Times' => [
                    'Users',
                    'Tasks'
                ]
            ]
        ]);
        $this->configIndex('Times');
        $timeCrudObject = $this->_CrudData->load('Times');
		$timeCrudObject->table()->schema()->addColumn('duration', ['type' => 'decimal', 'precision' => 2]);
        $timeCrudObject->overrideAction(['index' => 'projectTime']);
        $timeCrudObject->override([
            'time_out' => 'duration'
        ]);
        $timeCrudObject->blacklist(['project_id', 'status']);
        $this->set('project', $project);
        $this->set('_serialize', ['project']);
        $this->render('view');
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($proj = NULL, $redir = FALSE)
    {
        $project = $this->Projects->newEntity();
        if ($this->request->is('post')) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));
                if(isset($this->request->data['redir'])){
                    $redir = $this->request->data['redir'] . "/project_id:{$project->id}";
                    return $this->redirect($redir);
                } else {
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
        }
        if(!is_null($proj)){
            $project_client = $this->Projects->get($proj);
            $project->client_id = $project_client->client_id;
        }
        if($redir){
            $this->Projects->schema()->addColumn('redir', 'string');
            $project->redir = $this->request->referer();
        }
		$projectsCongif = $this->_CrudData->load('Projects');
        $projectsCongif->whitelist(['client_id', 'name', 'note', 'state', 'redir']);
        $projectsCongif->addAttributes('redir', ['input' => ['type'=> 'hidden']]);
        $clients = $this->Projects->Clients->find('list', ['limit' => 200]);
        $this->set(compact('project', 'clients'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
        }
        $clients = $this->Projects->Clients->find('list', ['limit' => 200]);
        $this->set(compact('project', 'clients'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $project = $this->Projects->get($id);
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('The project has been deleted.'));
        } else {
            $this->Flash->error(__('The project could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function summary($project_id = null, $start_date = null, $end_date = null) {
        if ($end_date === null){
            $end_date = time();
        }
        if($project_id === null || $start_date === null){
            $this->Flash->error(__('We cannot summarize without a project or start date.'));
            return FALSE;
        }
        $project = $this->Projects->find();
        $project->where(['Projects.id' => $project_id]);
        $project->contain([
            'Clients',
            'Tasks',
            'Times' => function ($q) use ($start_date, $end_date) {
                return $q
                    ->where(function ($exp, $q) use ($start_date, $end_date) {
                        return $exp->between('time_in', $start_date, $end_date);
                        })
                    ->contain(['Users', 'Tasks']);
            }
        ]);
        $this->set(compact('project'));
    }
}
