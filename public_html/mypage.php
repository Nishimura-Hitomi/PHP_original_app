<?php
require_once(__DIR__ .'/header.php');
$app = new Poa\Controller\Mypage();
$user = $app->showUser();
?>
<h1 class="page__ttl">マイページ</h1>
  <div class="container">
    <div class="mypage_info">
      <div class="imgarea">
        <img src="<?= isset($user->image) ? './gazou/'. h($user->image) : './asset/img/noimage.png'; ?>" alt="">
        <p><?= h($user->username); ?></P>
      </div>
      <input type="button" class="btn btn-primary prof-text" onclick="location.href='myinfo.php'" value="プロフィールを編集">
    </div>
  </div>
  <div class="container mypage_thread">
    <h2 class="page__ttl">フォロー中のユーザー</h2>
    <ul class="follow_users">
    <?php
      $follows = $app->showfollow();
      foreach($follows as $follow):
    ?>
      <li>
        <div class="imgarea">
          <img src="<?= isset($follow->image) ? './gazou/'. h($follow->image) : './asset/img/noimage.png'; ?>" alt="">
          <p><?= h($follow->username); ?></P>
        </div>
      </li>
    <?php endforeach?>
    </ul>
  </div>
  <div class="container mypage_thread">
    <h2 class="page__ttl">自分の投稿</h2>
    <ul class="thread_top">
    <?php
      $threads = $app->showThread();
      foreach($threads as $thread):
    ?>
      <li class="thread_btn">
        <button type="button" class="btn btn-primary prof-text" onclick="location.href='<?= SITE_URL; ?>/thread_edit.php?thread_id=<?= $thread->id; ?>'">編集</button>
        <a href="<?= SITE_URL; ?>/thread_disp.php?thread_id=<?= $thread->id; ?>"><img src="<?= './gazou/'.  h($thread->thread_img); ?>" alt=""></a>
      </li>
    <?php endforeach?>
  </ul>
</div>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>