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

$('.slide_menu').show();

$('.show_menu').on('click', function() {
    scroll_position = $(window).scrollTop();
    $('body').addClass('fixed').css({ 'top': -scroll_position });
    $('.modal').fadeIn();
    $('.slide_menu').addClass('open');
})

$('.slide_prof').on('click', function() {
    scroll_position = $(window).scrollTop();
    $('body').addClass('fixed').css({ 'top': -scroll_position });
    $('.modal').fadeIn();
    $('.slide_prof').addClass('open');
})

// 画像の選択時、表示処理
$('#image').on('change', function(e) {
    var reader = new FileReader();
    $(".process_preview").fadeIn();
    reader.onload = function(e) {
        $(".process_preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});

$('#my_image').on('change', function(e) {
    var reader = new FileReader();
    $(".my_preview").fadeIn();
    $(".message_text").fadeOut();
    reader.onload = function(e) {
        $(".my_preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});

$('#edit_image,#edit_image_narrow,#edit_image_narrower').on('change', function(e) {
    var reader = new FileReader();
    $(".edit_preview").fadeIn();
    reader.onload = function(e) {
        $(".edit_preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});

$('#comment_image,#comment_image_narrow,#comment_image_narrower').on('change', function(e) {
    var reader = new FileReader();
    $(".comment_preview").fadeIn();
    reader.onload = function(e) {
        $(".comment_preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});

$('#reply_comment_image').on('change', function(e) {
    var reader = new FileReader();
    $(".reply_comment_preview").fadeIn();
    reader.onload = function(e) {
        $(".reply_comment_preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});

$('#edit_profile_img,#edit_profile_img_narrow,#edit_profile_img_narrower').on('change', function(e) {
    var reader = new FileReader();
    $(".editing_profile_img").fadeIn();
    reader.onload = function(e) {
        $(".editing_profile_img").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});

$('#process_image').on('change', function(e) {
    var reader = new FileReader();
    $(".process_preview").fadeIn();
    reader.onload = function(e) {
        $(".process_preview").attr('src', e.target.result);
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
        current_user_id = $('.current_user_id').val(),
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
$('#post_counter').on('input', function() {
    var count = $(this).val().length;
    $('.post_count').text(count);
    if (count > 300) {
        $('.post_count').css('color', '#FF7763');
    } else {
        $('.post_count').css('color', '#000');
    }
});

$('#comment_counter,#comment_counter_narrow,#comment_counter_narrower').on('input', function() {
    var count = $(this).val().length;
    $('.comment_count').text(count);
    if (count > 300) {
        $('comment_count').css('color', '#FF7763');
    } else {
        $('comment_count').css('color', '#FFF');
    }
});

$('#edit_counter,#edit_counter_narrow,#edit_counter_narrower').on('input', function() {
    var count = $(this).val().length;
    $('.post_edit_count').text(count);
    if (count > 300) {
        $('.post_edit_count').css('color', '#FF7763');
    } else {
        $('.post_edit_count').css('color', '#FFF');
    }
});

$('#post_process_counter').on('input', function() {
    var count = $(this).val().length;
    $('.post_process_count').text(count);
    if (count > 300) {
        $('.post_process_count').css('color', '#FF7763');
    } else {
        $('.post_process_count').css('color', '#FFF');
    }
});

$('#message_counter').on('input', function() {
    var count = $(this).val().length;
    $('.message_count').text(count);
    if (count > 300) {
        $('.message_count').css('color', '#FF7763');
    } else {
        $('.message_count').css('color', '#000');
    }
});

// メッセージリンク押下時の処理
$(document).on('click', "#message_link", function() {
    $('#message_count').fadeOut();
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
    user_comment_narrow = $('.comment_narrow').text(),
    user_name_narrow = $('.profile_name_narrow').text(),
    user_comment_narrower = $('.comment_narrower').text(),
    user_name_narrower = $('.profile_name_narrower').text(),
    user_id = $('.user_id').val();

// モーダル画面キャンセルボタン押下時の処理
$(document).on('click', ".modal_close", function() {
    $('body').removeClass('fixed').css({ 'top': 0 });
    window.scrollTo(0, scroll_position);
    $('.modal').fadeOut();
    $('.modal_post').fadeOut();
    $('.delete_confirmation').fadeOut();
    $('.post_process').fadeOut();
    $('.post_edit').fadeOut();
    $('.comment_confirmation').fadeOut();
    $('.reply_comment_confirmation').fadeOut();
    $('.edit_comment').replaceWith('<p class="comment">' + user_comment + '</p>');
    $('.edit_name').replaceWith('<h2 class="profile_name">' + user_name + '</h2>');
    $('.edit_comment_narrow').replaceWith('<p class="comment">' + user_comment_narrow + '</p>');
    $('.edit_name_narrow').replaceWith('<h2 class="profile_name">' + user_name_narrow + '</h2>');
    $('.edit_comment_narrower').replaceWith('<p class="comment">' + user_comment_narrower + '</p>');
    $('.edit_name_narrower').replaceWith('<h2 class="profile_name">' + user_name_narrower + '</h2>');
    $('.mypage').css('display', 'inline');
    $('.edit_profile_img').css('display', 'none');
    $('.btn_flex').css('display', 'none');
    $('.profile').removeClass('editing');
    $('.edit_btn').fadeIn();
    $('.slide_menu').removeClass('open');
});

// 編集ボタン押下時の処理
$(document).on('click', '.edit_btn', function() {
    scroll_position = $(window).scrollTop();
    $('.edit_btn').fadeOut();
    $('body').addClass('fixed').css({ 'top': -scroll_position });
    $('.comment').replaceWith('<textarea class="edit_comment form-control" type="text" name="user_comment" >' + user_comment);
    $('.profile_name').replaceWith('<input class="edit_name form-control" type="text" name="user_name" value="' + user_name + '">');
    $('.comment_narrow').replaceWith('<textarea class="edit_comment form-control" type="text" name="user_comment" >' + user_comment_narrow);
    $('.profile_name_narrow').replaceWith('<input class="edit_name form-control" type="text" name="user_name" value="' + user_name_narrow + '">');
    $('.comment_narrower').replaceWith('<textarea class="edit_comment form-control" type="text" name="user_comment" >' + user_comment_narrower);
    $('.profile_name_narrower').replaceWith('<input class="edit_name form-control" type="text" name="user_name" value="' + user_name_narrower + '">');
    $('.mypage').css('display', 'none');
    $('.edit_profile_img').css('display', 'inline-block');
    $('.btn_flex').css('display', 'flex');
    $('.modal_prof').fadeIn();
    $('.profile').addClass('editing');
});

function file_name(extension) {
    var s = this.replace(/\\/g, '/');
    s = s.substring(s.lastIndexOf('/') + 1);
    return extension ? s.replace(/[?#].+$/, '') : s.split('.')[0];
}

$(document).on('change', '#process_image', function() {
    $('#process_clear').show();
    $(document).on('click', '#process_clear', function() {
        $('#process_image').val('');
        $(this).hide();
        $('.process_preview').hide();
        $('#process_clear').hide();
    });
});

$(document).on('change', '#my_image', function() {
    $('.far.fa-times-circle.my_clear').show();
    $(document).on('click', '#my_clear', function() {
        $('#my_image').val('');
        $('.far.fa-times-circle.my_clear').hide();
        $('.my_preview').hide();
    });
});
$(document).on('change', '#edit_profile_img,#edit_profile_img_narrow,#edit_profile_img_narrower', function() {
    $('.far.fa-times-circle.profile_clear').show();
    $(document).on('click', '#profile_clear', function() {
        $('#edit_profile_img,#edit_profile_img_narrow,#edit_profile_img_narrower').val('');
        $('.far.fa-times-circle.profile_clear').hide();
        $('.editing_profile_img').hide();
    });
});
$(document).on('change', '#comment_image,#comment_image_narrow,#comment_image_narrower', function() {
    $('#comment_clear,#comment_clear_narrow,#comment_image_narrower').show();
    $(document).on('click', '#comment_clear,#comment_clear_narrow,#comment_clear_narrower', function() {
        $('#comment_image,#comment_image_narrow,#comment_image_narrower').val('');
        $(this).hide();
        $('.comment_preview').hide();
        $('#comment_clear,#comment_clear_narrow,#comment_clear_narrower').hide();
    });
});
$(document).on('change', '#reply_comment_image', function() {
    $('#reply_clear').show();
    $(document).on('click', '#reply_clear', function() {
        $('#reply_comment_image').val('');
        $(this).hide();
        $('.reply_comment_preview').hide();
        $('#reply_clear').hide();
    });
});
$(document).on('change', '#edit_image,#edit_image_narrow,#edit_image_narrower', function() {
    $('#edit_clear,#edit_clear_narrow,#edit_image_narrower').show();
    $(document).on('click', '#edit_clear_narrow', function() {
        $('#edit_image_narrow').val('');
        $(this).hide();
        $('.edit_preview').hide();
        $('#edit_clear_narrow').hide();
        $('#edit_clear_narrower').hide();
    });
});
$('#edit_profile_img,#edit_profile_img_narrow,#edit_profile_img_narrower').on('change', function(e) {
    var reader = new FileReader();
    reader.onload = function(e) {
        file_name = $(".editing_profile_img").attr('src', e.target.result).file_name();
    }
    reader.readAsDataURL(e.target.files[0]);
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
$(document).on('click', '.post_modal', function() {
    //背景をスクロールできないように　&　スクロール場所を維持
    scroll_position = $(window).scrollTop();
    $('body').addClass('fixed').css({ 'top': -scroll_position });
    // モーダルウィンドウを開く
    $('.post_process').fadeIn();
    $('.modal_post').fadeIn();
});

$(document).on('click', '.prof_modal', function() {
    //背景をスクロールできないように　&　スクロール場所を維持
    scroll_position = $(window).scrollTop();
    $('body').addClass('fixed').css({ 'top': -scroll_position });
    // モーダルウィンドウを開く
    $('.slide_prof').fadeIn();
    $('.modal_prof').fadeIn();
    $('.slide_prof').addClass('open');
});

$(document).on('click', ".prof_close", function() {
    $('body').removeClass('fixed').css({ 'top': 0 });
    window.scrollTo(0, scroll_position);
    $('.slide_prof').fadeOut();
    $('.modal_prof').fadeOut();
    $('.slide_prof').removeClass('open');
});

// // 各種ツールチップ処理
// $('[data-toggle="favorite"]').tooltip();
// $('[data-toggle="post"]').tooltip();
// $('[data-toggle="edit"]').tooltip();
// $('[data-toggle="delete"]').tooltip();
// $('[data-toggle="reply"]').tooltip();