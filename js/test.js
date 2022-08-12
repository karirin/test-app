window.onload = function() {
    // テストケースが優先度によって色が変わるようにする
    console.log($('.priority .priority_input')[0].value);
    for (i = 0; i < $('.priority').length; i++) {
        console.log(i);
        console.log($('.priority').length);
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

        if ($($target_modal).prev().css('display') == 'none') {
            $($target_modal)[0].setAttribute("style", "display:inline-block;width: 88%;");
            $($target_modal).prev().animate({ width: 'toggle' }, 'slow');
            $($target_modal).prev().css('display', 'inline-block');
            $($target_modal + ' .testcase_text').css('width', '79%');
        } else {
            $($target_modal).prev().animate({ width: 'toggle' }, 'slow');
            $($target_modal).prev().css('display', 'inline-block');
            $($target_modal + ' .testcase_text').css('width', '83%');
            $($target_modal)[0].setAttribute("style", "display:inline-block;width: 100%;");
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

// テストケースの詳細画面表示
$(document).on('dblclick', '.priority', function() {
    var $target_modal = $(this).data("target"),
        test_id = $target_modal.substring(10),
        $user_id = $('' + $target_modal + ' .priority_user_id')[0].value,
        $post_user_id = $('' + $target_modal + ' .post_user_id')[0].value,
        $current_user_id = $('' + $target_modal + ' .user_id')[0].value;
    $('.testcase_disp').fadeIn();
    $('.modal_testcase').fadeIn();
    $('.testcase_clear').fadeIn();
    if ($current_user_id == $user_id) {
        $('.testcase_disp .testcase_text').replaceWith('<span class="testcase_text">' + $($target_modal + ' > span')[0].textContent + '</span>');
    } else {
        $('.testcase_disp .testcase_text').replaceWith('<span class="testcase_text" style="pointer-events: none">' + $($target_modal + ' > span')[0].textContent + '</span>');
    }
    if ($current_user_id == $post_user_id) {
        $('.testcase_disp #priority').fadeIn();
    }
    $('.testcase_disp .test_user_img')[0].setAttribute('src', $($target_modal + ' > .test_user_info > span > img')[0].getAttribute('src'));
    $('.testcase_disp .testcase_created_at').replaceWith('<span class="testcase_created_at">' + $($target_modal + ' > .test_user_info > .created_at')[0].textContent + '</span>');
    $('.testcase_disp .testcase_name').replaceWith('<span class="testcase_name">' + $($target_modal + ' > .test_user_info > span > .testcase_name')[0].textContent + '</span>');
    $('.testcase_disp .testcase_id').replaceWith('<input class="testcase_id" type="hidden" value="' + test_id + '">');
    $(document).on('click', '.testcase_clear', function() {
        $('.testcase_disp').fadeOut();
        $('.modal_testcase').fadeOut();
        $('.testcase_clear').fadeOut();
    });
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
                test_text: edit_test_text
            }
        }).done(function() {
            $('#edit_testcase_' + $test_id).replaceWith('<span class="testcase_text">' + edit_test_text + '</span>');
            $('#testcase_' + $test_id + ' .testcase_text').replaceWith('<span class="testcase_text">' + edit_test_text + '</span>');
            $('.testcase_disp .testcase_clear')[0].disabled = false;
            $('.testcase_error').fadeOut();
        }).fail(function() {});
    });
});