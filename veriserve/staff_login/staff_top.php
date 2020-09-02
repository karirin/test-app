<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false)
{
    print'ログインされていません</ br>';
    print'<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
}
else
{
    print$_SESSION['staff_name'];
    print'さんログイン中<br />';
    print'<br />';
}

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>VERISERVE</title>
</head>
<body>

トップメニュー<br />
<br />
<a href="../staff/staff_list.php">社員管理</a><br />
<br />
<a href="staff_logout.php">ログアウト</a><br />

<br />
<a href="../product/pro_list.php">配属社員管理</a><br />

</body>
</html>