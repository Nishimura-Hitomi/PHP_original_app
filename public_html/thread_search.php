<?php
require_once(__DIR__ .'/header.php');
$threadCon = new Poa\Controller\ThreadSearch();
$threadMod = new Poa\Model\Thread();
$threads = $threadCon->run();
?>
<h1 class="page__ttl">投稿名検索</h1>
<form action="" method="get" class="form-group form-search">
  <div class="form-group">
    <input type="text" name="keyword" value="<?= isset($threadCon->getValues()->keyword) ? h($threadCon->getValues()->keyword): ''; ?>" placeholder="投稿検索">
  </div>
  <div class="form-group">
    <input type="submit" value="検索" class="btn btn-primary">
    <input type="hidden" name="type" value="searchthread">
  </div>
</form>
<p class="err"><?= h($threadCon->getErrors('keyword')); ?></p>
<?php $threads != '' ? $con = count($threads) : '';?>
<?php if (($threadCon->getErrors('keyword'))): ?>
<?php else : ?>
<div style="margin-bottom: 20px;">キーワード：<?= $_GET['keyword']; ?>　　該当件数：<?= $con; ?>件</div>
<?php endif; ?>
<ul class="thread_top">
<?php if (isset($con) > 0): ?>
  <?php foreach($threads as $thread): ?>
    <li class="thread_btn" data-threadid="<?= $thread->t_id; ?>">
      <div class="fav__btn<?php if(isset($thread->f_id)) { echo ' active';} ?>"><i class="fas fa-heart"></i></div>
      <a href="<?= SITE_URL; ?>/thread_disp.php?thread_id=<?= $thread->t_id; ?>"><img src="<?= './gazou/'.  h($thread->thread_img); ?>" alt=""></a>
    </li>
  <?php endforeach?>
<?php else: ?>
  <p>キーワードに該当するスレッドが見つかりませんでした。</p>
<?php endif;?>
</ul>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>