<?php
namespace Poa\Controller;
class Mypage extends \Poa\Controller {
  public function showUser() {
    $user = new \Poa\Model\User();
    $userDate = $user->find($_SESSION['me']->id);
    return $userDate;
  }

  public function showThread() {
    $thread = new \Poa\Model\Thread();
    $threadDate = $thread->myThread();
    return $threadDate;
  }

  public function showFollow() {
    $follow = new \Poa\Model\Follow();
    $followDate = $follow->myFollowAll();
    return $followDate;
  }
}