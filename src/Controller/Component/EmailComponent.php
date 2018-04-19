<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Mailer\Email;
class EmailComponent extends Component
{
	public function sendEmail($email,$name,$key)
	{
		$newEmail = new Email('default');
		$newEmail
		->viewVars(['value' => $name,'email' => $email,'key'=> $key])
		->template('welcome')
		->emailFormat('html')
		->from(['ninh.jvb@gmail.com' => 'My Site'])
		->to($email)
		->subject('Xác nhận đăng ký')
		->send();
	}
}
?>