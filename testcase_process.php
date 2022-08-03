<div class="modal_testcase"></div>
<div class="testcase_process">
    <form method="post" action="../test/test_add_done.php" enctype="multipart/form-data">
        <h6>優先度</h6>
        <div class="form-group">
            <select name="priority" class="priority form-control">
                <option value="">--優先度を選択--</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
        </div>
        <h6>テストケース</h6>
        <textarea id="post_process_counter" class="textarea form-control" placeholder="テストケースを入力ください"
            name="text"></textarea>
        <div class="counter">
            <span class="post_process_count">0</span><span>/300</span>
        </div>
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <div class="post_btn">
            <button class="btn btn-outline-secondary" type="submit" name="post" value="post" id="post">送信</button>
            <button class="btn btn-outline-secondary modal_close" type="button">キャンセル</button>
        </div>
    </form>
</div>