<p> Xin chào <?= $value ?></p>
<p> Cảm ơn bạn đã đăng ký vào hệ thống. Mời bạn xác nhận để đăng ký thành công! <?= $key ?></p>
<?= $this->Html->link(__('Xác nhận'), ['action' => 'active_user',$key]) ?>
<a href="http://localhost:81/demo_cakephp/active_user/$key">xac nhan</a>