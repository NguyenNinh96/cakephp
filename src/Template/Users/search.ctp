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
        <td><?php echo $user['id']; ?></td>
        <td><?php echo $user['name']; ?></td>
        <td>
            <?php echo $user['email']; ?>
        </td>
        <td>
            <?php echo $user['username']; ?>
        </td>
        <td class="actions">
            <?= $this->Html->link(__('View'), ['action' => 'view', $user['id']]) ?>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user['id']]) ?>
            <a href = "#" id= "<?php echo $user['id'] ?>" class="delete">Delete</a>
         </td>
    </tr>
    <?php endforeach; ?>
</table>