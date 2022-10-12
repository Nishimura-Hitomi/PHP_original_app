<?php
require_once(__DIR__ .'/../config/config.php');
if(isset($_POST['type'])) {
  $thread_id = $_POST['thread_id'];
  $threadCon = new Poa\Controller\CommentCsv();
  $threadCon->outputCsv($thread_id);
  exit();
} else {
  header('Location: '. SITE_URL . '/thread_all.php');
  exit();
}
?>