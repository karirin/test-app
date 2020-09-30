<?php
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
?>
<body>
<?php

try
{

$post_id=$_GET['post_id'];

$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT text,gazou FROM post WHERE id=?';
$stmt=$dbh->prepare($sql);
$data[]=$post_id;
$stmt->execute($data);

$rec = $stmt -> fetch(PDO::FETCH_ASSOC);

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
画像<br />
<?php print '<img src="./gazou/'.$post_gazou_name.'" style="width:200px">';?><br />

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
<?php require_once('../footer.php'); ?>
</html>