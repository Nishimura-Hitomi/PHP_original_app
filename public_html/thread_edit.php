<?php
require_once(__DIR__ .'/header.php');
$thread_id = $_GET['thread_id'];
$app = new Poa\Controller\ThreadUpdate();
$threadEdit = $app->showThread($thread_id);
$app->run();
?>
<h1 class="page__ttl">投稿編集</h1>
<form action="" method="post" class="form-group new_thread" id="edit_thread"  enctype="multipart/form-data">
  <div class="form-group">
    <div class="thread_new">
      <label>
        <span class="file-btn btn btn-info">
          画像選択
          <input type="file" name="image" class="form" style="display:none" accept="image/*">
        </span>
      </label>
      <div class="imgfile">
        <img src="<?= isset($app->getValues()->image) ? './gazou/'. h($app->getValues()->image) : ''; ?>" alt="">
      </div>
      <div class="new_ttl">
        <label>タイトル</label>
        <input type="text" name="title" class="form-control" value="<?= isset($app->getValues()->title) ? h($app->getValues()->title) : ''; ?>">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label>本文コメント</label>
    <textarea type="text" name="body" class="form-control"><?= isset($app->getValues()->body) ? h($app->getValues()->body) : ''; ?></textarea>
    <p class="err"><?= h($app->getErrors('title')); ?></p>
    <p class="err"><?= h($app->getErrors('body')); ?></p>
  </div>
  <div class="form-group btn btn-primary" onclick="document.getElementById('edit_thread').submit();">変更</div>
  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  <input type="hidden" name="old_image" value="<?= h($app->getValues()->image); ?>">
  <input type="hidden" name="thread_id" value="<?= $_GET['thread_id']; ?>">
  <a href="./mypage.php">戻る</a>
</form>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>