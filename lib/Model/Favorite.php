<?php
namespace Poa\Model;
class Favorite extends \Poa\Model {
  public function changeFavorite($values) {
    try {
      $this->db->beginTransaction();
      // レコード取得
      $stmt = $this->db->prepare("SELECT * FROM favorites WHERE thread_id = :thread_id AND user_id = :user_id");
      $stmt->execute([
        ':thread_id' => $values['thread_id'],
        ':user_id' => $values['user_id']
      ]);
      // fetchMode データを扱いやすい形に変換
      $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
      $rec = $stmt->fetch();
      $fav_flag = 0;
      if (empty($rec)) {
        $sql = "INSERT INTO favorites (thread_id,user_id,created) VALUES (:thread_id,:user_id,now())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
          ':thread_id' => $values['thread_id'],
          ':user_id' => $values['user_id']
        ]);
        $fav_flag = 1;
      } else {
        $sql = "DELETE FROM favorites WHERE thread_id = :thread_id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $res = $stmt->execute([
          ':thread_id' => $values['thread_id'],
          ':user_id' => $values['user_id']
        ]);
        $fav_flag = 0;
      }
      $this->db->commit();
      return $fav_flag;
    } catch (\Exception $e) {
      echo $e->getMessage();
      // エラーがあったら元に戻す
      $this->db->rollBack();
    }
  }
}