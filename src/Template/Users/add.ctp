<h1>Add User</h1>
<?php
    echo $this->Form->create($user,['url'=>['action'=> 'add']]);
    echo $this->Form->control('name');
    echo $this->Form->control('email');
    echo $this->Form->control('username');
    echo $this->Form->control('password');
    echo $this->Form->text('check', ['type' => 'hidden', 'value' => 2]);
    echo $this->Form->button(__('Save'));
    echo $this->Form->end(); 
?>
