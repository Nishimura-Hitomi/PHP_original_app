<?php
namespace Poa\Controller;

class ThreadCreate extends \Poa\Controller {

  public function run() {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      if ($_POST['type']  === 'createthread') {
        $this->createThread();
      }
    }
  }

  private function createThread() {
    try {
      $this->validate();
    } catch (\Poa\Exception\EmptyPost $e) {
      $this->setErrors('create_thread', $e->getMessage());
    } catch (\Poa\Exception\CharLength $e) {
      $this->setErrors('create_thread', $e->getMessage());
    }
    $this->setValues('thread_name', $_POST['thread_name']);
    $this->setValues('body', $_POST['body']);
    if ($this->hasError()){
      return;
    } else {
      $thread_img = $_FILES['image'];
      $ext = substr($thread_img['name'], strrpos($thread_img['name'], '.') + 1);
      $thread_img['name'] = uniqid("img_") .'.'. $ext;
      $threadModel = new \Poa\Model\Thread();
      if($thread_img['size'] > 0) {
        move_uploaded_file($thread_img['tmp_name'],'./gazou/'.$thread_img['name']);
        $threadModel->createThread([
        'title' => $_POST['thread_name'],
        'body' => $_POST['body'],
        'threadimg' => $thread_img['name'],
        'user_id' => $_SESSION['me']->id
        ]);
    }
    header('Location: ' . SITE_URL .'/thread_all.php');
    exit();
    }
  }

  private function validate() {
    $validate = new \Poa\Controller\Validate();
    $validate->tokenCheck($_POST['token']);
    $validate->unauthorizedCheck([$_POST['thread_name'],$_POST['body']]);
    if($validate->emptyCheck([$_POST['thread_name'],$_POST['body']])) {
      throw new \Poa\Exception\EmptyPost("タイトルまたはコメントが入力されていません！");
    }
    if($validate->charLenghtCheck($_POST['thread_name'],20)) {
      throw new \Poa\Exception\CharLength("タイトルは20文字以内で入力してください。");
    }
    if($validate->charLenghtCheck($_POST['body'],200)) {
      throw new \Poa\Exception\CharLength("コメントは200文字以内で入力してください。");
    }
    if ($_FILES['image']['name'] === '') {
      throw new \Poa\Exception\EmptyPost("画像が未選択です！");
    }
  }
}