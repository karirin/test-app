<?php require_once('../head.php'); ?>
<body>

<?php

$user_id=$_POST['id'];
$user_name=$_POST['name'];
$user_pass=$_POST['pass'];
$user_pass2=$_POST['pass2'];

$user_name=htmlspecialchars($user_name,ENT_QUOTES,'UTF-8');
$user_pass=htmlspecialchars($user_pass,ENT_QUOTES,'UTF-8');
$user_pass2=htmlspecialchars($user_pass2,ENT_QUOTES,'UTF-8');

if($user_name=='')
{
    print'ユーザー名が入力されていません。<br />';
}
else
{
    print'ユーザー名：';
    print $user_name;
    print'<br />';
}
if($user_pass=='')
{
    print'パスワードが入力されていません。<br />';
}
if($user_pass!=$user_pass2)
{
    print'パスワードが一致しません。<br />';
}
if($user_name==''||$user_pass==''||$user_pass!=$user_pass2)
{
    print'<form>';
    print'<input type="button" onclick="history.back()" value="戻る">';
    print'</form>';
}
else
{
    $user_pass=md5($user_pass);
    print'<form method="post" action="user_edit_done.php">';
    print'<input type="hidden" name="id" value="'.$user_id.'">';
    print'<input type="hidden" name="name" value="'.$user_name.'">';
    print'<input type="hidden" name="pass" value="'.$user_pass.'">';
    print'<br />';
    print'<input type="button" onclick="history.back()" value="戻る">';
    print'<input type="submit" value="OK">';
    print'</form>';
}

?>
</body>
<?php require_once('../footer.php'); ?>
</html>