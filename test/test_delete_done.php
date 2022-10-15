<?php
require_once('../config_2.php');

try {
    $dbh = db_connect();
    _debug($_POST);
    $sql = 'DELETE test FROM test WHERE id=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $_POST['testcase_id'];
    $stmt->execute($data);

    $dbh = null;
} catch (Exception $e) {
    error_log($e, 3, "../error.log");
    _debug('投稿削除失敗');
    exit();
}

set_flash('sucsess', 'テストケースを削除しました');
reload();
?>
</body>
<?php require_once('../footer.php'); ?>

</html>