<?php
session_start();
session_regenerate_id(true);
?>
<?php require_once('../head.php'); ?>
<script src=" https://code.jquery.com/jquery-3.4.1.min.js "></script>
<script src="../js/user_page.js"></script>
<body>

<?php
require_once('../config.php');

try
{

$post_id=$_GET['post_id'];

$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT name,address,time_start,time_end,gazou FROM post WHERE id=?';
$stmt=$dbh->prepare($sql);
$data[]=$post_id;
$stmt->execute($data);

$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
$post_name = $rec['name'];
$post_address = $rec['address'];
$post_time_start = $rec['time_start'];
$post_time_end = $rec['time_end'];
$post_gazou_name =$rec['gazou'];

$dbh = null;

if($post_gazou_name=='')
{
    $post_gazou='';
}
else
{
    $post_gazou='<img src="./gazou/'.$post_gazou_name.'">';
}

}
catch(Exception $e)
{
    print'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>

詳細投稿情報<br />
<br />
投稿番号<br />
<?php print $post_id; ?>
<br />
<br />
店名<br />
<?php print $post_name;?>
<br />
住所<br />
<?php print $post_address;?>
<br />
画像<br />
<?php print '<img src="./gazou/'.$post_gazou_name.'" style="width:200px">';?><br />
営業時間<br />
<?php print $post_time_start;?>時
~
<?php print $post_time_end;?>時
<br />
<?php print '<a href="../post/post_edit.php?post_id='.$post_id.'">編集</a><br />';?>
<?php print '<a href="../post/post_delete.php?post_id='.$post_id.'">削除</a><br />';?>
      <!-- お気に入りボタン ahaxで処理-->
      <form class="favorite_count" action="#" method="post">
        <input type="hidden" name="post_id">
        <button type="button" name="favorite" class="favorite_btn">
        <!-- 登録済みか判定してアイコンを変える -->
        <?php if (!check_favolite_duplicate($_SESSION['user_id'],$post_id)): ?>
          いいね
        <?php else: ?>
          いいね解除
        <?php endif; ?>
        </button>
        <span class="post_count"><?= current(get_post_favorite_count($post_id)) ?></span>
        <!-- currentは引数に入っている配列の現在の値を渡す -->
</form>
<br />
<br />
<form>
<input type="button" onclick="history.back()"value="戻る"> 
</form>
</body>
</html>