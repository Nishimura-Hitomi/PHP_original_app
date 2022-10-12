<?php
require_once(__DIR__ .'/header.php');
$adminCon = new \Poa\Controller\UserAdmin();
$users = $adminCon->adminShow();
$adminCon->run();
?>
<h1 class="page__ttl">ユーザーテーブル管理画面</h1>
<form action="" method="post" id="admin" class="form-group">
  <div style="margin-bottom: 20px;">
    <input type="button" class="btn-primary" onclick="location.href='admin_signup.php'" value="新規登録画面へ">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  </div>
  <p>更新または削除を行うユーザーを選択してください。</p>
  <table class="table">
    <tbody>
      <tr>
        <th></th>
        <th></th>
        <th>id</th>
        <th>ユーザー名</th>
        <th>メールアドレス</th>
        <th>権限</th>
        <th>削除フラグ</th>
      </tr>
      <?php foreach($users as $user): ?>
      <tr>
        <td>
          <input type="radio" id="user_id" name="id" value="<?= h($user->id); ?>">
        </td>
        <td>
          <div class="imgarea">
            <img src="<?= isset($user->image) ? './gazou/'. h($user->image) : './asset/img/noimage.png'; ?>" alt="">
          </div>
          </td>
        <td>
          <?= h($user->id); ?>
        </td>
        <td>
          <?= h($user->username); ?>
        </td>
        <td>
          <?= h($user->email); ?>
        </td>
        <td>
          <?= h($user->authority); ?>
        </td>
        <td>
          <?= h($user->delflag); ?>
        </td>
      </tr>
      <?php endforeach?>
    </tbody>
  </table>
  <input type="submit" class="btn-primary" name="updatepage" value="更新" formaction="admin_update.php">
  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  <input type="submit" class="btn-primary" name="deletepage" value="削除" formaction="admin_delete_confirm.php">
  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
</form>
<script src="./js/admin.js"></script>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>