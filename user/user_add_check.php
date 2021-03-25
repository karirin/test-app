<body>

<?php
session_start();
@session_regenerate_id(true);

require('../db_connect.php');
require('../function.php');
require('../head.php');

if(isset($_SESSION['flash'])){
  $flash_messages = $_SESSION['flash']['message'];
  $flash_type = $_SESSION['flash']['type'];
  }
unset($_SESSION['flash']);

$error_messages = array();

require('../header.php');

$user_name=$_POST['name'];
$user_pass=$_POST['pass'];
$user_pass2=$_POST['pass2'];
$user_image=$_FILES['image'];

$user_name=htmlspecialchars($user_name,ENT_QUOTES,'UTF-8');
$user_pass=htmlspecialchars($user_pass,ENT_QUOTES,'UTF-8');
$user_pass2=htmlspecialchars($user_pass2,ENT_QUOTES,'UTF-8');

if(empty($user_name)&&empty($user_pass)&&empty($user_pass2)){
    _debug('testaaa');
    $error_messages[] = "ユーザー名とパスワードを入力してください";
}else if(empty($user_name)){
    _debug('test1');
    $error_messages[] = "ユーザー名を入力してください";
}else if(check_user($user_name)){
    _debug('test2');
    $error_messages[] = 'このユーザー名は既に使用されています';
}else if(empty($user_pass)){
    _debug('test3');
    $error_messages[] = "パスワードを入力してください";		
}else if($user_pass!=$user_pass2){
    _debug('test4');
    $error_messages[] = 'パスワードが一致しません';
}
set_flash('error',$error_messages);

if(!empty($error_messages)){
    header("Location:/user/user_add.php");
}

if($user_image['size']>0)
{
	if($user_image['size']>1000000)
	{
		$error_messages[] = '画像が大き過ぎます';
	}
	else
	{
		move_uploaded_file($user_image['tmp_name'],'./image/'.$user_image['name']);
	}
}

$user_pass=md5($user_pass);

set_flash('error',$error_messages);
?>

<form method="post" action="#">
<input type="hidden" name="name" value="<?= $user_name ?>">
<input type="hidden" name="pass" value="<?= $user_pass ?>">
<input type="hidden" name="image_name" value="<?= $user_image['name'] ?>">
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">';
</form>
</body>
<?php require_once('../footer.php'); ?>
</html>