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
    print'<li><a href="../user_login/user_top.php?type=main">coffeeapp</a></li>';
    print'<li><a href="../user/user_list.php?type=all">ユーザー一覧</a></li>';
    print'<li><a href="../post/post_index.php">投稿一覧</a></li>';
    print'<li><a class="post_window" href="#">投稿</a></li>';
    print'<li><a href="../message/message.php">メッセージ</a></li>';
    print'<li><a href="../user_login/user_logout.php">ログアウト</a></li>';
    print'<li><a href="/withdraw.php">退会</a></li>';
    print'</ul>';
}

print'</nav>';

if (isset($flash_messages)):
foreach ((array)$flash_messages as $message):
print'<p class ="flash_message">'.$message.'</p>';
endforeach;
endif;
?>