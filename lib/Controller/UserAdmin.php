<?php
namespace Poa\Controller;
class UserAdmin extends \Poa\Controller {
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

  public function adminShow() {
    $userModel = new \Poa\Model\User();
    $users = $userModel->adminShow();
    return $users;
  }

  private function postProcess() {
    if(isset($_POST['update'])) {
      try {
        $this->validate();
      } catch (\Poa\Exception\InvalidName $e) {
        $this->setErrors('username', $e->getMessage());
      }  catch (\Poa\Exception\InvalidEmail $e) {
        $this->setErrors('email', $e->getMessage());
      }
      $this->setValues('username', $_POST['username']);
      $this->setValues('email', $_POST['email']);
      if ($this->hasError()) {
        return;
      } else {
        $user_id = $_POST['id'];
        $user_img = $_FILES['image'];
        $old_img = $_POST['old_image'];
        $ext = substr($user_img['name'], strrpos($user_img['name'], '.') + 1);
        $user_img['name'] = uniqid("img_") .'.'. $ext;
        try{
          $userModel = new \Poa\Model\User();
          if($user_img['size'] > 0) {
            unlink('./gazou/'.$old_img);
            move_uploaded_file($user_img['tmp_name'],'./gazou/'.$user_img['name']);
            $userModel->adminUpdate([
              'id' => $user_id,
              'username' => $_POST['username'],
              'email' => $_POST['email'],
              'userimg' => $user_img['name'],
              'authority' => $_POST['authority'],
              'delflag' => $_POST['delflag']
            ]);
          } else {
            if ($old_img === '') {
              $old_img = null;
            }
            $userModel->adminUpdate([
              'id' => $user_id,
              'username' => $_POST['username'],
              'email' => $_POST['email'],
              'userimg' => $old_img,
              'authority' => $_POST['authority'],
              'delflag' => $_POST['delflag']
            ]);
          }
        }
        catch (\Poa\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
        }
      }
      header('Location: '. SITE_URL . '/admin_update_comp.php');
      exit();
    } elseif(isset($_POST['delete'])) {
      $userModel = new \Poa\Model\User();
      $userModel->adminDelete($_POST['id']);
      var_dump($_POST['id']);
      header('Location: '. SITE_URL . '/admin_delete_comp.php');
      exit();
    }
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