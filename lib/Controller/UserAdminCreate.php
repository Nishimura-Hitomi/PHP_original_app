<?php
namespace Poa\Controller;

class UserAdminCreate extends \Poa\Controller {
  public function run() {
    if($this->isAdminLoggedIn()) {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->postProcess();
      }
    } else {
      header('Location: '. SITE_URL . '/thread_all.php');
      exit();
    }
  }

  private function postProcess() {
    try {
      $this->validate();
    } catch (\Poa\Exception\InvalidEmail $e) {
        $this->setErrors('email', $e->getMessage());
    } catch (\Poa\Exception\InvalidName $e) {
        $this->setErrors('username', $e->getMessage());
    } catch (\Poa\Exception\InvalidPassword $e) {
        $this->setErrors('password', $e->getMessage());
    }
    $this->setValues('email', $_POST['email']);
    $this->setValues('username', $_POST['username']);
    if ($this->hasError()) {
      return;
    } else {
      $user_img = $_FILES['image'];
      $ext = substr($user_img['name'], strrpos($user_img['name'], '.') + 1);
      $user_img['name'] = uniqid("img_") .'.'. $ext;
      try {
        if($user_img['size'] > 0) {
          move_uploaded_file($user_img['tmp_name'],'./gazou/'.$user_img['name']);
          $userModel = new \Poa\Model\User();
          $user = $userModel->adminCreate([
            'email' => $_POST['email'],
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'userimg' => $user_img['name'],
            'authority' => $_POST['authority'],
            'delflag' => $_POST['delflag'],
          ]);
        } else {
          $img = null;
          $userModel = new \Poa\Model\User();
          $user = $userModel->adminCreate([
            'email' => $_POST['email'],
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'userimg' => $img,
            'authority' => $_POST['authority'],
            'delflag' => $_POST['delflag'],
          ]);
        }
      }
      catch (\Poa\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }

      header('Location: '. SITE_URL . '/admin_signup_comp.php');
      exit();
    }
  }

  private function validate() {
    $validate = new \Poa\Controller\Validate();
    $validate->tokenCheck($_POST['token']);
    $validate->unauthorizedCheck([$_POST['email'],$_POST['username'],$_POST['password']]);
    if ($validate->mailCheck($_POST['email'])) {
      throw new \Poa\Exception\InvalidEmail("メールアドレスの形式が不正です!");
    }
    if($validate->emptyCheck([$_POST['username']])) {
      throw new \Poa\Exception\InvalidName("ユーザー名が入力されていません!");
    }
    if($validate->passwordCheck([$_POST['password']])) {
      throw new \Poa\Exception\InvalidPassword("パスワードは半角英数字で入力してください!");
    }
  }
}
