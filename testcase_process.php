<div class="modal_testcase"></div>
<div class="testcase_process">
    <form method="post" action="../test/test_add_done.php" enctype="multipart/form-data">
        <h5 class="center" style="font-size :1.5rem;margin-bottom:1rem;"><i class="far fa-file-alt"
                style="margin-right: 1rem;"></i>追加したいテストケース内容を入力
        </h5>
        <h5>テストケース</h5>
        <textarea id="test_process_counter" class="textarea form-control" placeholder="ログインができない"
            name="text"></textarea>
        <div style="height: 27px;">
            <span class="testcase_error"
                style="display:none;color: #dc3545;font-size: 1rem;vertical-align: top;">テストケースを入力してください</span>
        </div>
        <h5>手順</h5>
        <textarea id="test_process_counter" class="textarea form-control"
            placeholder="①ヘッダーの「ログインボタン」をクリック                                      ②ユーザー名、パスワードを入力後、ログインする"
            name="procedure"></textarea>
        <div style="height: 27px;">
            <span class="testcase_procedure_error"
                style="display:none;color: #dc3545;font-size: 1rem;vertical-align: top;">テストケースを入力してください</span>
        </div>
        <h5>優先度</h5>
        <div class="form-group" style="display: inline-block;margin:0;">
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
        <?php if (basename($_SERVER['PHP_SELF']) === 'test_disp.php') : ?>
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <?php endif; ?>

        <div class="post_btn" style="width: 100%;">
            <button class="btn btn-outline-secondary modal_close" type="button">閉じる</button>
            <button class="btn btn-outline-secondary testcase_btn" type="submit" name="post" value="post"
                id="post">送信</button>
        </div>
    </form>
</div>
<div class="testcase_disp">
    <h5 class="center" style="font-size :1.5rem;margin-bottom:1rem;"><i class="fas fa-newspaper"
            style="margin-right: 1rem;"></i>テストケース詳細画面</h5>
    <h5 style="font-weight:bold;">テストケース内容</h5>
    <span class="testcase_text"></span>
    <div style="height: 27px;">
        <span class="testcase_error"
            style="display:none;color: #dc3545;font-size: 1rem;vertical-align: top;">テストケースを入力してください</span>
    </div>
    <h5 style="font-weight:bold;">テスト手順</h5>
    <span class="testcase_procedure"></span>
    <div style="height: 27px;">
        <span class="testcase_procedure_error"
            style="display:none;color: #dc3545;font-size: 1rem;vertical-align: top;">テストケースを入力してください</span>
    </div>
    <span class="add_edit_priority">
        <span>進捗度</span>
        <select id="priority" name="priority" class="form-control" style="margin-right: 1rem;display:inline-block;">
            <option value="未実施">未実施</option>
            <option value="作業中">作業中</option>
            <option value="完了">完了</option>
        </select>
    </span>
    <span class="add_edit_progress">
        <span>優先度</span>
        <select id="progress" name="priority" class="form-control" style="margin-right: 1rem;display:inline-block;">
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
        </select>
    </span>
    <span class="good_btn">
        <span>高評価</span>
        <i class="fas fa-thumbs-up" style="vertical-align: unset;"></i>
    </span>
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
    </span>
</div>
<div class="testcase_delete">
    <p>こちらのテストケースを削除しますか</p>
    <span class="testcase_text"></span>
    <div style="justify-content: space-evenly;display: flex;margin-top:1rem;">
        <button class="btn btn-outline-secondary testcase_clear" type="button">閉じる</button>
        <button class="btn btn-outline-secondary testcase_delete_btn">削除</button>
    </div>
    <input class="current_user_id" value="<?= $_SESSION['user_id']; ?>" type="hidden">
    <input class="testcase_id" type="hidden">
</div>