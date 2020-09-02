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

<?php 

try{

$staff_code=$_GET['staffcode'];

$dsn='mysql:dbname=veri;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT name FROM veri_1 WHERE code=?';
$stmt=$dbh->prepare($sql);
$data[]=$staff_code;
$stmt->execute($data);

$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$staff_name=$rec['name'];

$dbh=null;

}
catch(Exception $e)
{
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

社員修正<br /><br />
社員コード<br />
<?php print$staff_code;?>


<form method="post"action="staff_edit_check.php">
<input type="hidden"name="code"value="<?php print$staff_code;?>">
社員名<br />
<input type="test"name="name"value="<?php print$staff_name;?>"><br />
パスワードを入力してください<br />
<input type="password"name="pass"style="width:160px">
<br />
パスワードを再度入力してください。<br />
<input type="password"name="pass2"style="width:160px"><br /><br />
<input type="button"onclick="history.back()"value="戻る">
<input type="submit" value="OK">

</form>

</body>
</html>