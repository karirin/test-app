<?php
session_start();
session_regenerate_id(true);

if (isset($_SESSION['id'])) {
    $current_user = get_user($_SESSION['id']);
  }else{
    $current_user = 'guest';
  }

print'<nav class="navbar navbar-dark bg-dark"> ';

if(isset($_SESSION['login'])==false)
{
    print'<a href="../user_login/user_login.php">ログイン</a>';
    print'<a href="../user/user_add.php">新規登録</a>';
}
else
{
    print'<a href="../user/user_list.php?type=all">ユーザー一覧</a>';
    print'<a href="../post/post_list.php">投稿一覧</a>';
    print'<a href="../post/post_add.php">投稿</a>';
    print'<a href="../user_login/user_logout.php">ログアウト</a>';
    print'<a href="/withdraw.php">退会</a>';
    if(basename($_SERVER['PHP_SELF']) === 'user_top.php')
    {
      print'</nav>';
      print'<nav class="navbar navbar-light mb-2"> ';
      print'<a href="user_top.php?user_id='.$_SESSION['user_id'].'&type=main">自分の投稿</a>';
      print'<a href="user_top.php?user_id='.$_SESSION['user_id'].'&type=favorites">いいねした投稿</a>';
    }
}

print'</nav>';
?>