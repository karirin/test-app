<?php
require_once('../config_2.php');

try {

    $post_image_name = $_POST['image_name'];
    $post_class = new Post($_POST['id']);
    $post = $post_class->get_post();

    $dbh = db_connect();
    if (check_comment($post['id'])) {
        $sql = 'DELETE post,comment FROM post INNER JOIN comment ON post.id = comment.post_id WHERE post.id=?';
    } else {
        $sql = 'DELETE post FROM post WHERE post.id=?';
    }
    $stmt = $dbh->prepare($sql);
    $data[] = $post['id'];
    $stmt->execute($data);

    $dbh = null;

    if ($post_image_name != '') {
        unlink('./image/' . $post_image_name);
    }
} catch (Exception $e) {
    error_log($e, 3, "../error.log");
    _debug('投稿削除失敗');
    exit();
}

set_flash('sucsess', '投稿を削除しました');
reload();
?>
</body>
<?php require_once('../footer.php'); ?>

</html>