<?php
namespace Poa\Controller;
class ImageDelete extends \Poa\Controller {
  public function run() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user_img = $_FILES['image'];
      $old_img = $_POST['old_image'];
      unlink('./gazou/'.$old_img);

      $userModel = new \Poa\Model\User();
      $userModel->deleteImage();

      $_SESSION['me']->image = null;

      header('Location: '. SITE_URL . '/myinfo.php');
      exit();
    }
  }
}