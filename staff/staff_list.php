<?php
session_start();
session_regenerate_id(true);
?>
<?php require_once('../head.php'); ?>
<body>
<?php require_once('../function.php'); ?>
<?php
print 'スタッフ一覧<br/><br/>';

$users = get_users('all');


foreach((array)$users as $user): 

 print'<br />';
 print '<a href="../staff/staff_disp.php?staffcode='.$user['code'].'">'.$user['name'].'</a>'; 

endforeach
?>

<br />
<?php
print'<a href="../staff_login/staff_top.php?staff_code='.$_SESSION['staff_code'].'&type=main">トップメニューへ</a><br />';
?>
</body>
