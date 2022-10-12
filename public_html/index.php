<?php
require_once(__DIR__ .'/header.php');
$threadMod = new Poa\Model\Thread();
$counter = 0;
?>
<div class="top__ttl">
  <h1 class="page__ttl">新着投稿</h1>
  <?php if(isset($_SESSION['me'])) { ?>
  <a href="<?= SITE_URL; ?>/thread_all.php">もっと見る＞</a>
</div>
<ul class="thread_top">
  <?php
  $threads = $threadMod->getThreadAll();
  foreach($threads as $thread):
  ?>
    <li class="thread_btn" data-threadid="<?= $thread->t_id; ?>">
      <div class="fav__btn<?php if(isset($thread->f_id)) { echo ' active';} ?>"><i class="fas fa-heart"></i></div>
      <a href="<?= SITE_URL; ?>/thread_disp.php?thread_id=<?= $thread->t_id; ?>"><img src="<?= './gazou/'.  h($thread->thread_img); ?>" alt=""></a>
    </li>
  <?php if($counter >= 8) {break;} $counter++; endforeach?>
</ul>
  <?php } else { ?>
  <a href="<?= SITE_URL; ?>/login.php">もっと見る＞</a>
</div>
<ul class="thread_top">
  <?php
  $threads = $threadMod->notLoginThread();
  foreach($threads as $thread):
  ?>
    <li class="thread_btn">
      <div class="fav__btn"><i class="fas fa-heart"></i></div>
      <a href="<?= SITE_URL; ?>/login.php"><img src="<?= './gazou/'.  h($thread->thread_img); ?>" alt=""></a>
    </li>
  <?php if($counter >= 8) {break;} $counter++; endforeach?>
</ul>
  <?php } ?>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>