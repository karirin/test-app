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
        <div class="row">
            <div class="col-6">
                <p class="tag_tittle left">URL</p>
                <input type="text" name="url" class="form-control url_form" placeholder="URLを入力してください">
                <div style="height: 27px;text-align:left;">
                    <span class="post_url_error"
                        style="display:none;color: #dc3545;font-size: 1rem;vertical-align: top;">URLが入力されていません</span>
                </div>
                <p class="tag_tittle left">説明</p>
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
                <p class="tag_tittle left">使用技術</p>
                <div id="skill">
                    <?php
                    foreach ($skills as $skill) :
                        if ($current_user['skill'] != '' && $skill != '') : ?>
                    <span id="child-span" class="skill_tag"><?= $skill ?><label><input type="button"><i
                                class="far  fa-times-circle skill"></i></label></span>
                    <?php
                            if (!isset($skill_tag)) {
                                $skill_tag = array();
                            }
                            array_push($skill_tag, $skill);
                            $skills_len .= $skill;

                            if (3 <= count($skill_tag) || 9 <= strlen($skills_len)) {
                                print '<div></div>';
                                $skill_tag = array();
                                $skills_len = "";
                            }
                        endif;

                    endforeach;
                    ?>
                    <div><input placeholder="skill Stack" name="name" id="skill_input" />
                    </div>
                </div>
                <input type="hidden" name="skills" id="skills">
                <input type="hidden" name="skill_count" id="skill_count">
                <input type="hidden" name="myskills" value="<?= $current_user['skill'] ?>">
                <div class="post_image" style="margin: 0;">
                    <p class="tag_tittle left">画像</p>
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