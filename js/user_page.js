// getパラメータ取得
function get_param(name, url) {
    if (!url) url = window.location.href;
    //window.location.hrefは現在のURLを取得
    name = name.replace(/[\[\]]/g, "\\$&");
    //replaceは文字の置換を行う
    //`//g`は//の中の文字をすべて第二引数の文字に変換する
    // []はその中の文字があるかを判断
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        //RegExpは引数の値があったときにtureを返す
        results = regex.exec(url);
    //regexp.exec(url)でregexとurlがマッチしている値をresultsに返しています
    if (!results) return null;
    if (!results[2]) return false;
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

// 画像の選択時、表示処理
$('.image').on('change', function(e) {
    var reader = new FileReader();
    $(".process_preview").fadeIn();
    reader.onload = function(e) {
        $(".process_preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});

$('.my_image').on('change', function(e) {
    var reader = new FileReader();
    $(".preview").fadeIn();
    reader.onload = function(e) {
        $(".preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});

$('.edit_image').on('change', function(e) {
    var reader = new FileReader();
    $(".edit_preview").fadeIn();
    reader.onload = function(e) {
        $(".edit_preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});

$('.comment_image').on('change', function(e) {
    var reader = new FileReader();
    $(".comment_preview").fadeIn();
    reader.onload = function(e) {
        $(".comment_preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});

$('#edit_profile_img').on('change', function(e) {
    var reader = new FileReader();
    reader.onload = function(e) {
        $(".editing_profile_img").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});

// いいね機能処理
$(document).on('click', '.favorite_btn', function(e) {
    e.stopPropagation();
    var $this = $(this),
        post_id = $this.prev().val();
    //prev()は$thisの直前にあるhtml要素を取得する
    //val()は取得したいhtml要素のvalue値を取得する
    $.ajax({
        type: 'POST',
        url: '../ajax_post_favorite_process.php',
        dataType: 'json',
        data: {
            post_id: post_id
        }
    }).done(function(data) {
        location.reload();
    }).fail(function() {
        location.reload();
    });
});

// フォロー機能処理
$(document).on('click', '.follow_btn', function(e) {
    e.stopPropagation();
    var $this = $(this),
        current_user_id = $('.current_user_id').val();
    user_id = $this.prev().val();
    //prev()は指定した$thisの直前にあるHTML要素を取得する
    $.ajax({
        type: 'POST',
        url: '../ajax_follow_process.php',
        dataType: 'json',
        data: {
            current_user_id: current_user_id,
            user_id: user_id
        }
    }).done(function() {
        location.reload();
    }).fail(function() {
        location.reload();
    });
});

// 省略されている投稿の高さを取得
$(document).on('click', '.show_all', function() {
    $(document).find('.post_text').removeClass('ellipsis');
    $(this).remove();
});

// テキストエリア内の文字数表示
$('.textarea').on('input', function() {
    var count = $(this).val().length;
    $('.show_count').text(count);
    if (count > 300) {
        $('.show_count').css('color', '#FF7763');
    } else {
        $('.show_count').css('color', '#FFF');
    }
});

// 文字数が0文字、300文字以上以外ボタンを活性化
$(document).on('input', '.textarea', function() {
    if ($(this).val().length !== 0 && $(this).val().length <= 300) {
        $('#post').prop('disabled', false);
    } else {
        $('#post').prop('disabled', true);
    }
});

$(document).on('input', '.textarea', function() {
    if ($(this).val().length !== 0 && $(this).val().length <= 300) {
        $('#post_btn').prop('disabled', false);
    } else {
        $('#post_btn').prop('disabled', true);
    }
});

$(document).on('focus', '.textarea', function() {
    $('#post').prop('disabled', false);
});

$(document).on('focus', '.textarea', function() {
    $('#post_btn').prop('disabled', false);
});

var user_comment = $('.comment').text(),
    user_name = $('.profile_name').text(),
    user_id = $('.user_id').val();

// モーダル画面キャンセルボタン押下時の処理
$(document).on('click', ".modal_close", function() {
    $('body').removeClass('fixed').css({ 'top': 0 });
    window.scrollTo(0, scroll_position);
    $('.modal').fadeOut();
    $('.delete_confirmation').fadeOut();
    $('.post_process').fadeOut();
    $('.post_edit').fadeOut();
    $('.comment_confirmation').fadeOut();
    $('.reply_comment_confirmation').fadeOut();
    $('.edit_comment').replaceWith('<p class="comment">' + user_comment + '</p>');
    $('.edit_name').replaceWith('<h2 class="profile_name">' + user_name + '</h2>');
    $('.mypage').css('display', 'inline');
    $('.edit_profile_img').css('display', 'none');
    $('.btn_flex').css('display', 'none');
    $('.profile').removeClass('editing');
    $('.edit_btn').fadeIn();
});

// 編集ボタン押下時の処理
$(document).on('click', '.edit_btn', function() {
    scroll_position = $(window).scrollTop();
    $('.edit_btn').fadeOut();
    $('body').addClass('fixed').css({ 'top': -scroll_position });
    $('.comment').replaceWith('<textarea class="edit_comment form-control" type="text" value="">' + user_comment);
    $('.profile_name').replaceWith('<input class="edit_name form-control" type="text" value="' + user_name + '">');
    $('.mypage').css('display', 'none');
    $('.edit_profile_img').css('display', 'inline-block');
    $('.btn_flex').css('display', 'flex');
    $('.modal').fadeIn();
    $('.profile').addClass('editing');
});

// プロフィール編集完了ボタン押下時の処理
$(document).on('click', '.profile_save', function(e) {
    e.stopPropagation();
    var comment_data = $('.edit_comment').val(),
        name = $('.edit_name').val(),
        profile_image_src = $('.editing_profile_img').attr("src");

    $.ajax({
        type: 'POST',
        url: '../ajax_edit_profile.php',
        dataType: 'text',
        data: {
            comment_data: comment_data,
            name: name,
            profile_image_src: profile_image_src,
            user_id: user_id
        }
    }).done(function() {
        location.reload();
    }).fail(function() {
        location.reload();
    });
});


// フラッシュメッセージを表示させる
$(function() {
    $message = ('.flash_message');
    setTimeout(function() { $($message).slideToggle('slow'); }, 2000);
});

// モーダル画面出力ボタン押下時の処理
$(document).on('click', '.modal_btn', function() {
    var $target_modal = $(this).data("target")
        //背景をスクロールできないように　&　スクロール場所を維持
    scroll_position = $(window).scrollTop();
    $('body').addClass('fixed').css({ 'top': -scroll_position });
    // モーダルウィンドウを開く
    $($target_modal).fadeIn();
    $('.modal').fadeIn();
});

// 省略されているスレッドの表示
$(document).on('click', '.thread_btn', function() {
    var $target_modal = $(this).data("target"),
        omit_height = $(this).parent().height();
    scroll_position = $(window).scrollTop();
    $(this).remove();
    $($target_modal).fadeIn();
    $(this).parent().height(omit_height);
});

// 投稿モーダル画面出力処理
$(document).on('click', '.post_window', function() {
    //背景をスクロールできないように　&　スクロール場所を維持
    scroll_position = $(window).scrollTop();
    $('body').addClass('fixed').css({ 'top': -scroll_position });
    // モーダルウィンドウを開く
    $('.post_process').fadeIn();
    $('.modal').fadeIn();
});

// 各種ツールチップ処理
$('[data-toggle="favorite"]').tooltip();
$('[data-toggle="post"]').tooltip();
$('[data-toggle="edit"]').tooltip();
$('[data-toggle="delete"]').tooltip();
$('[data-toggle="reply"]').tooltip();
e