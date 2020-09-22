<?php
require_once('../function.php');
try
{

$staff_code=$_POST['code'];
$staff_pass=$_POST['pass'];

$staff_code=htmlspecialchars($staff_code,ENT_QUOTES,'UTF-8');
$staff_pass=htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');

if(empty($staff_code)){
	$error_messages['code'] = "コードを入力してください";
  }
//　コードのバリデーション

if(empty($staff_pass)) {
	$error_messages['pass'] = "パスワードを入力してください";
  }
// パスワードのバリデーション

$staff_pass=md5($staff_pass);
//md5でハッシュ化すると空でもemptyにならないので注意

$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password); //データベースに接続
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//PDO::ATTR_ERRMODEという属性でPDO::ERRMODE_EXCEPTIONの値を設定することによりエラーが発生した際にPDOExceptionの例外を投げてくれる。

$sql='SELECT name FROM mst_staff WHERE code=? AND password=?';
$stmt=$dbh->prepare($sql);
//$sqlのSQL文で『?』部分をどう置き換えるかを示している

$data[]=$staff_code;
$data[]=$staff_pass;
$stmt->execute($data);
//prepareで準備したものexecuteで実行

$dbh=null; //??
$rec=$stmt->fetch(PDO::FETCH_ASSOC);
//fetchメソッドは引数にデータの取り出し方のオプションを決める

if($rec==false)
{
	$error_messages[] = '';
}
else
{
	$_SESSION['login']=1;//??
	$_SESSION['staff_code']=$staff_code;
	$_SESSION['staff_name']=$rec['name'];
	set_flash('sucsess','ログインしました');
	header('Location:staff_top.php?staff_code='.$staff_code.'&type=main');
	//headerとは指定のパスへ飛ぶ命令ができる
	exit();
 }

}
catch(Exception $e)
{
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

set_flash('error',$error_messages);

?>