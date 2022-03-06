<?php
require_once("../config_1.php");
$user = new User($current_user);
$users = $user->get_users("all");

foreach ($users as $user) :
    if ($user['id'] != $current_user['id']) :
        if (!check_match($user['id'], $current_user['id'])) :
?>
<div class="card" id="match<?= $user['id'] ?>">
    <label>
        <i class="far fa-times-circle profile_clear"></i>
        <input type="button" id="profile_clear">
    </label>
    <img src="/user/image/<?= $user['image'] ?>" class="mypage">
    <h3 class="profile_name"><?= $user['name'] ?></h3>
    <p class="comment"><?= $user['profile'] ?></p>
    <div class="matching_btn">
        <label>
            <div class="fa-image_range">
                <i class="fas fa-times-circle"></i>
            </div>
            <input type="button" id="unmatch_btn" data-target="#match<?= $user['id'] ?>" style="display:none;">
            <input type="hidden" class="unmatch_user_id" value="<?= $current_user['id'] ?>">
        </label>
        <label>
            <div class="fa-image_range">
                <i class="fas fa-heart"></i>
            </div>
            <input type="button" id="match_btn" data-target="#match<?= $user['id'] ?>" style="display:none">
            <input type="hidden" id="modal<?= $user['id'] ?>_userid" value="<?= $user['id'] ?>">
            <input type="hidden" class="match_user_id" value="<?= $current_user['id'] ?>">
        </label>
    </div>
</div>
<?php
        endif;
    endif;
endforeach;
?>
<script src=" https://code.jquery.com/jquery-3.4.1.min.js "></script>
<script src="/js/user_page.js"></script>