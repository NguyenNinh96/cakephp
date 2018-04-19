<?php
namespace App\Controller;

use App\Controller\AppController;
use Auth;
use Cake\Utility\Security;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Auth\FormAuthenticate;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public $paginate = [
        'limit' => 3,
        'order' => [
            'Articles.title' => 'asc'
        ]
    ];
    public $components = array('RequestHandler');
    
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
        $this->loadComponent('Email');
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
        //$s = $this->Test->sum(1,2);
        //pr($s);die;
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
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Tài khoản đã được tạo.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Tạo tài khoản không thành công.'));
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
                $this->Flash->success(__('Chỉnh sửa thành công.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Chỉnh sửa chưa thành công.'));
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
            $this->Flash->success(__('Xóa thành công'));
        } else {
            $this->Flash->error(__('Xóa không thành công.'));
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
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('User đã xóa thành công'));
        } else {
            $this->Flash->error(__('Xóa không thành công.'));
        }
    }
    function login(){

        $this->viewBuilder()->setLayout('mylayout');
        if($this->Auth->user()){
            return $this->redirect('/users');
        }
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                 $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
            $this->Flash->error(__('Tên hoặc mật khẩu chưa đúng!'));
            }
        }
    }
    public function loginAPI(){
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $this->request->data = $this->request->query;
            $user = $this->Auth->identify();
            if (!empty($user)) {
                $rs = ['code' => 1, 'message' => 'Đăng nhập thành công!'];
            } else {
                $rs = ['code' => 0, 'message' => 'Đăng nhập thất bại!'];
            }
            $this->response->body(json_encode($rs));
        }
    }
    public function logout(){
        $this->redirect($this->Auth->logout());
    }
    public function register()
    {
        $this->viewBuilder()->setLayout('mylayout');
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if (!empty($user->errors())) {
                $this->Flash->error(__('Đăng ký không thành công mời đăng ký lại'));
                return $this->redirect(['action' => 'register']);
            }
            $key = $this->generateRandomString();
            $this->request->session()->write('users', ['user'=>$user,'key'=>$key]);
            $this->Email->sendEmail($this->request->data['email'],$this->request->data['name'],$key);
            $this->Flash->success(__('Mời vào mail để xác nhận.'));
            return $this->redirect(['action' => 'login']);
        }
         $this->set(compact('user'));
    }
    
    public function activeUser($key) {
        $this->autoRender = false;
        $session=$this->request->session()->read('users');
        if(!$session['key']){
              return $this->redirect(['action' => 'login']);
        }
        if($key == $session['key']){
            if ($this->Users->save($session['user'])) {
                $this->request->session()->delete('user');
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('Xác nhận không thành công. Mời đăng ký lại!'));
                return $this->redirect(['action' => 'register']); 
            }
        }
    }
    public function checkUser(){
        $this->autoRender = false;
        $username = $this->request->data['username'];
      //  pr($username);die;
            if (isset($username)) {
                $check = $this->Users->find('all')->hydrate(false)->where(['Users.username' => $username])->toArray();
                if(!empty($check)) {
                    die(json_encode(['code'=>1]));
                }else{
                    die(null);
                }
        }
    }
}
