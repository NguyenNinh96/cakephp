<div class="users form">
<?= $this->Flash->render() ?>
<?= $this->Form->create('',['id'=>'login']) ?>
<?= $this->Html->link(__('Register'), ['action' => 'register']) ?>
    <fieldset>
        <legend><?= __('Login') ?></legend>
        <?= $this->Form->control('username',['id' => 'username','required'=>'true']) ?>
        <span id = "username_error"></span>
        <?= $this->Form->control('password',['required'=>'true']) ?>
    </fieldset>
<?= $this->Form->button(__('Login'),['id'=>'ok']); ?>
<?= $this->Form->end() ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#login').on('click','#ok',function{
			var username = $.trim($('#username').val());
			if (username == '' || username.length < 4){
            $('#username_error').text('Tên đăng nhập phải lớn hơn 4 ký tự');
            flag = false;
        }
		})
	});
</script>