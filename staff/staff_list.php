<?php
session_start();
session_regenerate_id(true);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> ろくまる農園</title>
</head>
<body>

<?php
var_dump($_SESSION['staff_code']);
try
{

$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT code,name FROM mst_staff WHERE 1';
$stmt=$dbh->prepare($sql);
$stmt->execute();

$dbh=null;

print 'スタッフ一覧<br/><br/>';

print '<form method="post" action="staff_branch.php">';
while(true)
{
	$rec=$stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false)
	{
		break;
	}
	print '<a href="../staff/staff_disp.php?staffcode='.$rec['code'].'"> '.$rec['name'].' </a><br />';
	print '<br />';


}
print '</form>';

}
catch (Exception $e)
{
	 print 'ただいま障害により大変ご迷惑をお掛けしております。';
	 exit();
}

?>

<br />
<?php
print'<a href="../staff_login/staff_top.php?staff_code='.$_SESSION['staff_code'].'&type=main">トップメニューへ</a><br />';
?>
</body>
</html>