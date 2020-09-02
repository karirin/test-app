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

<?php

try
{

$pro_code=$_POST['code'];
$pro_name=$_POST['name'];
$pro_gazou_name_old=$_POST['gazou_name_old'];
$pro_gazou_name=$_POST['gazou_name'];


$pro_code=htmlspecialchars($pro_code,ENT_QUOTES,'UTF-8');
$pro_name=htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');

$dsn='mysql:dbname=veri;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='UPDATE veri_2 SET name=?,price=?,gazou=? WHERE code=? ';
$stmt=$dbh->prepare($sql);
$data[]=$pro_name;
$data[]=$pro_code;
$data[]=$gazou_name;
$stmt->execute($data);

$dbh=null;

}
catch(Exception $e)
{
    print'ただいま障害により大変迷惑をお掛けしております。';
    exit();
}

if($pro_gazou_name_old!=$pro_gazou_name)
{
    if($pro_gazou_name_old!='')
    {
        unlink('./gazou/'.$pro_gazou_name_old);
    }
}

print'修正しました<br />';
<br />

?>

<a href="pro_list.php"> 戻る</a>

</body>
</html>