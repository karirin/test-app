<?php 
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
require_once('../function.php');
?>
<body>
<?php

$current_user = get_user($_SESSION['user_id']);

try
{

$user_id=$_GET['user_id'];

$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT name FROM user WHERE id=?';
$stmt=$dbh->prepare($sql);
$data[]=$user_id;
$stmt->execute($data);

$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
$user_name = $rec['name'];

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
          <input type="hidden" class="profile_user_id">
          <input type="hidden" name="follow_user_id" value="<?= $current_user['id'] ?>">
          <!-- フォロー中か確認してボタンを変える -->

          <button class="follow_btn">
          <?php if (check_follow($current_user['id'],$user_id)): ?>
            フォロー中
          <?php else: ?>
            フォロー
          <?php endif; ?>
          </button>
        </form>
<form>
<input type="button" onclick="history.back()"value="戻る">
</form>
</body>
</html>