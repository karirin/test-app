<?php
require_once('config_2.php');
if (isset($_POST)) {
    $test_id = $_POST["test_id"];
    _debug($test_id);
    $edit_test_text = $_POST["test_text"];
    _debug($edit_test_text);
    try {
        $dbh = db_connect();
        $sql = "UPDATE test
            SET text = :test_text
            WHERE id = :test_id";
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':test_id' => $test_id,
            ':test_text' => $edit_test_text
        ));
    } catch (\Exception $e) {
        error_log($e, 3, "../../php/error.log");
        _debug('メモ更新失敗');
    }
}