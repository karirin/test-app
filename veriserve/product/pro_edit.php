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

try
{

$pro_code=$_GET['procode'];

$dsn='mysql:dbname=veri;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT name,price,gazou FROM veri_2 WHERE code=?';
$stmt=$dbh->prepare($sql);
$data[]=$pro_code;
$stmt->execute($data);

$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$pro_name=$rec['name'];
$pro_price=$rec['price'];
$pro_gazou_name_old=$rec['gazou'];

$dbh=null;

if($pro_gazou_name_old=='')
{
    $disp_gazou='';
}
else
{
    $disp_gazou='<img src="./gazou/'.$pro_gazou_name_old.'">';
}
}
catch(Exception $e)
{
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

配属社員修正<br /><br />
配属社員コード<br />
<?php print$pro_code;?>


<form method="post"action="pro_edit_check.php" enctype="multipart/form-data">
<input type="hidden"name="code"value="<?php print$pro_code;?>">
<input type="hidden"name="gazou_name_old"value="<?php print $pro_gazou_name_old; ?>">
配属社員名<br />
<input type="text"name="name"value="<?php print$pro_name;?>"><br />
社員単価を入力してください<br />
<input type="text"name="price"style="width:160px">
<br />
<br />
<?php print$disp_gazou;?>
<br />
画像を選んでください<br />
<input type="file"name="gazou"style="width:400px"><br />
<input type="button"onclick="history.back()"value="戻る">
<input type="submit" value="OK">

</form>

</body>
</html>