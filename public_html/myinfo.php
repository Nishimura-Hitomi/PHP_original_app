<?php
require_once(__DIR__ .'/header.php');
$app = new Poa\Controller\UserUpdate();
$app->run();
?>
<h1 class="page__ttl">プロフィール編集</h1>
<form action="" method="post" id="userupdate" class="form mypage-form" enctype="multipart/form-data">
  <div class="form-group" style="margin-bottom: 40px;">
    <div class="imgarea myinfo">
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
    <?php if(isset($app->getValues()->image) == null): ?>
      <input type="submit" class="btn btn-primary prof-text" formaction="image_delete.php" style="display:none" value="ユーザー画像削除">
    <?php else: ?>
      <input type="submit" class="btn btn-primary prof-text" formaction="image_delete.php" value="ユーザー画像削除">
    <?php endif; ?>
  </div>
  <div class="form-group">
    <label>メールアドレス</label>
    <input type="text" name="email" value="<?= isset($app->getValues()->email) ? h($app->getValues()->email): ''; ?>" class="form-control">
    <p class="err"><?= h($app->getErrors('email')); ?></p>
  </div>
  <div class="form-group">
    <label>ユーザー名</label>
    <input type="text" name="username" value="<?= isset($app->getValues()->username) ? h($app->getValues()->username): ''; ?>" class="form-control">
    <p class="err"><?= h($app->getErrors('username')); ?></p>
  </div>
  <button class="btn btn-primary" onclick="document.getElementById('userupdate').submit();">更新</button>
  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  <input type="hidden" name="old_image" value="<?= h($app->getValues()->image); ?>">
  <a href="./mypage.php">戻る</a>
</form>
<form class="user-delete" action="user_delete_confirm.php" method="post">
  <input type="submit" class="btn btn-default" value="退会する">
  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
</form>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>