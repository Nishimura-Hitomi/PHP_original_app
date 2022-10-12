<?php
require_once(__DIR__ .'/header.php');
$userModel = new \Poa\Model\User();
$user = $userModel->find($_POST['id']);
$app = new Poa\Controller\UserAdmin();
$app->run();
?>
<h1 class="page__ttl">ユーザー削除管理画面</h1>
<p class="user-disp">以下のユーザーを削除します。実行する場合は「削除」ボタンを押してください。</p>
<div class="container">
  <div class="form-group">
    <p>メールアドレス：<?= $user->email ?></p>
  </div>
  <div class="form-group">
    <p>ユーザー名：<?= $user->username ?></p>
  </div>
  <form class="user-delete user-confirm" action="" method="post">
    <a class="btn btn-primary" href="<?= SITE_URL; ?>/admin_users.php">まだしません</a>
    <input type="hidden" name="id" value="<?= $user->id ?>">
    <input type="submit" name="delete" class="btn btn-primary" value="削除">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  </form>
</div>