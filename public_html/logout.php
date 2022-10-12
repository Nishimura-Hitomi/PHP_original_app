<?php
require_once(__DIR__ .'/header.php');
$app = new Poa\Controller\Logout();
$app->run();
?>
<div class="container">
  <p class="user-disp">ログアウトしました。</p>
  <a href="<?= SITE_URL; ?>/index.php">トップ画面へ</a>
</div>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>