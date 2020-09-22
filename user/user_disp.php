<?php
session_start();
session_regenerate_id(true);
?>
<?php require_once('../head.php'); ?>
<script src=" https://id.jquery.com/jquery-3.4.1.min.js "></script>
<script src="../js/user_page.js"></script>
<body>
<?php
require_once('../function.php');
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

スタッフ情報参照<br />
<br />
スタッフコード<br />
<?php print $user_id; ?>
<br />
<br />
スタッフ名<br />
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