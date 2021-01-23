<nav class="navbar navbar-dark bg-dark">
<?php if(isset($_SESSION['login'])==false): ?>
    <ul>
    <li><a href="../user_login/user_top.php">app</a></li>
    <li><a href="../user_login/user_login.php">ログイン</a></li>
    <li><a href="../user/user_add.php">新規登録</a></li>
<?php 
    else:
?>
    <ul>
    <li><a href="../user_login/user_top.php?type=main&page_id=current_user">coffeeapp</a></li>
    <li><a href="../user/user_list.php?type=all">ユーザー一覧</a></li>
    <li><a href="../post/post_index.php?type=all">投稿一覧</a></li>
    <li><a href="../message/message_top.php">メッセージ</a></li>
    <li><a href="../user_login/user_logout.php">ログアウト</a></li>
    <li><a href="/withdraw.php">退会</a></li>
    </ul>
<?php
    endif;
?>
</nav>
<p class="flash">
<?php
if (isset($flash_messages)):
foreach ((array)$flash_messages as $message):
print'<span class="flash_message">'.$message.'</span>';
endforeach;
endif;
?>
</p>