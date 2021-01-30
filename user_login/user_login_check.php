<?php
require_once('../function.php');
try
{
$user_name=$_POST['name'];
$user_pass=$_POST['pass'];
$user_pass2=$_POST['pass'];

$user_name=htmlspecialchars($user_name,ENT_QUOTES,'UTF-8');
$user_pass=htmlspecialchars($user_pass,ENT_QUOTES,'UTF-8');
$user_pass2=htmlspecialchars($user_pass2,ENT_QUOTES,'UTF-8');

$user_pass2=md5($user_pass2);

$date = new DateTime();
$date->setTimeZone(new DateTimeZone('Asia/Tokyo'));

$dsn='mysql:dbname=db;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT name,delete_flg,id FROM user WHERE name=? AND password=?';
$stmt=$dbh->prepare($sql);

$data[]=$user_name;
$data[]=$user_pass2;
$stmt->execute($data);
$dbh=null;
$rec=$stmt->fetch(PDO::FETCH_ASSOC);

if($rec==false)
{
	if(empty($user_name)&&empty($user_pass)){
		$error_messages[] = "ユーザー名とパスワードを入力してください";
	  }else if(empty($user_name)){
		$error_messages[] = "ユーザー名を入力してください";
	}else if(empty($user_pass)){
		$error_messages[] = "パスワードを入力してください";		
	}else{
		$error_messages[] = "ユーザー名とパスワードが違います";	
	}
	header('Location:user_login.php');
}
else {
if($rec['delete_flg']){
	change_delete_flg($rec['id'],0);
	set_flash('sucsess','登録されていたユーザーを復元しました');
}
{
	if(isset($rec['image'])){
		$_SESSION['user_image']=$rec['image'];
	}
	update_login_time($date,$rec['id']);
	$_SESSION['login']=1;
	$_SESSION['user_id']=$rec['id'];
	$_SESSION['user_name']=$rec['name'];
	if(current(message_count($_SESSION['user_id']))!=0){
	set_flash('sucsess','ログインしました		メッセージが'.current(message_count($_SESSION['user_id'])).'件届いています');
	}else{
	set_flash('sucsess','ログインしました');
	}
	header('Location:user_top.php?page_id='.$rec['id'].'&type=main');
	exit();
 }
}
}
catch(Exception $e)
{
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

set_flash('error',$error_messages);

?>