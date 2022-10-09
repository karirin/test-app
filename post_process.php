<div class="modal_post"></div>
<div class="post_process">
    <?php
    $current_user = new User($_SESSION['user_id']);
    $current_user = $current_user->get_user();
    $skills = explode(" ", $current_user['skill']);
    $skills_len = "";
    $skills_delspace = str_replace("     ", "", $current_user['skill']);
    ?>
    <form method="post" action="../post/post_add_done.php" enctype="multipart/form-data">
        <h5 class="center" style="font-size :1.5rem;margin-bottom:1rem;"><i class="fas fa-file-alt"
                style='margin-right: 1rem;'></i>依頼したいテスト内容を入力</h5>
        <div class="row">
            <div class="col-6">
                <h5 class="left">URL<span class="request_label">必須</span></h5>
                <input class="form-control url_form" placeholder="https://www.XXXX.XXXX" name="url"></input>
                <div style="height: 27px;text-align:left;">
                    <span class="post_url_error"
                        style="display:none;color: #dc3545;font-size: 1rem;vertical-align: top;">URLが入力されていません</span>
                </div>
                <h5 class="left">サービス内容<span class="request_label">必須</span></h5>
                <div class="form-group left" style="margin-bottom:0;">
                    <textarea id="textarea1" class="form-control service" name="service"
                        placeholder="Webサイト等をテスト依頼できるサービス"></textarea>
                </div>
                <div style="height: 27px;text-align:left;">
                    <span class="post_service_error"
                        style="display:none;color: #dc3545;font-size: 1rem;vertical-align: top;">サービス内容が入力されていません</span>
                </div>
                <h5 class="left">どのようなテストを希望するか<span class="request_label"
                        style="border: 1px solid #7e7e7e;color: #7e7e7e;">任意</span></h5>
                <div class="form-group left" style="margin-bottom:0;">
                    <textarea id="textarea1" class="form-control test_form" name="test_request"
                        placeholder="テストケース追加のテストをしてほしい"></textarea>
                </div>
            </div>
            <div class="col-6">
                <h5 class="left">アプリケーション形式<span class="request_label">必須</span></h5>
                <select id="app_format" name="app_format" class="form-control" style="width: 35%;">
                    <option value="WEBサイト">WEBサイト</option>
                    <option value="スマホアプリ">スマホアプリ</option>
                    <option value="その他アプリ">その他アプリ</option>
                </select>
                <!-- <h5 class="left">使用技術</h5>
                <div id="skill">
                    <div><input placeholder="skill Stack" name="name" id="skill_input" />
                    </div>
                </div>
                <input type="hidden" name="skills" id="skills">
                <input type="hidden" name="skill_count" id="skill_count">
                <input type="hidden" name="myskills"> -->
                <div class="post_image" style="margin: 0;">
                    <h5 class="left" style="margin-top: 1rem;">画像<span class="request_label"
                            style="border: 1px solid #7e7e7e;color: #7e7e7e;">任意</span></h5>
                    <label style="margin:0;">
                        <i class="far fa-image"></i>
                        <input type="file" name="image_name" id="edit_image" accept="image/*" multiple>
                    </label>
                    <div style="display: inline-block;"><img class="edit_preview"></div>
                    <i class="far fa-times-circle edit_clear"></i>
                </div>
                <div class="test_explanation">サービスの画像をアップロードしてください</div>
                <div style="font-size: 0.9rem;">※（縦横100px×200px以上推奨、5MB未満）</div>
            </div>
        </div>
        <div class="post_btn" style="margin-top:1rem;">
            <button class="btn btn-outline-secondary modal_close" type="button">閉じる</button>
            <button class="btn btn-outline-secondary post_process_btn" type="submit" name="post" value="post"
                id="post">投稿</button>
        </div>
    </form>
</div>
<div class="post_delete">
    <p>こちらの投稿を削除しますか</p>
    <span class="post_process_text"></span>
    <div style="justify-content: space-evenly;display: flex;margin-top:1rem;">
        <button class="btn btn-outline-secondary post_clear" type="button">閉じる</button>
        <button class="btn btn-outline-secondary delete_post_btn">削除</button>
    </div>
    <input class="post_id" type="hidden">
</div>