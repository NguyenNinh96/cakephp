<div class="users form">
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
<?= $this->Html->link(__('Register'), ['action' => 'register']) ?>
    <fieldset>
        <legend><?= __('Login') ?></legend>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
<?= $this->Form->button(__('Login')); ?>
<?= $this->Form->end() ?>
</div>
