window.onload = function() {
    // テストケースが優先度によって色が変わるようにする
    for (i = 0; i < $('.priority').length; i++) {
        switch ($('.priority .priority_input')[i].value) {
            case "A":
                $('.priority')[i].setAttribute("style", 'background-color: #b2cdff;');
                break;

            case "B":
                $('.priority')[i].setAttribute("style", 'background-color: #dce8fe;');
                break;

            case "C":
                break;
            default:
        }
        if ($('.priority .progress_input')[i].value == '完了') {
            $('.priority')[i].setAttribute("style", 'background-color: #a49e9e;');
        }
    }
    console.log(location.search.substring(11));
    switch (location.search.substring(11)) {
        case "all":
            $('.post_tab').removeClass('active');
            $('.post_tab.all').addClass('active');
            break;

        case "my_post":
            $('.post_tab').removeClass('active');
            $('.post_tab.my_post').addClass('active');
            break;

        case "testcase":
            console.log('testqqqq');
            $('.post_tab').removeClass('active');
            $('.post_tab.testcase').addClass('active');
            break;
        default:
    }

    // 余分なタグが無い場合は(+)ボタンを非表示に
    if ($('.skill_tag.extra')[0] == undefined) {
        $('.skill_btn')[0].setAttribute('style', 'display:none;');
    }
    if ($('.licence_tag.extra')[0] == undefined) {
        $('.licence_btn')[0].setAttribute('style', 'display:none;');
    }
}

/// 長押しを検知する閾値
var LONGPRESS = 500;
/// 長押し実行タイマーのID
var timerId;

/// 長押し・ロングタップを検知する
$(document).on("mousedown touchstart", '.priority', function() {
    var $target_modal = $(this).data("target");
    timerId = setTimeout(function() {
        var test_id = $($target_modal)[0].id.slice(9),
            delete_group_flg = 1;
        // $($target_modal)[0].setAttribute("style", "display:inline-block;width: 81%;");
        // $($target_modal).prev().animate({ width: 'toggle' }, 'slow');
        // $($target_modal).prev().css('display', 'inline-block');
        // $($target_modal + ' .testcase_text').css('width', '79%');
        if ($($target_modal).prev().prev().css('display') == 'none') {
            $($target_modal).animate({ width: '587px' }, 'slow');
            $($target_modal + ' .testcase_text').animate({ width: '76%' }, 'slow');
            $($target_modal).animate({ height: '45px' }, 'slow');
            $($target_modal).prev().prev().animate({ width: 'toggle' }, 'slow');
            $($target_modal).prev().prev().css('display', 'inline-block');
        } else {
            $($target_modal).animate({ width: '630px' }, 'slow');
            $($target_modal + ' .testcase_text').animate({ width: '77%' }, 'slow');
            $($target_modal).prev().prev().animate({ width: 'toggle' }, 'slow');
            $($target_modal).prev().prev().css('display', 'inline-block');
        }
        // if ($($target_modal).prev()[0].style.display == 'inline-block') {
        //     $($target_modal + ' .testcase_text').css('width', '83%');
        //     console.log("test");
        // }
        /// 長押し時（Longpress）のコード
        // $.ajax({
        //     type: 'POST',
        //     url: '../ajax_edit_memo.php',
        //     dataType: 'text',
        //     data: {
        //         group_id: group_id,
        //         group_max_id: group_max_id,
        //         delete_group_flg: delete_group_flg
        //     }
        // }).done(function() {
        //     $($target_modal)[0].style.display = 'none';
        // }).fail(function() {});
    }, LONGPRESS);
}).on("mouseup mouseleave touchend", function() {
    //alert("test");
    clearTimeout(timerId);
});

$(document).on('click', '.comment_btn', function() {
    $('.comment').fadeIn().css('display', 'flex');
});

