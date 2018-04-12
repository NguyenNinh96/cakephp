<?php
namespace App\Controller;

use App\Controller\AppController;
use Auth;
use Cake\Utility\Security;
use Cake\Event\Event;
use Cake\Mailer\Email;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['register']);
        $this->loadHelper('Session');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->Users->find('all');

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            //$this->request->data['password'] = Security::hash($this->request->data['password'],'md5');
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    function login(){
        if ($this->request->is('post')) {
       // dd($this->request);
        $user = $this->Auth->identify();

        if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect($this->Auth->redirectUrl());
        } else {
            $this->Flash->error(__('Username or password is incorrect'));
        }
    }
    }
    function logout(){
        $this->redirect($this->Auth->logout());
    }
    public function register()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $this->request->session()->write('user', $this->request->getData());
            $key = $this->generateRandomString();
            $this->request->session()->write('key', $key);
           // $user = $this->Users->patchEntity($user, $this->request->getData());
            //if ($this->Users->save($user)) {
                $this->Flash->success(__('Mời mở mail để xác nhận.'));
                $email = new Email('default');
                $email
                    ->viewVars(['value' => $this->request->data['name'], $key])
                    ->template('welcome')
                    ->emailFormat('html')
                    ->from(['ninh.jvb@gmail.com' => 'My Site'])
                    ->to($this->request->data['email'])
                    ->subject('Xác nhận đăng ký')
                    ->send();
                return $this->redirect(['action' => 'login']);
           // }
           // $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function active_user($key) {
       if($key == $this->request->session()->read('key')){
            $user = $this->Users->patchEntity($user, $this->request->session()->read('user') );
            if ($this->Users->save($user)) {
                return $this->redirect(['action' => 'index']);
            }
       } 
    }

}
