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
<title> VERISERVE</title>
</head>
<body>

ベリサーブ社員配属<br />
<br />
<form method="post" action="pro_add_check.php"enctype="multipart/form-data">
社員名を入力してください。<br />
<input type="text" name="name" style="width:200px"><br />
社員の単価を入力してください。<br />
<input type="text" name="price" style="width:200px"><br />
画像を選んでください<br />
<input type="file" name="gazou" style="width:200px"><br />

<br />
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="ＯＫ">
</form>

</body>
</html>