<h1>Register</h1>
<form method="post" action="http://localhost/demo_cakephp/users/add">
<?php
   // echo $this->Form->create(null,['url'=>['controller'=>'users','action'=> 'add']]);
    echo $this->Form->control('name');
    echo $this->Form->control('email');
    echo $this->Form->control('username');
    echo $this->Form->control('password');
    echo $this->Form->text('check', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->button(__('Save'));
    //echo $this->Form->end(); 
?>
</form>