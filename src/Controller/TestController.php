<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TestController Controller
 *
 *
 * @method \App\Model\Entity\TestController[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TestController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $testController = $this->paginate($this->TestController);

        $this->set(compact('testController'));
    }

    /**
     * View method
     *
     * @param string|null $id Test Controller id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view()
    {
       $testController=1;
        $this->set('testController', $testController);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $testController = $this->TestController->newEntity();
        if ($this->request->is('post')) {
            $testController = $this->TestController->patchEntity($testController, $this->request->getData());
            if ($this->TestController->save($testController)) {
                $this->Flash->success(__('The test controller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test controller could not be saved. Please, try again.'));
        }
        $this->set(compact('testController'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Test Controller id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $testController = $this->TestController->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $testController = $this->TestController->patchEntity($testController, $this->request->getData());
            if ($this->TestController->save($testController)) {
                $this->Flash->success(__('The test controller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test controller could not be saved. Please, try again.'));
        }
        $this->set(compact('testController'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Test Controller id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $testController = $this->TestController->get($id);
        if ($this->TestController->delete($testController)) {
            $this->Flash->success(__('The test controller has been deleted.'));
        } else {
            $this->Flash->error(__('The test controller could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
