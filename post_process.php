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
                style='margin-right: 1rem;'></i>テスト内容を入力</h5>
        <div class="row">
            <div class="col-6">
                <h5 class="left">URL</h5>
                <input type="text" name="url" class="form-control url_form" placeholder="URLを入力してください">
                <div style="height: 27px;text-align:left;">
                    <span class="post_url_error"
                        style="display:none;color: #dc3545;font-size: 1rem;vertical-align: top;">URLが入力されていません</span>
                </div>
                <h5 class="left">説明</h5>
                <div class="form-group left" style="margin-bottom:0;">
                    <textarea id="textarea1" class="form-control test_form" name="text"
                        placeholder="説明を入力してください"></textarea>
                </div>
                <div style="height: 27px;text-align:left;">
                    <span class="post_text_error"
                        style="display:none;color: #dc3545;font-size: 1rem;vertical-align: top;">説明が入力されていません</span>
                </div>
            </div>
            <div class="col-6">
                <h5 class="left">使用技術</h5>
                <div id="skill">
                    <div><input placeholder="skill Stack" name="name" id="skill_input" />
                    </div>
                </div>
                <input type="hidden" name="skills" id="skills">
                <input type="hidden" name="skill_count" id="skill_count">
                <input type="hidden" name="myskills" value="<?= $current_user['skill'] ?>">
                <div class="post_image" style="margin: 0;">
                    <h5 class="left" style="margin-top: 1rem;">画像</h5>
                    <label style="margin:0;">
                        <i class="far fa-image"></i>
                        <input type="file" name="image_name" id="edit_image" accept="image/*" multiple>
                    </label>
                    <div style="display: inline-block;"><img class="edit_preview"></div>
                    <i class="far fa-times-circle edit_clear"></i>
                </div>
                <div class="test_explanation">サービスの画像をアップロードしてください</div>
            </div>
        </div>
        <div class="post_btn">
            <button class="btn btn-outline-secondary post_process_btn" type="submit" name="post" value="post"
                id="post">投稿</button>
            <button class="btn btn-outline-secondary modal_close" type="button">キャンセル</button>
        </div>
    </form>
</div>