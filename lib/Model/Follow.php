<?php
namespace Poa\Model;
class Follow extends \Poa\Model {
  // お気に入り中の全スレッド取得
  public function myFollowAll(){
    $user_id = $_SESSION['me']->id;
    $stmt = $this->db->query("SELECT username,image FROM follows AS f INNER JOIN users AS u ON u.delflag = 0 AND u.id = follow_id AND user_id = $user_id ORDER BY u.id ASC");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
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
      if (!empty($rec)) {
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
}
