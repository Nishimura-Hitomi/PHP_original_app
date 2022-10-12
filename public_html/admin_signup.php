<?php
require_once(__DIR__ .'/header.php');
$app = new \Poa\Controller\UserAdminCreate();
$app->run();
?>
<h1 class="page__ttl">ユーザー新規作成管理画面</h1>
<form action="" method="post" class="form mypage-form" enctype="multipart/form-data">
  <div class="form-group" style="margin-bottom: 40px;">
    <div class="imgarea myinfo" style="margin-bottom: 40px;">
      <label>
        <span class="file-btn btn btn-info">
          画像選択
        <input type="file" name="image" class="form" style="display:none" accept="image/*">
        </span>
      </label>
      <div class="imgfile" style="margin-left: auto; margin-right: auto;">
        <img src="<?= isset($app->getValues()->image) ? './gazou/'. h($app->getValues()->image) : './asset/img/noimage.png'; ?>" alt="">
      </div>
    </div>
  <div class="form-group">
    <label>ユーザー名</label>
    <input type="text" name="username" value="<?= isset($app->getValues()->username) ? h($app->getValues()->username): ''; ?>" class="form-control">
    <p class="err"><?= h($app->getErrors('username')); ?></p>
  </div>
  <div class="form-group">
    <label>メールアドレス</label>
    <input type="text" name="email" value="<?= isset($app->getValues()->email) ? h($app->getValues()->email): ''; ?>" class="form-control">
    <p class="err"><?= h($app->getErrors('email')); ?></p>
  </div>
  <div class="form-group">
    <label>パスワード</label>
    <input type="password" name="password" class="form-control">
    <p class="err"><?= h($app->getErrors('password')); ?></p>
  </div>
  <div class="form-group">
    <label>権限</label>
    <select name="authority">
      <option value="1">1</option>
      <option value="99">99</option>
    </select>
  </div>
  <div class="form-group">
    <label>削除フラグ</label>
    <select name="delflag">
      <option value="0">0</option>
      <option value="1">1</option>
    </select>
  </div>
  </div>
  <input type="submit" class="btn btn-primary" name="create" value="作成">
  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  <a href="./admin_users.php">戻る</a>
</form>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>