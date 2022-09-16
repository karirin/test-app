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
    if ($_POST["comment_flg"]) {
        $test_id = $_POST["test_id"];
        $test_comment = $_POST["test_comment"];
        $date = new DateTime();
        $date->setTimeZone(new DateTimeZone('Asia/Tokyo'));
        $user_id = $_POST["user_id"];
        // 重複追加防止
        if ($test_comment != '') {
            try {
                $dbh = db_connect();
                $sql =   $sql = "INSERT INTO comment(text,user_id,created_at,test_id) VALUES(:text,:user_id,:created_at,:test_id)";
                $stmt = $dbh->prepare($sql);
                $stmt->execute(array(
                    ':text' => $test_comment,
                    ':user_id' => $user_id,
                    ':created_at' => $date->format('Y-m-d H:i:s'),
                    ':test_id' => $test_id
                ));
            } catch (\Exception $e) {
                error_log($e, 3, "../php/error.log");
                _debug('メモ更新失敗');
            }
        }
    }
    if ($_POST["t_flg"]) {
        $test_id = $_POST["test_id"];
        try {
            $dbh = db_connect();
            $sql = "UPDATE test
                SET rated = 1
                WHERE id = :test_id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(
                ':test_id' => $test_id
            ));
        } catch (\Exception $e) {
            error_log($e, 3, "../../php/error.log");
            _debug('メモ更新失敗');
        }
    }
    if ($_POST["delete_flg"]) {
        $test_id = $_POST["test_id"];
        try {
            $dbh = db_connect();
            $sql = "DELETE FROM test
                WHERE id = :test_id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(
                ':test_id' => $test_id
            ));
        } catch (\Exception $e) {
            error_log($e, 3, "../../php/error.log");
            _debug('メモ更新失敗');
        }
    }
    if ($_POST["delete_post_flg"]) {
        $test_id = $_POST["post_id"];
        try {
            $dbh = db_connect();
            $sql = "DELETE FROM post
                WHERE id = :post_id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(
                ':post_id' => $post_id
            ));
        } catch (\Exception $e) {
            error_log($e, 3, "../../php/error.log");
            _debug('メモ更新失敗');
        }
    }
}