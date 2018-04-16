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
        $this->Auth->allow(['register','add','activeUser']);
      //  $this->loadHelper('Html'); 
    }
    public $paginate = [
        'limit' => 5,
        'order' => [
            'Articles.title' => 'asc'
        ]
    ];
    public $components = array('RequestHandler');
    //var $helpers = array('Js','Paginator','Html');
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($search = null)
    {
        $users = $this->Users->find('all');
        // if($this->request->data != null){
        //     $search = $this->request->data['Search'];
        //     $users = $users->where(['OR' => ['name LIKE' => '%'.$search.'%', 'username LIKE' => '%'.$search.'%']]);
        // }
        $this->paginate($users);
        $this->set(compact('users'));
    }

    public function search() {
        $this->viewBuilder()->setLayout('');
        if ($this->request->is('post')) {
            $search = $this->request->data['keyword'];
            $users = $this->Users->find('all')->hydrate(false)->where(['OR' => ['name LIKE' => '%' . trim($search) . '%', 'username LIKE' => '%' . trim($search) . '%']]);
             $this->paginate($users)->toArray();
            $this->set('users', $users);
        }
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
       // dd($this->request->data);
       if ($this->request->is('post')) {
            //$this->request->data['password'] = Security::hash($this->request->data['password'],'md5');
            if ($this->request->data['check'] == 1){
                $user = $this->Users->patchEntity($user, $this->request->getData());
                $error = $user->errors();
                if (!empty($error)) {
                   die('Co loi xay ra. Vui long thu lai');
                }
                $key = $this->generateRandomString();
                $this->request->session()->write('user', ['user'=>$this->request->getData(),'key'=>$key]);
              
               // $this->request->session()->write('user', $key);
               // $user = $this->Users->patchEntity($user, $this->request->getData());
                //if ($this->Users->save($user)) {
                $this->Flash->success(__('Mời mở mail để xác nhận.'));
                $email = new Email('default');
                $email
                ->viewVars(['value' => $this->request->data['name'],'email' => $this->request->data['email'],'key'=> $key])
                ->template('welcome')
                ->emailFormat('html')
                ->from(['ninh.jvb@gmail.com' => 'My Site'])
                ->to($this->request->data['email'])
                ->subject('Xác nhận đăng ký')
                ->send();
                return $this->redirect(['action' => 'login']);
            }else{
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The user has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
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
     public function deleteAjax()
    {
        //$this->viewBuilder()->setLayout('');
        $this->autoRender = false;
        $id= $this->request->data['id'];
        $user = $this->Users->get($id);
        $this->Users->delete($user);
        // if ($this->Users->delete($user)) {
        //     $this->Flash->success(__('The user has been deleted.'));
        // } else {
        //     $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        // }
    }
    function login(){
        if($this->Auth->user()){
            return $this->redirect('/users');
        }
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                 $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
            $this->Flash->error(__('Username or password is incorrect'));
            }
        }
    }
    public function logout(){
        $this->redirect($this->Auth->logout());
    }
    public function register()
    {
       //  $user = $this->Users->newEntity();
       // // pr($user); die;
        
       //  if ($this->request->is('post')) {
       //      if (!empty($user->error)) {
       //          die('...');
       //      }
       //      $key = $this->generateRandomString();
       //      $this->request->session()->write('user', ['user'=>$this->request->getData(),'key'=>$key]);
          
       //     // $this->request->session()->write('user', $key);
       //     // $user = $this->Users->patchEntity($user, $this->request->getData());
       //      //if ($this->Users->save($user)) {
       //      $this->Flash->success(__('Mời mở mail để xác nhận.'));
       //      $email = new Email('default');
       //      $email
       //      ->viewVars(['value' => $this->request->data['name'],'email' => $this->request->data['email'],'key'=> $key])
       //      ->template('welcome')
       //      ->emailFormat('html')
       //      ->from(['ninh.jvb@gmail.com' => 'My Site'])
       //      ->to($this->request->data['email'])
       //      ->subject('Xác nhận đăng ký')
       //      ->send();
       //      return $this->redirect(['action' => 'login']);
       //     // }
       //     // $this->Flash->error(__('The user could not be saved. Please, try again.'));
       //  }
    }
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function activeUser($key) {

        $session=$this->request->session()->read('user');
        if(!$session['key']){
              return $this->redirect(['action' => 'login']);
        }
        if($key == $session['key']){
            $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user,$session['user']);
            if ($this->Users->save($user)) {
                $this->request->session()->delete('user');
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('Xác nhận không thành công. Mời đăng ký lại!'));
                return $this->redirect(['action' => 'register']); 
            }
        }
        
    }
}
