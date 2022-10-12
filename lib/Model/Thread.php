<?php
namespace Poa\Model;
class Thread extends \Poa\Model {
  public function createThread($values) {
    try {
      $this->db->beginTransaction();
      $sql = "INSERT INTO threads (user_id,title,body,thread_img,created,modified) VALUES (:user_id,:title,:body,:thread_img,now(),now())";
      $stmt = $this->db->prepare($sql);
      $stmt->bindValue('user_id',$values['user_id']);
      $stmt->bindValue('title',$values['title']);
      $stmt->bindValue('body',$values['body']);
      $stmt->bindValue('thread_img',$values['threadimg']);
      $res = $stmt->execute();
      $this->db->commit();
    } catch (\Exception $e) {
      echo $e->getMessage();
      $this->db->rollBack();
    }
  }

  //未ログイン時スレッド取得（トップ画面）
  public function notLoginThread() {
    $stmt = $this->db->query("SELECT * FROM threads WHERE delflag = 0 ORDER BY id desc");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  // 全スレッド取得
  public function getThreadAll() {
    $user_id = $_SESSION['me']->id;
    $stmt = $this->db->query("SELECT t.id AS t_id,thread_img,f.id AS f_id FROM threads AS t LEFT JOIN favorites AS f ON t.delflag = 0 AND t.id = f.thread_id AND f.user_id = $user_id ORDER BY t.id desc");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  // スレッド１件取得
  public function getThread($thread_id){
    $stmt = $this->db->prepare("SELECT threads.id,user_id,title,username,body,thread_img,threads.created FROM threads INNER JOIN users ON user_id = users.id WHERE threads.id = :id AND threads.delflag = 0");
    $stmt->bindValue(":id",$thread_id);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  //マイページスレッド取得
  public function myThread(){
    $user_id = $_SESSION['me']->id;
    $stmt = $this->db->query("SELECT id,thread_img FROM threads WHERE user_id = $user_id AND delflag = 0 ORDER BY id desc");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  // 編集スレッド取得
  public function findThread($thread_id){
    $stmt = $this->db->prepare("SELECT * FROM threads WHERE id = :id");
    $stmt->bindValue(":id",$thread_id);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  // スレッド内容編集
  public function updateThread($values) {
    $stmt = $this->db->prepare("UPDATE threads SET title = :title,body = :body, thread_img = :thread_img, modified = now() where id = :id");
    $stmt->execute([
      ':title' => $values['title'],
      ':body' => $values['body'],
      ':thread_img' => $values['threadimg'],
      ':id' => $values['id'],
    ]);
  }

  public function getThreadCsv($thread_id) {
    $stmt = $this->db->prepare("SELECT username,title,body,threads.created FROM threads INNER JOIN users ON threads.user_id = users.id WHERE threads.id =:thread_id AND threads.delflag = 0;");
    $stmt->execute([':thread_id' => $thread_id]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  /*
  public function getCommentCsv($thread_id) {
    $stmt = $this->db->prepare("SELECT comment_num,username,content,comments.created FROM (threads INNER JOIN comments on threads.id = comments.thread_id) INNER JOIN users ON comments.user_id = users.id WHERE threads.id =:thread_id AND comments.delflag = 0 ORDER BY comment_num ASC;");
    $stmt->execute([':thread_id' => $thread_id]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
  */

  // スレッド詳細お気に入り取得
  public function favThread($thread_id) {
    $user_id = $_SESSION['me']->id;
    $stmt = $this->db->query("SELECT t.id AS t_id,f.id AS f_id FROM threads AS t LEFT JOIN favorites AS f ON t.delflag = 0 AND t.id = f.thread_id AND f.user_id = $user_id");
    $stmt->bindValue(":id",$thread_id);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  // お気に入り中の全スレッド取得
  public function getThreadFavoriteAll(){
    $user_id = $_SESSION['me']->id;
    $stmt = $this->db->query("SELECT t.id AS t_id,thread_img,f.id AS f_id FROM threads AS t INNER JOIN favorites AS f ON t.delflag = 0 AND t.id = f.thread_id AND f.user_id = $user_id ORDER BY t.id desc");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  // スレッド名検索
  public function searchThread($keyword) {
    $user_id = $_SESSION['me']->id;
    $stmt = $this->db->prepare("SELECT t.id AS t_id,thread_img,f.id AS f_id FROM threads AS t LEFT JOIN favorites AS f ON t.delflag = 0 AND t.id = f.thread_id AND f.user_id = $user_id WHERE title LIKE :title ORDER BY t.id desc");
    $stmt->execute([':title' => '%'.$keyword.'%']);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }
}