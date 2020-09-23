<?php
require_once('../function.php');
try
{

$user_id=$_POST['id'];
$user_pass=$_POST['pass'];

$user_id=htmlspecialchars($user_id,ENT_QUOTES,'UTF-8');
$user_pass=htmlspecialchars($user_pass,ENT_QUOTES,'UTF-8');

if(empty($user_id)){
	$error_messages['id'] = "コードを入力してください";
  }
//　コードのバリデーション

if(empty($user_pass)) {
	$error_messages['pass'] = "パスワードを入力してください";
  }
// パスワードのバリデーション

$user_pass=md5($user_pass);
//md5でハッシュ化すると空でもemptyにならないので注意

$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password); //データベースに接続
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//PDO::ATTR_ERRMODEという属性でPDO::ERRMODE_EXCEPTIONの値を設定することによりエラーが発生した際にPDOExceptionの例外を投げてくれる。

$sql='SELECT name,delete_flg,id FROM user WHERE id=? AND password=?';
$stmt=$dbh->prepare($sql);
//$sqlのSQL文で『?』部分をどう置き換えるかを示している

$data[]=$user_id;
$data[]=$user_pass;
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
if($rec['delete_flg']){
	change_delete_flg($rec['id'],0);
	set_flash('sucsess','登録されていたユーザーを復元しました');
}
{
	$_SESSION['login']=1;//??
	$_SESSION['user_id']=$user_id;
	$_SESSION['user_name']=$rec['name'];
	set_flash('sucsess','ログインしました');
	header('Location:user_top.php?user_id='.$rec['id'].'&type=main');
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