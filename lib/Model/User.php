<?php
namespace Poa\Model;
class User extends \Poa\Model {
  public function create($values) {
    $stmt = $this->db->prepare("INSERT INTO users (username,email,password,created,modified) VALUES (:username,:email,:password,now(),now())");
    $res = $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      // パスワードのハッシュ化
      ':password' => password_hash($values['password'],PASSWORD_DEFAULT)
    ]);
    // メールアドレスがユニークでなければfalseを返す
    if ($res === false) {
      throw new \Poa\Exception\DuplicateEmail();
    }
  }

  public function login($values) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email;");
    $stmt->execute([
      ':email' => $values['email']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    if (empty($user)) {
      throw new \Poa\Exception\UnmatchEmailOrPassword();
    }
    if (!password_verify($values['password'], $user->password)) {
      throw new \Poa\Exception\UnmatchEmailOrPassword();
    }
    if ($user->delflag == 1) {
      throw new \Poa\Exception\DeleteUser();
    }
    return $user;
  }

  public function find($id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id;");
    $stmt->bindValue('id',$id);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    return $user;
  }

  public function update($values) {
    $stmt = $this->db->prepare("UPDATE users SET username = :username,email = :email, image = :image, modified = now() where id = :id");
    $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      'image' => $values['userimg'],
      ':id' => $_SESSION['me']->id,
    ]);
    if ($res === false) {
      throw new \Poa\Exception\DuplicateEmail();
    }
  }

  // マイページ画像削除
  public function deleteImage() {
    $stmt = $this->db->prepare("UPDATE users SET image = :image, modified = now() where id = :id");
    $stmt->execute([
      ':image' => null,
      ':id' => $_SESSION['me']->id,
    ]);
  }

  public function delete() {
    $stmt = $this->db->prepare("UPDATE users SET delflag = :delflag,modified = now() where id = :id");
    $stmt->execute([
      ':delflag' => 1,
      ':id' => $_SESSION['me']->id,
    ]);
  }

  //ユーザーをフォローしているかチェック
  public function checkFollow($follow_user) {
    $stmt = $this->db->prepare("SELECT follow_id,user_id FROM follows WHERE follow_id = :follow_id AND user_id = :user_id");
    $stmt->execute([
      ':follow_id' => $follow_user,
      ':user_id' => $_SESSION['me']->id,
    ]);
    $user = $stmt->fetch();
    return $user;
  }

  //ユーザーフォロー登録・解除
  public function changeFollow($values) {
    try {
      $this->db->beginTransaction();
      // レコード取得
      $stmt = $this->db->prepare("SELECT follow_id,user_id FROM follows WHERE follow_id = :follow_id AND user_id = :user_id");
      $stmt->execute([
        ':follow_id' => $values['follow_id'],
        ':user_id' => $values['user_id']
      ]);
      // fetchMode データを扱いやすい形に変換
      $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
      $rec = $stmt->fetch();
      if (empty($rec)) {
        $sql = "DELETE FROM follows WHERE follow_id = :follow_id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $res = $stmt->execute([
          ':follow_id' => $values['follow_id'],
          ':user_id' => $values['user_id']
        ]);
      } else {
        $sql = "INSERT INTO follows (follow_id,user_id,created) VALUES (:follow_id,:user_id,now())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
          ':follow_id' => $values['follow_id'],
          ':user_id' => $values['user_id']
        ]);
      }
      $this->db->commit();
    } catch (\Exception $e) {
      echo $e->getMessage();
      // エラーがあったら元に戻す
      $this->db->rollBack();
    }
  }

  // アドミン画面ユーザー一覧
  public function adminShow() {
    $stmt = $this->db->query("SELECT * FROM users");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function adminCreate($values) {
    $stmt = $this->db->prepare("INSERT INTO users (username,email,password,image,authority,delflag,created,modified) VALUES (:username,:email,:password,:image,:authority,:delflag,now(),now())");
    $res = $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      ':password' => password_hash($values['password'],PASSWORD_DEFAULT),
      ':image' => $values['userimg'],
      ':authority' => $values['authority'],
      ':delflag' => $values['delflag'],
    ]);
    if ($res === false) {
      throw new \Poa\Exception\DuplicateEmail();
    }
  }

  public function adminUpdate($values) {
    $stmt = $this->db->prepare("UPDATE users SET username = :username, email = :email, image = :image,authority = :authority, delflag = :delflag, modified = now() WHERE id = :id");
    $stmt->execute([
      ':id' => $values['id'],
      ':username' => $values['username'],
      ':email' => $values['email'],
      'image' => $values['userimg'],
      'authority' => $values['authority'],
      'delflag' => $values['delflag'],
    ]);
  }

  public function adminDelete($user_id) {
    $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute([":id" => $user_id]);
  }
}
