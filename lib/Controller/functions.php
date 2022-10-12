<?php
// HTML特殊文字をエスケープする関数→XSS(クロスサイトスクリプティング)対策
// htmlspecialchars関数が長いのでユーザー定義関数で短くしている
function h($s){
  return htmlspecialchars($s, ENT_QUOTES,'UTF-8');
}

// ログインしないと表示できないページにアクセスした場合、ログインページにリダイレクトさせる
function urlFilter() {
  $current_uri =  $_SERVER["REQUEST_URI"];
  $file_name = basename($current_uri);
  if(strpos($file_name,'login.php') !== false || strpos($file_name,'signup.php') !== false || strpos($file_name,'index.php') !== false || strpos($file_name,'public_html') !== false) {
    // URL内のファイル名がlogin.php、signup.php、index.php(public_html)のとき
  }
  else {
    // それ以外の時
    if(!isset($_SESSION['me'])){
      header('Location: ' . SITE_URL . '/login.php');
      exit();
    }
  }
}
