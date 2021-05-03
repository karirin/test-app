<?php 
session_start();
@session_regenerate_id(true);

require('../db_connect.php');
require_once('../function.php');

set_flash('sucsess','投稿を削除しました');
reload();
?>

<body>
    <?php
try
{

$post_id = $_POST['id'];
$post_image_name = $_POST['image_name'];
$comment=get_post($post_id);

$dbh = dbConnect();
if(check_comment($post_id)){
$sql = 'DELETE post,comment FROM post INNER JOIN comment ON post.id = comment.post_id WHERE post.id=?';
}else{
$sql = 'DELETE post FROM post WHERE post.id=?';
_debug('        '.$sql.'        ');
_debug('        '.$post_id.'        ');
}
$stmt = $dbh -> prepare($sql);
$data[] = $post_id;
$stmt -> execute($data);

$dbh = null;

if($post_image_name != '')
{
    unlink('./image/'.$post_image_name);
}

}   
catch (Exception $e)
{
print'ただいま障害により大変ご迷惑をお掛けしております。';
exit();
}
?>

</body>
<?php require_once('../footer.php'); ?>

</html>