<h1>Users</h1>
<div class="add">
    <ul class="side-nav">
       <li><?= $this->Html->link(__('Add user'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Logout'), ['action' => 'logout']) ?></li>
    </ul>    
</div>
<div class="table">
<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Username</th>
        <th class="actions"><?= __('Actions') ?></th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user->id ?></td>
        <td>
            <?= $user->name ?>
        </td>
        <td>
            <?= $user->email?>
        </td>
         <td>
            <?= $user->username?>
        </td>
       <td class="actions">
            <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</div>