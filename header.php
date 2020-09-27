<?php
print'<nav class="navbar navbar-dark bg-dark"> ';

if(isset($_SESSION['login'])==false)
{
    print'<ul>';
    print'<li><a href="../user_login/user_top.php">coffeeapp</a></li>';
    print'<li><a href="../user_login/user_login.php">ログイン</a></li>';
    print'<li><a href="../user/user_add.php">新規登録</a></li>';
}
else
{
    print'<ul>';
    print'<li><a href="../user_login/user_top.php?user_id='.$_SESSION['user_id'].'&type=main">coffeeapp</a></li>';
    print'<li><a href="../user/user_list.php?type=all">ユーザー一覧</a></li>';
    print'<li><a href="../post/post_index.php">投稿一覧</a></li>';
    print'<li><a href="../post/post_add.php">投稿</a></li>';
    print'<li><a href="../user_login/user_logout.php">ログアウト</a></li>';
    print'<li><a href="/withdraw.php">退会</a></li>';
    print'</ul>';
    if(basename($_SERVER['PHP_SELF']) === 'user_top.php')
    {
      print'</nav>';
      print'<nav class="navbar navbar-light mb-2"> ';
      print'<a href="user_top.php?user_id='.$_SESSION['user_id'].'&type=main">自分の投稿</a>';
      print'<a href="user_top.php?user_id='.$_SESSION['user_id'].'&type=favorites">いいねした投稿</a>';
      print'</nav>';
    }

}

print'</nav>';
?>