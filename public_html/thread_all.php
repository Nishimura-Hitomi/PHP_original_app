<?php
require_once(__DIR__ .'/header.php');
$threadMod = new Poa\Model\Thread();
$threads = $threadMod->getThreadAll();
?>
<div class="ttl_search">
  <h1 class="page__ttl">投稿一覧</h1>
  <form action="thread_search.php" method="get" class="form-group form-search">
    <div class="form-group">
      <input type="text" name="keyword" placeholder="スレッド検索">
    </div>
    <div class="form-group">
      <input type="submit" value="検索" class="btn btn-primary">
      <input type="hidden" name="type" value="searchthread">
    </div>
  </form>
</div>
<ul class="thread_top">
  <?php foreach($threads as $thread): ?>
    <li class="thread_btn" data-threadid="<?= $thread->t_id; ?>">
      <div class="fav__btn<?php if(isset($thread->f_id)) { echo ' active';} ?>"><i class="fas fa-heart"></i></div>
      <a href="<?= SITE_URL; ?>/thread_disp.php?thread_id=<?= $thread->t_id; ?>"><img src="<?= './gazou/'.  h($thread->thread_img); ?>" alt=""></a>
    </li>
  <?php endforeach?>
</ul>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>