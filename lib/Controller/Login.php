<?php
namespace Poa\Controller;
class Login extends \Poa\Controller {
  public function run() {
    // ログインしていればトップページへ移動
    if ($this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }
  protected function postProcess() {
    try {
      $this->validate();
    } catch (\Poa\Exception\EmptyPost $e) {
        $this->setErrors('login', $e->getMessage());
    }
    $this->setValues('email', $_POST['email']);
    if ($this->hasError()) {
      return;
    } else {
      try {
        $userModel = new \Poa\Model\User();
        $user = $userModel->login([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      }
      catch (\Poa\Exception\UnmatchEmailOrPassword $e) {
        $this->setErrors('login', $e->getMessage());
        return;
      }
      catch (\Poa\Exception\DeleteUser $e) {
        $this->setErrors('login', $e->getMessage());
        return;
      }
      // ログイン処理
      // session_regenerate_id関数･･･現在のセッションIDを新しいものと置き換える。 セッションハイジャック対策
      session_regenerate_id(true);
      // ユーザー情報をセッションに格納
      $_SESSION['me'] = $user;
      // スレッド一覧ページへリダイレクト
      header('Location: '. SITE_URL . '/index.php');
      exit();
    }
  }
  private function validate() {
    $validate = new \Poa\Controller\Validate();
    // トークンが空またはPOST送信とセッションに格納された値が異なるとエラー
    $validate->tokenCheck($_POST['token']);
    // emailとpasswordのキーがなかった場合、強制終了
    $validate->unauthorizedCheck([$_POST['email'],$_POST['password']]);
    if($validate->emptyCheck([$_POST['email'],$_POST['password']])) {
      throw new \Poa\Exception\EmptyPost("メールアドレスまたはパスワードを入力してください。");
    }
  }
}