// テストケースの詳細画面表示
$(document).on('dblclick', '.priority', function() {
    var $target_modal = $(this).data("target"),
        $test_id = $target_modal.substring(10),
        $user_id = $('' + $target_modal + ' .priority_user_id')[0].value,
        $post_user_id = $('' + $target_modal + ' .post_user_id')[0].value,
        $test_priority = $('#testcase_' + $test_id).prev()[0].textContent,
        $test_progress = $('#testcase_' + $test_id + ' .priority_input')[0].value,
        $current_user_id = $('' + $target_modal + ' .user_id')[0].value;
    $('.testcase_disp').fadeIn();
    $('.modal_testcase').fadeIn();
    $('.testcase_clear').fadeIn();
    if ($current_user_id == $user_id) {
        $('.testcase_disp .testcase_text').replaceWith('<span class="testcase_text">' + $($target_modal + ' > span')[0].textContent + '</span>');
        $('.t_btn').fadeOut();
    } else {
        $('.testcase_disp .testcase_text').replaceWith('<span class="testcase_text" style="pointer-events: none">' + $($target_modal + ' > span')[0].textContent + '</span>');
        $('.t_btn').fadeIn();
    }
    if ($current_user_id == $post_user_id) {
        $('.testcase_disp #priority').fadeIn();
        $('.testcase_disp #progress').fadeIn();
    }
    $('.testcase_disp .test_user_img')[0].setAttribute('src', $($target_modal + ' > .test_user_info > a > span >.test_user_img')[0].getAttribute('src'));
    $('.testcase_disp .testcase_created_at').replaceWith('<span class="testcase_created_at">' + $($target_modal + ' > .test_user_info > .created_at')[0].textContent + '</span>');
    $('.testcase_disp .testcase_name').replaceWith('<span class="testcase_name">' + $($target_modal + ' > .test_user_info > a > span > .testcase_name')[0].textContent + '</span>');
    $('.testcase_disp .testcase_id').replaceWith('<input class="testcase_id" type="hidden" value="' + $test_id + '">');
    // セレクトボックスの初期値を指定
    $("#priority option[value='" + $test_priority + "']").prop('selected', true);
    $("#progress option[value='" + $test_progress + "']").prop('selected', true);
    $(document).on('click', '.testcase_clear', function() {
        $('.testcase_disp').fadeOut();
        $('.modal_testcase').fadeOut();
        $('.testcase_clear').fadeOut();
    });
    // $('.testcase_disp .if_comment').replaceWith('<?php if($comments==0) ?>');
    // $('.testcase_disp .end_comment').replaceWith('<?php endif; ?>');
});

// テストケースの必須チェック
$(document).on('click', '.testcase_btn', function() {
    if ($('#priority').val() == '' && $('#test_process_counter')[0].value == '') {
        $('#priority')[0].setAttribute("style", "border-color: #dc3545;");
        $('#test_process_counter')[0].setAttribute("style", "border-color: #dc3545;");
        $('.priority_error').fadeIn();
        $('.testcase_error').fadeIn();
        return false;
    } else if ($('#priority').val() == '') {
        $('#priority')[0].setAttribute("style", "border-color: #dc3545;");
        $('.priority_error').fadeIn();
        return false;
    } else if ($('#test_process_counter')[0].value == '') {
        $('#test_process_counter')[0].setAttribute("style", "border-color: #dc3545;");
        $('.testcase_error').fadeIn();
        return false;
    }
});

// テストケース必須チェック解除
$(document).ready(function() {
    $('#priority').change(function() {
        var str = $(this).val();
        if (str.search(/[A-C]/g) != -1) {
            $('#priority')[0].setAttribute("style", "border-color: #ced4da;");
            $('.priority_error').fadeOut();
        }
    });

    $('#test_process_counter').change(function() {
        var str = $(this).value;
        if (str != '') {
            $('#test_process_counter')[0].setAttribute("style", "border-color: #ced4da;");
            $('.testcase_error').fadeOut();
        }
    });
});

// テスト投稿の必須チェック
$(document).on('click', '.post_process_btn', function() {
    if ($('.url_form').val() == '' && $('.test_form')[0].value == '') {
        $('.url_form')[0].setAttribute("style", "border-color: #dc3545;");
        $('.test_form')[0].setAttribute("style", "border-color: #dc3545;");
        $('.post_url_error').fadeIn();
        $('.post_text_error').fadeIn();
        return false;
    } else if ($('.url_form').val() == '') {
        $('.url_form')[0].setAttribute("style", "border-color: #dc3545;");
        $('.post_url_error').fadeIn();
        return false;
    } else if ($('.test_form')[0].value == '') {
        $('.test_form')[0].setAttribute("style", "border-color: #dc3545;");
        $('.post_text_error').fadeIn();
        return false;
    }
});

// テストケース入力処理
$(document).on('click', '.testcase_disp .testcase_text', function() {
    var $test_id = $('.testcase_disp .testcase_id')[0].value,
        $test_text = $('.testcase_disp .testcase_text')[0].textContent;
    $(this).replaceWith('<textarea type="text" name="text" id="edit_testcase_' + $test_id + '" class="edit_testcase" style="width: 100%;">' + $test_text);
    $('#edit_testcase_' + $test_id).on('mouseout', function(e) {
        e.stopPropagation();
        var edit_test_text = $('#edit_testcase_' + $test_id).val();
        if (edit_test_text == '') {
            $('#edit_testcase_' + $test_id)[0].setAttribute("style", "border-color: #dc3545;border-style: solid;width: 100%;");
            $('.testcase_disp .testcase_error').fadeIn();
            $('.testcase_disp .testcase_clear')[0].disabled = true;
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '../ajax_edit_test.php',
            dataType: 'text',
            data: {
                test_id: $test_id,
                test_text: edit_test_text,
                disp_flg: 1
            }
        }).done(function() {
            $('#edit_testcase_' + $test_id).replaceWith('<span class="testcase_text">' + edit_test_text + '</span>');
            $('#testcase_' + $test_id + ' .testcase_text').replaceWith('<span class="testcase_text">' + edit_test_text + '</span>');
            $('.testcase_disp .testcase_clear')[0].disabled = false;
            $('.testcase_error').fadeOut();
        }).fail(function() {});
    });
});

