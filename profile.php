<?php
if (isset($_SESSION['login']) == true) {
    if (isset($_GET['page_id']) && $_GET['page_id'] != 'current_user') {
        $user = new User($_GET['page_id']);
        $current_user = $user->get_user();
    } else {
        $user = new User($_SESSION['user_id']);
        $current_user = $user->get_user();
    }
}
?>
<div class="modal_prof"></div>
<div class="slide_prof">
    <a class="prof_close" href="#">
        <p><i class="fas fa-angle-right"></i></p>
    </a>

    <form method="post" action="../ajax_edit_profile.php" enctype="multipart/form-data">
        <div class="profile">
            <div class="edit_profile_img">
                <label>
                    <div class="fa-image_range">
                        <i class="far fa-image"></i>
                    </div>
                    <input type="file" name="image_name" id="edit_profile_img_narrower" accept="image/*" multiple>
                </label>
                <img name="profile_image" class="editing_profile_img"
                    src="data:image/jpeg;base64,<?= $current_user['image'] ?>">
                <label>
                    <i class="far fa-times-circle profile_clear"></i>
                    <input type="button" id="profile_clear">
                </label>
            </div>
            <img src="data:image/jpeg;base64,<?= $current_user['image'] ?>" class="mypage">
            <h3 class="profile_name_narrower"><?= $current_user['name'] ?></h3>
            <input type="hidden" name="id" class="user_id" value="<?= $current_user['id'] ?>">
            <input type="file" name="image" class="image" value="<?= $current_user['image'] ?>" style="display:none;">
            <div class="row profile_count">
                <div class="col-4 offset-1">
                    <a href="../index.php?page_id=23&type=follow">フォロー数<p>
                            <?= current($user->get_user_count('follow', $current_user['id'])) ?></p></a>
                </div>
                <div class="col-4 offset-1">
                    <a href="../index.php?page_id=23&type=follower">フォロワー数<p>
                            <?= current($user->get_user_count('follower', $current_user['id'])) ?></p></a>
                </div>
            </div>
            <?php
            $skills = explode(" ", $current_user['skill']);
            $skills_len = "";
            $skills_delspace = str_replace("     ", "", $current_user['skill']);
            $skill_tag = array();
            $licences = explode(" ", $current_user['licence']);
            $licences_len = "";
            $licencs_delspace = str_replace("     ", "", $current_user['licence']);
            $licence_tag = array();
            ?>
            <div class="tag">
                <div class="tags">
                    <div class="tag_skill">
                        <p class="tag_tittle">スキル</p>
                        <?php
                        foreach ($skills as $skill) :
                            if ($current_user['skill'] != '' && $skill != '') :

                                array_push($skill_tag, $skill);
                                $skills_len .= $skill;
                                if (3 <= count($skill_tag) || 9 <= mb_strlen($skills_len)) {
                                    print '<span id="child-span_narrow" class="skill_tag extra" style="display: none;">' . $skill . '</span> ';
                                } else {
                                    print '<span id="child-span_narrow" class="skill_tag">' . $skill . '</span> ';
                                }
                            endif;
                        endforeach;
                        ?>
                        <i class="fas fa-plus skill_btn_narrow"></i>
                    </div>
                    <div class="tag_licence">
                        <p class="tag_tittle">取得資格</p>
                        <?php
                        foreach ($licences as $licence) :
                            if ($current_user['licence'] != '' && $licence != '') :

                                array_push($licence_tag, $licence);
                                $licences_len .= $licence;
                                if (2 <= count($licence_tag) || 9 <= mb_strlen($licences_len)) {
                                    print '<span id="child-span_narrow" class="licence_tag extra" style="display: none;">' . $licence . '</span> ';
                                } else {
                                    print '<span id="child-span_narrow" class="licence_tag">' . $licence . '</span> ';
                                }
                            endif;

                        endforeach;
                        ?>
                        <i class="fas fa-plus licence_btn_narrow"></i>
                    </div>
                </div>
                <div class="background">
                    <p class="tag_tittle">職歴</p>
                    <p class="user_workhistory"><?= $current_user['workhistory'] ?></p>
                </div>
            </div>
            <div class="myprofile_btn">
                <?php if ($current_user['id'] == $_SESSION['user_id']) : ?>
                <button class="btn btn btn-outline-dark profile_edit_btn" type="button" name="follow">プロフィール編集</button>
                <?php endif; ?>
            </div>
            <input type="hidden" class="current_user_id" value="<?= $_SESSION['user_id'] ?>">
            <input type="hidden" name="follow_user_id" value="<?= $current_user['id'] ?>">
            <?php if ($current_user['id'] != $_SESSION['user_id']) : ?>
            <?php if ($user->check_follow($_SESSION['user_id'], $current_user['id'])) : ?>
            <button class="follow_btn border_white btn following" style="width: 10rem;margin-left: -0.8rem;"
                type="button" name="follow"><i class="fas fa-user-plus"></i><span
                    id="follow_label">フォロー解除</span></button>
            <?php else : ?>
            <button class="follow_btn border_white btn" style="width: 10rem;margin-left: -0.8rem;" type="button"
                name="follow"><i class="fas fa-user-plus"></i>
                <span id="follow_label">フォローする</span></button>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="form" style="margin:0;">
            <p class="tag_tittle" style="text-align:left;">スキル</p>
            <div id="skill_narrow">
                <?php
                $skills = explode(" ", $current_user['skill']);
                $skills_len = "";
                $skill_tag = array();
                foreach ($skills as $skill) :
                    if ($current_user['skill'] != '' && $skill != '') :

                        array_push($skill_tag, $skill);
                        $skills_len .= $skill;
                        if (3 <= count($skill_tag) || 9 <= mb_strlen($skills_len)) {
                            print '<span id="child-span_narrow" class="skill_tag extra" style="display: none;">' . $skill . '<label><input type="button"><i
                                class="far  fa-times-circle skill"></i></label></span> ';
                        } else {
                            print '<span id="child-span_narrow" class="skill_tag">' . $skill . '<label><input type="button"><i
                                class="far  fa-times-circle skill"></i></label></span> ';
                        }
                    endif;

                endforeach;
                ?>
                <i class="fas fa-plus skill_btn_narrow"></i>
            </div>
            <input placeholder="skill Stack" name="skills" id="skill_input_narrow" />
            <input type="hidden" name="skills" id="skills_narrow">
            <input type="hidden" name="skill_count" id="skill_count_narrow">
            <input type="hidden" name="myskills" value="<?= $current_user['skill'] ?>">
            <div id="licence">
                <p class="tag_tittle">取得資格</p>
                <div id="licence_narrow">
                    <?php
                    $licences_len = "";
                    $licencs_delspace = str_replace("     ", "", $current_user['licence']);
                    $licence_tag = array();
                    foreach ($licences as $licence) :
                        if ($current_user['licence'] != '' && $licence != '') :

                            if (!isset($licence_tag)) {
                                $licence_tag = array();
                            }
                            array_push($licence_tag, $licence);
                            $licences_len .= $licence;

                            if (2 <= count($licence_tag) || 9 <= mb_strlen($licences_len)) {
                                print '<span id="child-span_narrow" class="licence_tag extra" style="display: none;">' . $licence . '<label><input type="button"><i
                                class="far fa-times-circle licence"></i></label></span> ';
                            } else {
                                print '<span id="child-span_narrow" class="licence_tag">' . $licence . '<label><input type="button"><i
                                class="far fa-times-circle licence"></i></label></span> ';
                            }
                        endif;

                    endforeach;
                    ?>
                </div>
                <i class="fas fa-plus licence_btn_narrow"></i>
            </div>
            <input placeholder="licence Stack" name="name" id="licence_input_narrow" />
            <input type="hidden" name="licences" id="licences_narrow">
            <input type="hidden" name="licence_count" id="licence_count_narrow">
            <input type="hidden" name="mylicences" value="<?= $current_user['licence'] ?>">
            <div class="background">
                <p class="tag_tittle">職歴</p>
                <p class="workhistory_narrow"><?= $current_user['workhistory'] ?></p>
                <div class="error_workhistory" style="display: none;">
                    <span style="color:rgb(220, 53, 69);">100文字以内で入力してください</span>
                </div>
            </div>
            <div class="btn_flex">
                <button class="btn btn-outline-info profile_close" type="button">閉じる</button>
                <button class="btn btn-outline-dark profile_narrow_close" type="button"
                    style="width: 100%;">閉じる</button>
                <input type="submit" class="btn btn-outline-dark edit_done" value="編集完了">
            </div>
        </div>

</div>
</form>
</div>