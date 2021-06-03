<?php
require_once('../config_2.php');

set_flash('sucsess', '投稿を削除しました');
reload();

try {

    $post_id = $_POST['id'];
    $post_image_name = $_POST['image_name'];
    $comment = get_post($post_id);

    $dbh = db_connect();
    if (check_comment($post_id)) {
        $sql = 'DELETE post,comment FROM post INNER JOIN comment ON post.id = comment.post_id WHERE post.id=?';
    } else {
        $sql = 'DELETE post FROM post WHERE post.id=?';
    }
    $stmt = $dbh->prepare($sql);
    $data[] = $post_id;
    $stmt->execute($data);

    $dbh = null;

    if ($post_image_name != '') {
        unlink('./image/' . $post_image_name);
    }
} catch (Exception $e) {
    _debug('投稿削除失敗');
    exit();
}
?>
</body>
<?php require_once('../footer.php'); ?>

</html>