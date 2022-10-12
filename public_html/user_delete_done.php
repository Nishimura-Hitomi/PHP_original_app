<?php
require_once(__DIR__ .'/header.php');
$app = new Poa\Controller\UserDelete();
$app->run();
?>
<h1 class="page__ttl">ユーザー退会</h1>
<p class="user-disp">退会処理が完了しました。ご利用ありがとうございました。</p>
<a href="<?= SITE_URL; ?>/index.php">トップ画面へ</a>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>