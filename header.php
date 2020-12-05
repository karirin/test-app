<nav class="navbar navbar-dark bg-dark">
<?php if(isset($_SESSION['login'])==false): ?>
    <ul>
    <li><a href="../user_login/user_top.php">coffeeapp</a></li>
    <li><a href="../user_login/user_login.php">ログイン</a></li>
    <li><a href="../user/user_add.php">新規登録</a></li>
<?php else: ?>
    <ul>
    <li><a href="../user_login/user_top.php?type=main">coffeeapp</a></li>
    <li><a href="../user/user_list.php?type=all">ユーザー一覧</a></li>
    <li><a href="../post/post_index.php">投稿一覧</a></li>
    <li><a class="post_window" href="#">投稿</a></li>
    <li><a href="../message/message_top.php">メッセージ</a></li>
    <li><a href="../user_login/user_logout.php">ログアウト</a></li>
    <li><a href="/withdraw.php">退会</a></li>
    </ul>
<?php endif; ?>
</nav>
<?php
if (isset($flash_messages)):
foreach ((array)$flash_messages as $message):
print'<p class ="flash_message">'.$message.'</p>';
endforeach;
endif;
?>