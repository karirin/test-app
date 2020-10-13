<?php 
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
?>
<body>
<?php

// $current_user = get_user($_SESSION['user_id']);

try
{

$current_user = get_user($_GET['user_id']);
$profile_user = get_user($_GET['page_id']);

$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT name,id FROM user WHERE id=?';
$stmt=$dbh->prepare($sql);
$data[]=$profile_user['id']; 
$stmt->execute($data);

$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
$user_name = $rec['name'];
$user_id = $rec['id'];

$dbh = null;
}
catch(Exception $e)
{
    print'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

ユーザー情報参照<br />
<br />
ユーザーコード<br />
<?php print $user_id; ?>
<br />
<br />
ユーザー名<br />
<?php print $user_name;?>

<br />
<br />
<form action="#" method="post">
          <input type="hidden" class="current_user_id" value="<?= $current_user['id'] ?>">
          <input type="hidden" name="follow_user_id" value="<?= $user_id ?>">
          <!-- フォロー中か確認してボタンを変える -->
          <?php if (check_follow($current_user['id'],$user_id)): ?>
          <button class="follow_btn border_white btn following" type="button" name="follow">フォロー中</button>
          <?php else: ?>
            <button class="follow_btn border_white btn" type="button" name="follow">フォロー</button>
          <?php endif; ?>
</form>
<input type="button" onclick="history.back()"value="戻る">
</form>
</body>
<?php require_once('../footer.php'); ?>
</html>