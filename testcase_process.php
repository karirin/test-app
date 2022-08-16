<div class="modal_testcase"></div>
<div class="testcase_process">
    <form method="post" action="../test/test_add_done.php" enctype="multipart/form-data">
        <h6>優先度</h6>
        <div class="form-group" style="display: inline-block;width:28%;margin:0;">
            <select id="priority" name="priority" class="form-control">
                <option value="">--優先度を選択--</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
        </div>
        <div style="height: 27px;">
            <span class="priority_error"
                style="display:none;color: #dc3545;font-size: 1rem;vertical-align: top;">優先度を選択してください</span>
        </div>
        <h6>テストケース</h6>
        <textarea id="test_process_counter" class="textarea form-control" placeholder="優先度を選択してください"
            name="text"></textarea>
        <div style="height: 27px;">
            <span class="testcase_error"
                style="display:none;color: #dc3545;font-size: 1rem;vertical-align: top;">テストケースを入力してください</span>
        </div>
        <div class="counter">
            <span class="post_process_count">0</span><span>/300</span>
        </div>
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <div class="post_btn">
            <button class="btn btn-outline-secondary testcase_btn" type="submit" name="post" value="post"
                id="post">送信</button>
            <button class="btn btn-outline-secondary modal_close" type="button">キャンセル</button>
        </div>
    </form>
</div>
<div class="testcase_disp">
    <span class="testcase_text"></span>
    <div style="height: 27px;">
        <span class="testcase_error"
            style="display:none;color: #dc3545;font-size: 1rem;vertical-align: top;">テストケースを入力してください</span>
    </div>
    <select id="priority" name="priority" class="form-control">
        <option value="未実施">未実施</option>
        <option value="作業中">作業中</option>
        <option value="実装完了">実装完了</option>
    </select>
    <div style="display: flex;justify-content: space-between;">
        <div style="display: inline-block;">
            <img class="test_user_img" style="vertical-align: sub;">
            <span class="testcase_name"></span>
        </div>
        <div>
            <span class="testcase_created_at"></span>
            <input class="testcase_id" type="hidden">
            <button class="btn btn-outline-secondary testcase_clear" type="button">閉じる</button>
        </div>
    </div>
</div>