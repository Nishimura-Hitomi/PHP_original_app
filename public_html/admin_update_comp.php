<?php
require_once(__DIR__ .'/header.php');
$app = new Poa\Controller\Logout();
$app->run();
?>
<h1 class="page__ttl">ユーザー更新管理画面</h1>
<p>ユーザーの更新が完了しました。</p>
<a href="<?= SITE_URL; ?>/admin_users.php">ユーザー管理画面へ</a>
</div>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>