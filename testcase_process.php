<div class="modal_testcase"></div>
<div class="testcase_process">
    <form method="post" action="../test/test_add_done.php" enctype="multipart/form-data">
        <h5>優先度</h5>
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
        <h5>テストケース</h5>
        <textarea id="test_process_counter" class="textarea form-control" placeholder="テストケースを入力してください"
            name="text"></textarea>
        <div style="height: 27px;">
            <span class="testcase_error"
                style="display:none;color: #dc3545;font-size: 1rem;vertical-align: top;">テストケースを入力してください</span>
        </div>
        <?php if (basename($_SERVER['PHP_SELF']) === 'test_disp.php') : ?>
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <?php endif; ?>
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
    <input type="hidden" class="comment">
    <div class="input-group mb-2 comment">
        <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary comment_btn">送信</button>
        </div>
    </div>
    <select id="priority" name="priority" class="form-control">
        <option value="未実施">未実施</option>
        <option value="作業中">作業中</option>
        <option value="完了">完了</option>
    </select>
    <select id="progress" name="priority" class="form-control">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
    </select>
    <i class="fab fa-tumblr t_btn" style="vertical-align: unset;margin-left: 0.9rem;"></i>
    <div style="display: flex;justify-content: space-between;">
        <div style="display: inline-block;">
            <img class="test_user_img" style="vertical-align: sub;">
            <span class="testcase_name"></span>
        </div>
        <div>
            <span class="testcase_created_at"></span>
            <input class="current_user_id" value="<?= $_SESSION['user_id']; ?>" type="hidden">
            <input class="testcase_id" type="hidden">
            <button class="btn btn-outline-secondary testcase_clear" type="button">閉じる</button>
        </div>
    </div>
</div>
<div class="testcase_delete">
    <p>こちらのテストケースを削除しますか</p>
    <span class="testcase_text"></span>
    <div style="justify-content: space-evenly;display: flex;margin-top:1rem;">
        <button class="btn btn-outline-secondary delete_btn">削除</button>
        <button class="btn btn-outline-secondary testcase_clear" type="button">閉じる</button>
    </div>
    <input class="current_user_id" value="<?= $_SESSION['user_id']; ?>" type="hidden">
    <input class="testcase_id" type="hidden">
</div>