<?php require_once('../head.php'); ?>
<body>

<?php

try
{
$user_name = $_POST['name'];
$user_pass = $_POST['pass'];

$user_name=htmlspecialchars($user_name,ENT_QUOTES,'UTF-8');
$user_pass=htmlspecialchars($user_pass,ENT_QUOTES,'UTF-8');

$dsn = 'mysql:dbname=shop;host=localhost';
$user = 'root';
$password = '';
$dbh = new PDO($dsn,$user,$password);
$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'INSERT INTO user(name,password) VALUES (?,?)';
$stmt = $dbh -> prepare($sql);
$data[] = $user_name;
$data[] = $user_pass;
$stmt -> execute($data);

$dbh = null;

print $user_name;
print 'さんを追加しました。<br />';

}   
catch (Exception $e)
{
print'ただいま障害により大変ご迷惑をお掛けしております。';
exit();
}

?>

<a href="user_list.php">戻る</a>
</body>
</html>