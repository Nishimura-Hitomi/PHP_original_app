<?php
require_once(__DIR__ .'/header.php');
$adminCon = new \Poa\Controller\UserAdmin();
$adminCon->run();
$userMod = new \Poa\Model\User();
$user = $userMod->find($_POST['id']);
?>
<h1 class="page__ttl">ユーザー更新管理画面</h1>
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
        <img src="<?= isset($user->image) ? './gazou/'. h($user->image) : './asset/img/noimage.png'; ?>" alt="">
      </div>
    </div>
  <div class="form-group">
    <label>ユーザー名</label>
    <input type="text" name="username" value="<?= h($user->username); ?>" class="form-control">
    <p class="err"><?= h($adminCon->getErrors('username')); ?></p>
  </div>
  <div class="form-group">
    <label>メールアドレス</label>
    <input type="text" name="email" value="<?= h($user->email); ?>" class="form-control">
    <p class="err"><?= h($adminCon->getErrors('email')); ?></p>
  </div>
  <div class="form-group">
    <label>権限</label>
    <select name="authority">
      <option value="<?= h($user->authority); ?>"><?= $user->authority ?></option>
      <?php if($user->authority === "1"): ?>
      <option value="99">99</option>
      <?php else: ?>
      <option value="1">1</option>
      <?php endif; ?>
    </select>
  </div>
  <div class="form-group">
    <label>削除フラグ</label>
    <select name="delflag">
      <option value="<?= h($user->delflag); ?>"><?= $user->delflag ?></option>
      <?php if($user->delflag === "0"): ?>
      <option value="1">1</option>
      <?php else: ?>
      <option value="0">0</option>
      <?php endif; ?>
    </select>
  </div>
  </div>
  <input type="submit" class="btn btn-primary" name="update" value="更新">
  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  <input type="hidden" name="old_image" value="<?= h($user->image); ?>">
  <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
  <a href="./admin_users.php">戻る</a>
</form>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>