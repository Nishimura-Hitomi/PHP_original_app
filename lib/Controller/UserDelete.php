<?php

namespace Poa\Controller;

class UserDelete extends \Poa\Controller {
  public function run() {
    $user = new \Poa\Model\User();
    $userData = $user->find($_SESSION['me']->id);
    $this->setValues('username', $userData->username);
    $this->setValues('email', $userData->email);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) == 'delete') {
      // バリデーション
      if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        echo "不正なトークンです!";
        exit;
      }

      $userModel = new \Poa\Model\User();
      $userModel->delete();

      $_SESSION = [];

      // クッキーにセッションで使用されているクッキーの名前がセットされていたら空にする
      if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 86400, '/');
      }

      // セッションの破棄
      // セッションのハイジャック対策
      session_destroy();
    }
  }
}