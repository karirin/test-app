<?php
session_start();
session_regenerate_id(true);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園</title>
<script src=" https://code.jquery.com/jquery-3.4.1.min.js "></script>
<script src="../js/user_page.js"></script>
</head>
<body>
<?php
require_once('../function.php');
$current_user = $_SESSION['staff_code'];
var_dump($current_user);
try
{

$staff_code=$_GET['staffcode'];

$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT name FROM mst_staff WHERE code=?';
$stmt=$dbh->prepare($sql);
$data[]=$staff_code;
$stmt->execute($data);

$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
$staff_name = $rec['name'];

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
<?php print $staff_code; ?>
<br />
<br />
スタッフ名<br />
<?php print $staff_name;?>
<?php var_dump($_SESSION['staff_code']);?>
<br />
<br />
<form action="#" method="post">
          <input type="hidden" class="profile_user_id">
          <input type="hidden" name="follow_user_id" value="<?= $_SESSION['staff_code'] ?>">
          <!-- フォロー中か確認してボタンを変える -->

          <button class="follow_btn">
          <?php if (check_follow($_SESSION['staff_code'],$staff_code)): ?>

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