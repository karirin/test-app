<?php 
require_once('../config.php');
?>
<body>
<?php

try
{
    
$comment_id=$_GET['comment_id'];
$user_id = $_GET['user_id'];
$post_id = $_GET['post_id'];

$comment = get_comment($comment_id);

$dbh = null;

if($comment['image']=='')
{
    $disp_image='';
}
else
{
    $disp_image='<img src="./image/'.$comment['image'].'">';
}

$dbh = dbConnect();
$sql = 'DELETE FROM comment WHERE id=?';
$stmt = $dbh -> prepare($sql);
$data[] = $comment_id;
$stmt -> execute($data);

$dbh = null;

if($comment['image'] != '')
{
    unlink('./image/'.$comment['image']);
}
}
catch(Exception $e)
{
    print'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>


<p><?php $comment['text'] ?></p>
このコメントを削除してもよろしいでしょうか。

<form method="post" action="/comment/comment_delete_done.php">
<input type="hidden" name="id" value="<?= $comment['id']; ?>">
<input type="hidden" name="image_name" value="<?= $comment['image']; ?>">
<input type="hidden" name="user_id" value="<?= $user_id; ?>">
<input type="hidden" name="post_id" value="<?= $post_id; ?>">
<input type="button" onclick="history.back()"value="戻る">
<input type="submit" value="OK">
</form>
</body>
<?php require_once('../footer.php'); ?>
</html>