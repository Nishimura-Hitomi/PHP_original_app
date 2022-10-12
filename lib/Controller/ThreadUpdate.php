<?php
namespace Poa\Controller;
class ThreadUpdate extends \Poa\Controller {
  public function run() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->updateThread();
    }
  }

  public function showThread($thread_id) {
    $thread = new \Poa\Model\Thread();
    $threadDate = $thread->findThread($thread_id);
    $this->setValues('title', $threadDate->title);
    $this->setValues('body', $threadDate->body);
    $this->setValues('image', $threadDate->thread_img);
  }

  private function updateThread() {
    try {
      $this->validate();
    } catch (\Poa\Exception\EmptyPost $e) {
      $this->setErrors('title', $e->getMessage());
    } catch (\Poa\Exception\CharLength $e) {
      $this->setErrors('body', $e->getMessage());
    }
    $this->setValues('title', $_POST['title']);
    $this->setValues('body', $_POST['body']);
    if ($this->hasError()){
      return;
    } else {
      $thread_img = $_FILES['image'];
      $old_img = $_POST['old_image'];
      $ext = substr($thread_img['name'], strrpos($thread_img['name'], '.') + 1);
      $thread_img['name'] = uniqid("img_") .'.'. $ext;
      try{
        $threadModel = new \Poa\Model\Thread();
        if($thread_img['size'] > 0) {
          unlink('./gazou/'.$old_img);
          move_uploaded_file($thread_img['tmp_name'],'./gazou/'.$thread_img['name']);
          $threadModel->updateThread([
            'title' => $_POST['title'],
            'body' => $_POST['body'],
            'threadimg' => $thread_img['name'],
            'id' => $_POST['thread_id'],
          ]);
        } else {
          if ($old_img === '') {
            $old_img = null;
          }
          $threadModel->updateThread([
            'title' => $_POST['title'],
            'body' => $_POST['body'],
            'threadimg' => $old_img,
            'id' => $_POST['thread_id'],
          ]);
        }
      }
      catch (\Exception $e) {
      echo $e->getMessage();
      }
      header('Location: ' . SITE_URL .'/mypage.php');
      exit();
    }
  }

  private function validate() {
    $validate = new \Poa\Controller\Validate();
    $validate->tokenCheck($_POST['token']);
    $validate->unauthorizedCheck([$_POST['title'],$_POST['body']]);
    if($validate->emptyCheck([$_POST['title'],$_POST['body']])) {
      throw new \Poa\Exception\EmptyPost("タイトルまたはコメントが入力されていません！");
    }
    if($validate->charLenghtCheck($_POST['title'],20)) {
      throw new \Poa\Exception\CharLength("タイトルは20文字以内で入力してください。");
    }
    if($validate->charLenghtCheck($_POST['body'],200)) {
      throw new \Poa\Exception\CharLength("コメントは200文字以内で入力してください。");
    }
  }
}
