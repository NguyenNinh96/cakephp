<div class="users form">
<?= $this->Flash->render() ?>
<?= $this->Form->create(null,['id'=>'login']) ?>
<?= $this->Html->link(__('Register'), ['action' => 'register']) ?>
    <fieldset>
        <legend><?= __('Login') ?></legend>
        <?= $this->Form->control('username',['id' => 'username','required'=>'true']) ?>
        <?= $this->Form->control('password',['required'=>'true']) ?>
    </fieldset>
<?= $this->Form->button(__('Login')); ?>
<?= $this->Form->end() ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#login").validate({
            rules:{
                username:{
                    required: true,
                    minlength: 3 
                },
                password:{
                    required: true,
                    minlength: 6,
                } 
            },
            messages: {
                username :{
                    required: "Username không được để trống",
                    minlength :"Username phải lớn hơn 3 ký tự"
                },
                password :{
                    required: "Password không được để trống",
                    minlength :"Password phải lớn hơn 6 ký tự"
                }  
            }
        })
	});
</script>