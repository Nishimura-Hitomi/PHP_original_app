<?php
namespace Poa\Controller;
// Controllerクラス継承
class Signup extends \Poa\Controller {
  public function run() {
    if ($this->isLoggedIn()) {
      header('Location: '. SITE_URL);
      exit();
    }
    // POSTメソッドがリクエストされていればpostProcessメソッド実行
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }
  protected function postProcess() {
    try {
      $this->validate();
    } catch (\Poa\Exception\InvalidEmail $e) {
        $this->setErrors('email', $e->getMessage());
    } catch (\Poa\Exception\EmptyPost $e) {
        $this->setErrors('username', $e->getMessage());
    } catch (\Poa\Exception\InvalidPassword $e) {
        $this->setErrors('password', $e->getMessage());
    }
    $this->setValues('email', $_POST['email']);
    $this->setValues('username', $_POST['username']);
    if ($this->hasError()) {
      return;
    } else {
      try {
        $userModel = new \Poa\Model\User();
        $user = $userModel->create([
          'email' => $_POST['email'],
          'username' => $_POST['username'],
          'password' => $_POST['password']
        ]);
      }
      catch (\Poa\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }

      $userModel = new \Poa\Model\User();
      $user = $userModel->login([
        'email' => $_POST['email'],
        'password' => $_POST['password']
      ]);
      session_regenerate_id(true);
      $_SESSION['me'] = $user;
      header('Location: '. SITE_URL . '/index.php');
      exit();
    }
  }

  // バリデーションメソッド
  private function validate() {
    $validate = new \Poa\Controller\Validate();
    $validate->tokenCheck($_POST['token']);
    $validate->unauthorizedCheck([$_POST['email'],$_POST['username'],$_POST['password']]);
    if ($validate->mailCheck($_POST['email'])) {
      throw new \Poa\Exception\InvalidEmail("メールアドレスの形式が不正です!");
    }
    if($validate->emptyCheck([$_POST['username']])) {
      throw new \Poa\Exception\EmptyPost("ユーザー名が入力されていません!");
    }
    if($validate->passwordCheck([$_POST['password']])) {
      throw new \Poa\Exception\InvalidPassword("パスワードは半角英数字で入力してください!");
    }
  }
}
