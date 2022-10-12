<?php
require_once(__DIR__ .'/header.php');
$threadCon = new Poa\Controller\CommentCreate();
$threadCon->run();
$thread_id = $_GET['thread_id'];
$threadMod = new Poa\Model\Thread();
$thread = $threadMod->favThread($thread_id);
$threadDisp = $threadMod->getThread($thread_id);
?>
<h1 class="page__ttl">投稿詳細</h1>
<div class="thread">
  <div class="thread_img" data-threadid="<?= $thread->t_id; ?>">
    <div class="fav__btn<?php if(isset($thread->f_id)) { echo ' active';} ?>">
      <i class="fas fa-heart"></i>
    </div>
    <img src="<?= './gazou/'.  h($threadDisp->thread_img); ?>" alt="">
  </div>
  <div class="thread__head">
    <div class="thread__ttl">
      <div class="thread_name">
        <p style="margin-top:3px; margin-bottom:0"><?= h($threadDisp->username); ?></P>
        <?php
        $me = $_SESSION['me']->id;
        $thread_user = $threadDisp->user_id;
        $followMod = new Poa\Model\Follow();
        $follow = $followMod->checkFollow($thread_user);
        if(!($me === $thread_user)):
        ?>
        <form action="" method="post" style="margin-left: 20px;">
          <input type="hidden" class="follow_id" data-followid="<?= $thread_user ?>">
          <?php if ($follow): ?>
          <button class="btn btn-thread following follow_btn" type="button" name="follow">フォロー中</button>
          <?php else: ?>
          <button class="btn btn-thread btn-primary follow_btn" type="button" name="follow">フォロー</button>
          <?php endif; ?>
        </form>
        <?php else: ?><?php endif; ?>
      </div>
    </div>
    <form id="csvoutput" method="post" action="thread_csv.php">
      <button class="btn btn-thread btn-primary" onclick="document.getElementById('csvoutput').submit();">CSV出力</button>
      <input type="hidden" name="thread_id" value="<?= h($thread_id); ?>">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <input type="hidden" name="type" value="outputcsv">
    </form>
  </div>
  <ul class="thread_ttl">
    <li class="user_ttl"><?= h($threadDisp->title); ?></li>
    <li class="user_comment"><?= h($threadDisp->body); ?></li>
    <li class="user_comment_date">投稿日時：<?= h($threadDisp->created); ?></li>
  </ul>
  <label>コメント</label>
  <ul class="thread__body">
  <?php
    $commentMod = new Poa\Model\Comment();
    $comments = $commentMod->getCommentAll($threadDisp->id);
    foreach($comments as $comment):
  ?>
    <li class="comment__item">
      <div class="comment__item__head">
        <span class="comment__item__num"><?= h($comment->comment_num); ?></span>
        <span class="comment__item__name">名前：<?= h($comment->username); ?></span>
        <span class="comment__item__date">投稿日時：<?= h($comment->created); ?></span>
      </div>
      <p class="comment__item__content"><?= h($comment->content); ?></p>
  <?php endforeach; ?>
    </li>
  </ul>
  <form action="" method="post" class="form-group">
    <div class="form-btn">
      <div class="form-group">
        <textarea type="text" name="content" class="form-control" placeholder="コメントする"><?= isset($threadCon->getValues()->content) ? h($threadCon->getValues()->content) : ''; ?></textarea>
        <p class="err"><?= h($threadCon->getErrors('comment')); ?></p>
      </div>
      <div class="form-group">
        <input type="submit" value="書き込み" class="btn btn-primary">
      </div>
      <input type="hidden" name="thread_id" value="<?= h($thread_id); ?>">
      <input type="hidden" name="type" value="createcomment">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </div>
  </form>
</div>
<script src="./js/follow.js"></script>
<?php
require_once(__DIR__ .'/menu.php');
?>
<?php
require_once(__DIR__ .'/footer.php');
?>