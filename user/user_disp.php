<?php
require_once('../config_1.php');

$page_type = $_GET['type'];
if (isset($_GET['page_id']) && $_GET['page_id'] != 'current_user') {
    $user = new User($_GET['page_id']);
    $current_user = $user->get_user();
} else {
    $user = new User($_SESSION['user_id']);
    $current_user = $user->get_user();
}

$favorite_count = $user->get_user_count('favorite');
$follow_count = $user->get_user_count('follow');
$follower_count = $user->get_user_count('follower');
?>

<body>

    <div class="row wide_disp justify-content-center">
        <div class="myprofile">
            <div class="profile">
                <form method="post" action="../ajax_edit_profile.php" enctype="multipart/form-data">
                    <div class="detail_profile">
                        <div class="edit_profile_img">
                            <label>
                                <div class="fa-image_range">
                                    <i class="far fa-image"></i>
                                </div>
                                <input type="file" name="image_name" id="edit_profile_img" accept="image/*" multiple>
                            </label>
                            <img name="profile_image" class="editing_profile_img"
                                src="/user/image/<?= $current_user['image'] ?>">
                            <label>
                                <i class="far fa-times-circle profile_clear"></i>
                                <input type="button" id="profile_clear">
                            </label>
                        </div>
                        <img src="/user/image/<?= $current_user['image'] ?>" class="mypage">
                        <h3 class="profile_name"><?= $current_user['name'] ?></h3>
                        <p class="comment"><?= $current_user['profile'] ?></p>
                        <input type="hidden" name="id" class="user_id" value="<?= $current_user['id'] ?>">
                        <input type="file" name="image" class="image" value="<?= $current_user['image'] ?>"
                            style="display:none;">
                        <div class="btn_flex">
                            <input type="submit" class="btn btn-outline-dark edit_done" value="編集完了">
                            <button class="btn btn-outline-info modal_close" type="button">キャンセル</button>
                        </div>
                    </div>
                    <?php
                    $skills = explode(" ", $current_user['skill']);
                    $skills_len = "";
                    $skills_delspace = str_replace("     ", "", $current_user['skill']);
                    $licences = explode(" ", $current_user['licence']);
                    $licences_len = "";
                    $licencs_delspace = str_replace(" ", "", $current_user['licence']);
                    ?>
                    <div class="tag">
                        <p class="tag_tittle">スキル</p>
                        <?php
                        foreach ($skills as $skill) :
                            if ($current_user['skill'] != '' && $skill != '') : ?>
                        <span id="child-span" class="skill_tag"><?= $skill ?></span>
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
                        <p class="tag_tittle" style="margin-top: 1rem;">取得資格</p>
                        <?php
                        foreach ($licences as $licence) :
                            if ($current_user['licence'] != '' && $licence != '') : ?>
                        <span id="child-span" class="licence_tag"><?= $licence ?></span>
                        <?php
                                if (!isset($licence_tag)) {
                                    $licence_tag = array();
                                }
                                array_push($licence_tag, $licence);
                                $licences_len .= $licence;

                                if (2 <= count($licence_tag) || 9 <= strlen($licences_len)) {
                                    print '<div></div>';
                                    $licence_tag = array();
                                    $licence_len = "";
                                }
                            endif;

                        endforeach;
                        ?>
                    </div>
                    <div class="form">
                        <div id="skill">
                            <p class="tag_tittle">スキル</p>
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
                        </div>

                        <input placeholder="skill Stack" name="name" id="skill_input" />
                        <input type="hidden" name="skills" id="skills">
                        <input type="hidden" name="skill_count" id="skill_count">
                        <input type="hidden" name="myskills" value="<?= $current_user['skill'] ?>">
                        <div id="licence">
                            <p class="tag_tittle" style="margin-top: 1rem;">取得資格</p>
                            <?php
                            foreach ($licences as $licence) :
                                if ($current_user['licence'] != '' && $licence != '') : ?>
                            <span id="child-span" class="licence_tag"><?= $licence ?><label><input type="button"><i
                                        class="far fa-times-circle licence"></i></label></span>
                            <?php
                                    if (!isset($licence_tag)) {
                                        $licence_tag = array();
                                    }
                                    array_push($licence_tag, $licence);
                                    $licences_len .= $licence;

                                    if (2 <= count($licence_tag) || 9 <= strlen($licences_len)) {
                                        print '<div></div>';
                                        $licence_tag = array();
                                        $licence_len = "";
                                    }
                                endif;

                            endforeach;
                            ?>
                        </div>

                        <input placeholder="licence Stack" name="name" id="licence_input" />
                        <input type="hidden" name="licences" id="licences">
                        <input type="hidden" name="licence_count" id="licence_count">
                        <input type="hidden" name="mylicences" value="<?= $current_user['licence'] ?>">
                    </div>
                    <div class="background">
                        <p class="tag_tittle">学歴</p>
                        <p class="educational"><?= $current_user['educational'] ?></p>
                        <p class="tag_tittle" style="margin-top: 1rem;">職歴</p>
                        <p class="workhistory"><?= $current_user['workhistory'] ?></p>
                    </div>
                </form>
                <div>
                    <div class="man" style="display:none">
                        男
                    </div>
                    <div class="woman" style="display:none">
                        女
                    </div>
                    <input type="button" name="next" alt="次へ" href="#example-2" class="btn btn-outline-dark" id="next">
                    <input type="button" name="before" alt="前へ" href="#example-2" class="btn btn-outline-dark"
                        id="before">
                </div>

                <?php if ($current_user['id'] != $_SESSION['user_id']) : ?>
                <form action="#" method="post">
                    <input type="hidden" class="current_user_id" value="<?= $_SESSION['user_id'] ?>">
                    <input type="hidden" name="follow_user_id" value="<?= $current_user['id'] ?>">
                    <?php if ($user->check_follow($_SESSION['user_id'], $current_user['id'])) : ?>
                    <button class="follow_btn border_white btn following" type="button" name="follow">フォロー中</button>
                    <?php else : ?>
                    <button class="follow_btn border_white btn" type="button" name="follow">フォロー</button>
                    <?php endif; ?>
                </form>
                <?php endif; ?>

                <div class="myprofile">
                    <?php if ($current_user['id'] == $_SESSION['user_id']) : ?>
                    <button class="btn btn btn-outline-dark edit_btn" type="button" name="follow">プロフィール編集</button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row narrow_disp">
                <div>
                    <div class="myprofile">
                        <div class="profile">
                            <form method="post" action="../ajax_edit_profile.php" enctype="multipart/form-data">
                                <div class="edit_profile_img">
                                    <label>
                                        <div class="fa-image_range">
                                            <i class="far fa-image"></i>
                                        </div>
                                        <input type="file" name="image_name" id="edit_profile_img_narrow"
                                            accept="image/*" multiple>
                                    </label>
                                    <img name="profile_image" class="editing_profile_img"
                                        src="/user/image/<?= $current_user['image'] ?>">
                                    <label>
                                        <i class="far fa-times-circle profile_clear"></i>
                                        <input type="button" id="profile_clear">
                                    </label>
                                </div>
                                <img src="/user/image/<?= $current_user['image'] ?>" class="mypage">
                                <h3 class="profile_name_narrow"><?= $current_user['name'] ?></h3>
                                <p class="comment_narrow"><?= $current_user['profile'] ?></p>
                                <input type="hidden" name="id" class="user_id" value="<?= $current_user['id'] ?>">
                                <input type="file" name="image" class="image" value="<?= $current_user['image'] ?>"
                                    style="display:none;">
                                <div class="btn_flex">
                                    <input type="submit" class="btn btn-outline-dark" value="編集完了">
                                    <button class="btn btn-outline-info modal_close" type="button">キャンセル</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row narrower_disp">
                <div class="col-8 offset-2">
                    <?php
                    if ($page_type === 'main') :
                    ?>
                    <h2><?= $current_user['name'] ?>さんの投稿</h2>
                    <?php elseif ($page_type === 'favorites') : ?>
                    <h2>お気に入りの投稿</h2>
                    <?php elseif ($page_type === 'follow') : ?>
                    <h2>フォローした人</h2>
                    <?php elseif ($page_type === 'follower') : ?>
                    <h2>フォロワー</h2>
                    <?php endif;

                    require('user_list.php');
                    ?>
                </div>
            </div>

            <?php

            require_once('../footer.php'); ?>