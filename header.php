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
    print'<li><a href="../user_login/user_top.php?user_id='.$_SESSION['user_id'].'&type=all">coffeeapp</a></li>';
    print'<li><a href="../user/user_list.php?type=all">ユーザー一覧</a></li>';
    print'<li><a href="../post/post_index.php">投稿一覧</a></li>';
    print'<li><a href="../post/post_add.php">投稿</a></li>';
    print'<li><a href="../user_login/user_logout.php">ログアウト</a></li>';
    print'<li><a href="/withdraw.php">退会</a></li>';
    print'</ul>';
}

print'</nav>';
?>