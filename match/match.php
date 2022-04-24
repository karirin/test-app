<?php
require_once("../config_1.php");
$user = new User($current_user);
$users = $user->get_users("all");

foreach ($users as $user) :
    if ($user['id'] != $current_user['id']) :
        _debug($user["id"] . "   " . $current_user["id"]);
        if (!check_unmatch($user['id'], $current_user['id'])) :
            if (!check_match($user['id'], $current_user['id'])) :
?>
<div class="matching_card">
    <div class="card" id="modal<?= $user['id'] ?>">

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
                <input type="button" id="unmatch_btn" data-target="#modal<?= $user['id'] ?>" style="display:none;">
                <input type="hidden" class="unmatch_user_id" value="<?= $current_user['id'] ?>">
            </label>

            <label>
                <div class="fa-image_range">
                    <i class="fas fa-heart"></i>
                </div>
                <input type="button" id="match_btn" data-target="#modal<?= $user['id'] ?>"
                    data-match="#match<?= $user['id'] ?>" style="display:none;">
                <input type="hidden" id="modal<?= $user['id'] ?>_userid" value="<?= $user['id'] ?>">
                <input type="hidden" class="match_user_id" value="<?= $current_user['id'] ?>">
            </label>
        </div>
    </div>

</div>
<?php require('../matching.php');
            endif;
        endif;
    endif;
endforeach;
require_once("../footer.php");
?>