<?php
namespace Poa\Controller;
class UserUpdate extends \Poa\Controller {
  public function run() {
    $this->showUser();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->updateUser();
    }
  }

  protected function showUser() {
    $user = new \Poa\Model\User();
    $userDate = $user->find($_SESSION['me']->id);
    $this->setValues('username', $userDate->username);
    $this->setValues('email', $userDate->email);
    $this->setValues('image', $userDate->image);
  }

  protected function updateUser() {
    try {
      $this->validate();
    } catch (\Poa\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\Poa\Exception\InvalidName $e) {
      $this->setErrors('username', $e->getMessage());
    }
    $this->setValues('username', $_POST['username']);
    $this->setValues('email', $_POST['email']);
    if ($this->hasError()) {
      return;
    } else {
      $user_img = $_FILES['image'];
      $old_img = $_POST['old_image'];
      $ext = substr($user_img['name'], strrpos($user_img['name'], '.') + 1);
      $user_img['name'] = uniqid("img_") .'.'. $ext;
      try{
        $userModel = new \Poa\Model\User();
        if($user_img['size'] > 0) {
          unlink('./gazou/'.$old_img);
          move_uploaded_file($user_img['tmp_name'],'./gazou/'.$user_img['name']);
          $userModel->update([
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'userimg' => $user_img['name']
          ]);
          $_SESSION['me']->image = $user_img['name'];
        } else {
          if ($old_img === '') {
            $old_img = null;
          }
          $userModel->update([
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'userimg' => $old_img
          ]);
          $_SESSION['me']->image = $old_img;
        }
      }
      catch (\Poa\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }
    }
    $_SESSION['me']->username = $_POST['username'];
    header('Location: '. SITE_URL . '/myinfo.php');
    exit();
  }

  private function validate() {
    $validate = new \Poa\Controller\Validate();
    $validate->tokenCheck($_POST['token']);
    $validate->unauthorizedCheck([$_POST['email'],$_POST['username']]);
    if ($validate->mailCheck($_POST['email'])) {
      throw new \Poa\Exception\InvalidEmail("メールアドレスの形式が不正です!");
    }
    if($validate->emptyCheck([$_POST['username']])) {
      throw new \Poa\Exception\InvalidName("ユーザー名が入力されていません!");
    }
  }
}