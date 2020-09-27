<?php 
require_once('../config.php'); 
require_once('../header.php'); 
?>

<?php require_once('../head.php'); ?>
<body>

<?php

try
{

$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT id,name,address,time_start,time_end,gazou FROM post WHERE 1';
$stmt=$dbh->prepare($sql);
$stmt->execute();

$dbh=null;

print '<br />投稿一覧<br/><br/>';

while(true)
{
	$rec=$stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false)
	{
		break;
	}
	print '<a href="../post/post_disp.php?post_id='.$rec['id'].'&page_id='.$_SESSION['user_id'].'"> '.$rec['name'].' </a><br />';
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
print'<a href="../user_login/user_top.php?user_id='.$_SESSION['user_id'].'&type=main">トップメニューへ</a><br />';
?>

</body>
</html>