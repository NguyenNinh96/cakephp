<h1>Users</h1>
<div class="add">
    <ul class="side-nav">
       <li><?= $this->Html->link(__('Add user'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Logout'), ['action' => 'logout']) ?></li>
    </ul>    
</div>
<div class="search">
     <!-- <?php
      //  echo $this->Form->create('Search',['id'=>"test_ajax"]);
    ?> -->
    <fieldset>
        <?php
        echo $this->Form->input('Search');
        ?>
    </fieldset>
    <a href="javascript: void(0)" id="test_ajax">Submit</a>
  <!--    <?php
      //  echo $this->Form->button('Search');
    ?>
     <?php
      //  echo $this->Form->end();
    ?> -->
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
        <tr id = "<?php echo $user->id ?>">
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
                <!-- <?//= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> -->
                 <a href = "#" id= "<?php echo $user->id ?>" class="delete">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#test_ajax', function() {
            var keyword = $('#search').val();

            $.ajax({
                url: 'users/search', 
                type: 'POST', 
                data: {
                    keyword: keyword
                },
                success: function(res) {
                   //console.log(res);
                    $('.table').html(res);
                }
            });
        });
        $(document).on('click', '.delete', function() {
            var id = $(this).attr('id');
             $.ajax({
                 url: 'users/deleteAjax', 
                 type: 'POST', 
                 data: {
                     id: id
                 },
                 success: function() {
                     alert('Xoa thanh cong');
                    $('#'+id).remove();
                 }
             });
         });
    });
</script>
