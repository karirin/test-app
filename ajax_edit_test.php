<?php
require_once('config_2.php');
if (isset($_POST)) {
    if ($_POST["disp_flg"]) {
        $test_id = $_POST["test_id"];
        $edit_test_text = $_POST["test_text"];
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
    if ($_POST["select_flg"]) {
        $test_id = $_POST["test_id"];
        $test_val = $_POST["test_val"];
        try {
            $dbh = db_connect();
            $sql = "UPDATE test
                SET progress = :test_val
                WHERE id = :test_id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(
                ':test_id' => $test_id,
                ':test_val' => $test_val
            ));
        } catch (\Exception $e) {
            error_log($e, 3, "../../php/error.log");
            _debug('メモ更新失敗');
        }
    }
    if ($_POST["progress_flg"]) {
        $test_id = $_POST["test_id"];
        $test_val = $_POST["test_val"];
        try {
            $dbh = db_connect();
            $sql = "UPDATE test
                SET priority = :test_val
                WHERE id = :test_id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(
                ':test_id' => $test_id,
                ':test_val' => $test_val
            ));
        } catch (\Exception $e) {
            error_log($e, 3, "../../php/error.log");
            _debug('メモ更新失敗');
        }
    }
}