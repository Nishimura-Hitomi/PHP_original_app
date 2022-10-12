<?php
require_once(__DIR__ .'/header.php');
$app = new Poa\Controller\ThreadCreate();
$app->run();
?>
<h1 class="page__ttl">新規投稿</h1>
<form action="" method="post" class="form-group new_thread" id="new_thread"  enctype="multipart/form-data">
  <div class="form-group">
    <div class="thread_new">
      <label>
        <span class="file-btn btn btn-info">
          画像選択
          <input type="file" name="image" class="form" style="display:none" accept="image/*">
        </span>
      </label>
      <div class="imgfile">
        <img src="<?= isset($app->getValues()->image) ? './gazou/'. h($app->getValues()->image) : './asset/img/noimage.png'; ?>" alt="">
      </div>
      <div class="new_ttl">
        <label>タイトル</label>
        <input type="text" name="thread_name" class="form-control" value="<?= isset($app->getValues()->thread_name) ? h($app->getValues()->thread_name) : ''; ?>">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label>本文コメント</label>
    <textarea type="text" name="body" class="form-control"><?= isset($app->getValues()->body) ? h($app->getValues()->body) : ''; ?></textarea>
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    <input type="hidden" name="type" value="createthread">
    <p class="err"><?= h($app->getErrors('create_thread')); ?></p>
  </div>
  <div class="form-group btn btn-primary" onclick="document.getElementById('new_thread').submit();">作成</div>
</form>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>