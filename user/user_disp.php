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
                    $skills_delspace = str_replace(" ", "", $current_user['skill']);
                    ?>
                    <div class="skill_form">
                        <div id="skill">
                            <p class="skill_tittle">スキル</p>
                            <?php
                            foreach ($skills as $skill) :
                                if ($current_user['skill'] != '' && $skill != '') : ?>
                            <span id="child-span" class="skill_tag"><?= $skill ?><label><input type="button"><i
                                        class="far  fa-times-circle tag"></i></label></span>
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
                    </div>
            </div>
            </form>

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
                                    <input type="file" name="image_name" id="edit_profile_img_narrow" accept="image/*"
                                        multiple>
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