// 選択した進捗度によってテストケースの色を変更
$(document).on('change', '.testcase_disp #priority', function() {
    var $test_val = $('.testcase_disp #priority')[0].value,
        $test_id = $('.testcase_disp .testcase_id')[0].value,
        $test_progress = $('#testcase_' + $test_id).prev();
    $.ajax({
        type: 'POST',
        url: '../ajax_edit_test.php',
        dataType: 'text',
        data: {
            test_id: $test_id,
            test_val: $test_val,
            select_flg: 1
        }
    }).done(function() {
        $test_progress.replaceWith('<span class="progress">' + $test_val + '</span>');
        // 選択した進捗度によってテストケースの色を変更
        if ($test_val == '完了') {
            $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: #a49e9e;');
        } else {
            switch ($('.testcase_disp #progress')[0].value) {
                case "A":
                    $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: #b2cdff;');
                    break;

                case "B":
                    $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: #dce8fe;');
                    break;

                case "C":
                    $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: whitesmoke;');
                    break;

                default:
            }
        }
    });
});

// 選択した優先度によってテストケースの色を変更
$(document).on('change', '.testcase_disp #progress', function() {
    var $test_progres = $('.testcase_disp #progress')[0].value,
        $test_id = $('.testcase_disp .testcase_id')[0].value,
        $test_priority = $('.testcase_disp #priority')[0].value;
    $.ajax({
        type: 'POST',
        url: '../ajax_edit_test.php',
        dataType: 'text',
        data: {
            test_id: $test_id,
            test_progress: $test_progres,
            progress_flg: 1
        }
    }).done(function() {
        if ($test_priority == '完了') {
            $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: #a49e9e;');
        } else {
            switch ($test_progres) {
                case "A":
                    $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: #b2cdff;');
                    break;

                case "B":
                    $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: #dce8fe;');
                    break;

                case "C":
                    $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: whitesmoke;');
                    break;
                default:
            }
        }
    });
});

$(document).on('click', '.t_btn', function() {
    $test_id = $('.testcase_disp .testcase_id')[0].value;
    $.ajax({
        type: 'POST',
        url: '../ajax_edit_test.php',
        dataType: 'text',
        data: {
            test_id: $test_id,
            t_flg: 1
        }
    }).done(function() {
        console.log($('#testcase_' + $test_id).next());
        $('#testcase_' + $test_id).next().fadeIn(1000);
    });
});

$(document).on('click', '.t_btn', function() {
    $test_id = $('.testcase_disp .testcase_id')[0].value;
    $.ajax({
        type: 'POST',
        url: '../ajax_edit_test.php',
        dataType: 'text',
        data: {
            test_id: $test_id,
            t_flg: 1
        }
    }).done(function() {
        $('#testcase_' + $test_id).next().fadeIn(1000);
    });
});

$('.skill_btn').on('click', function() {
    $('.skill_tag').fadeIn(1000);
    $('.skill_btn').off('click');
    $('.skill_btn').attr('class', 'fas fa-minus skill_btn_close');
    $('.skill_btn_close').on('click', function() {
        $('.skill_tag.extra').fadeOut(1000);
        $('.skill_btn_close').off('click');
        $('.skill_btn_close').attr('class', 'fas fa-plus skill_btn');
    });
});

$('.licence_btn').on('click', function() {
    $('.licence_tag').fadeIn(1000);
    $('.licence_btn').off('click');
    $('.licence_btn').attr('class', 'fas fa-minus licence_btn_close');
    $('.licence_btn_close').on('click', function() {
        $('.licence_tag.extra').fadeOut(1000);
        $('.licence_btn_close').off('click');
        $('.licence_btn_close').attr('class', 'fas fa-plus licence_btn');
    });
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
    $('.workhistory').replaceWith('<textarea class="edit_workhistory form-control" type="text" name="user_workhistory" >' + user_workhistory);
    $('.workhistory_narrow').replaceWith('<textarea class="edit_workhistory form-control" type="text" name="user_workhistory" >' + user_workhistory_narrow);
    $('.workhistory_narrower').replaceWith('<textarea class="edit_workhistory form-control" type="text" name="user_workhistory" >' + user_workhistory_narrower);
    $('.mypage').css('display', 'none');
    $('.edit_profile_img').css('display', 'inline-block');
    $('.btn_flex').css('display', 'flex');
    $('.profile').addClass('editing');
    $('.form').css('display', 'inline-block');
    $('.tag').fadeOut();
});