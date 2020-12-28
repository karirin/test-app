<nav class="navbar navbar-dark bg-dark">
<?php if(isset($_SESSION['login'])==false): ?>
    <ul>
    <li><a href="../user_login/user_top.php">app</a></li>
    <li><a href="../user_login/user_login.php">ログイン</a></li>
    <li><a href="../user/user_add.php">新規登録</a></li>
<?php 
    else:
    $current_user=get_user($_SESSION['user_id']);
    $message_count=current(message_count($current_user['id']));
    $last_message_count=current(last_message_count($current_user['id']));
    $current_message_count = $message_count - $last_message_count;
    _debug($message_count);
    _debug($last_message_count);
    update_message_count($message_count,$current_user['id']);
?>
    <ul>
    <li><a href="../user_login/user_top.php?type=main">coffeeapp</a></li>
    <li><a href="../user/user_list.php?type=all">ユーザー一覧</a></li>
    <li><a href="../post/post_index.php?type=all">投稿一覧</a></li>
    <li><a class="post_window" href="#">投稿</a></li>
    <!-- <li><a href="../message/message_top.php">メッセージ</a></li> -->
    <li><a href="../message/message_top.php">メッセージ<?= $current_message_count ?></a></li>
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