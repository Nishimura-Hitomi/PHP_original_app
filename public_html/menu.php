<div id="mask"></div>
<div id="menu">
  <i class="closebtn1" id="close"></i>
  <div class="menu_text">
    <img src="./gazou/app-logo.png" alt="">
    <ul>
    <?php
      if(isset($_SESSION['me'])) { ?>
      <li><a href="<?= SITE_URL; ?>/thread_all.php">投稿一覧</a></li>
      <li><a href="<?= SITE_URL; ?>/thread_favorite.php">お気に入り</a></li>
      <li><a href="<?= SITE_URL; ?>/thread_create.php">新規作成</a></li>
      <li><a href="<?= SITE_URL; ?>/admin_users.php">管理者ページ</a></li>
      <?php } else { ?>
      <li><a href="<?= SITE_URL; ?>/login.php">投稿一覧</a></li>
      <li><a href="<?= SITE_URL; ?>/login.php">お気に入り</a></li>
      <li><a href="<?= SITE_URL; ?>/login.php">新規作成</a></li>
      <li><a href="<?= SITE_URL; ?>/login.php">管理者ページ</a></li>
      <?php } ?>
      </ul>
  </div>
</div>