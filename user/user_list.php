<?php
session_start();
session_regenerate_id(true);
?>
<?php require_once('../head.php'); ?>
<body>
<?php require_once('../function.php'); ?>
<?php
print 'ユーザー一覧<br/><br/>';

$users = get_users('all');


foreach((array)$users as $user): 

 print'<br />';
 print '<a href="../user/user_disp.php?user_id='.$user['id'].'">'.$user['name'].'</a>'; 

endforeach
?>

<br />
<?php
print'<a href="../user_login/user_top.php?user_id='.$_SESSION['user_id'].'&type=main">トップメニューへ</a><br />';
?>
</body>
