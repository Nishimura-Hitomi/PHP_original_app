<?php
require_once(__DIR__ .'/../config/config.php');
$followApp = new \Poa\Model\Follow();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $res = $followApp->changeFollow([
      'follow_id' => $_POST['follow_id'],
      'user_id' => $_POST['user_id']
    ]);
    header('Content-Type: application/json');
    echo json_encode($res);
  } catch (Exception $e) {
    header($_SERVER['SERVER_PROTOCOL']. '500 Internal Server Error', true, 500);
    echo $e->getMessage();
  }
} else {
  header('Location: '. SITE_URL);
  exit();
}