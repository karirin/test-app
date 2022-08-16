<?php
require_once('../config_2.php');
require('../head.php');
require('../header.php');
$skills = explode(" ", $current_user['skill']);
$skills_len = "";
$skills_delspace = str_replace("     ", "", $current_user['skill']);
?>

<body>
    <div class="row">
        <div class="col-6 offset-3 center">
            <form method="post" action="post_add_done.php" enctype="multipart/form-data">
                <p class="tag_tittle left">URL</p>
                <input type="text" name="url" class="form-control" placeholder="サービスのURLを記載してください">
                <div class="post_image" style="margin: 1rem 0;">
                    <p class="tag_tittle left">画像</p>
                    <label style="margin:0;">
                        <i class="far fa-image"></i>
                        <input type="file" name="image_name" id="edit_image" accept="image/*" multiple>
                    </label>
                    <div><img class="edit_preview"></div>
                    <i class="far fa-times-circle edit_clear"></i>
                </div>
                <div class="test_explanation left">サービスがイメージできる画像をアップロードしてください</div>
                <div>
                    <p class="tag_tittle left">説明</p>
                    <div class="form-group left">
                        <textarea id="textarea1" class="form-control" name="text" placeholder="説明を入力してください"></textarea>
                    </div>
                </div>
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
                <div class="flex_btn margin_top">
                    <input class="btn btn-outline-dark" type="submit" value="送信">
                </div>
            </form>
        </div>
    </div>
</body>
<?php require_once('../footer.php'); ?>

</html>