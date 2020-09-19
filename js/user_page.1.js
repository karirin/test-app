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

$(document).on('click','.favorite_btn',function(e){
    e.stopPropagation();
    var $this = $(this),
        page_id = get_param('page_id'),
        post_id = get_param('procode');
        //prev()は$thisの直前にあるhtml要素を取得する
        //val()は取得したいhtml要素のvalue値を取得する
        //page_idはユーザーのID
    $.ajax({
        type: 'POST',
        url: '../ajax_post_favorite_process.php',
        dataType: 'json',
        data: { page_id: page_id,
                post_id: post_id}
    }).done(function(data){
      // php側でエラーが発生したらリロードしてエラーメッセージを表示させる
      if(data ==="error"){
        location.reload();
      }else{
        // アイコンを切り替える
        
      }
    }).fail(function() {
      location.reload();
    });
  });

  $(document).on('click','.follow_btn',function(e){
    e.stopPropagation();
    var $this = $(this),
      followed_id = get_param('staffcode'),
      follow_id = $this.prev().val();
      //prev()は指定した$thisの直前にあるHTML要素を取得する

    $.ajax({
        type: 'POST',
        url: '../ajax_follow_process.php',
        dataType: 'json',
        data: { followed_id: followed_id,
                follow_id: follow_id}
    }).beforeSend(function(xhr) {
      xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
    // 追加 END
    })
    .done(function(data){
      // php側の処理に合わせてボタンを更新する
      // php側でエラーが発生したらリロードしてエラーメッセージを表示させる
      if(data === "error"){
        location.reload();
      }else if(data['action'] ==="登録"){
        $this.toggleClass('following')
        $this.text('フォロー中');
      }else if(data['action'] ==="解除"){
        $this.removeClass('following');
        $this.removeClass('unfollow')
        $this.text('フォロー');
      }
      // プロフィール内のカウントを更新する
      $follow_count.text(data['follow_count']);
      $follower_count.text(data['follower_count']);
    }).fail(function() {
      location.reload();
    });
  });

  $(document).on('click','.edit_btn',function(){
    $('.profile_comment').replaceWith('<textarea class="edit_comment border_white" type="text">');
    $('.btn_flex').css('display','flex');
  });

  $(document).on('click','.profile_save',function(e){
    e.stopPropagation();
      var comment_data = $('.edit_comment').val(),
          user_id = get_param('staff_code');
    $.ajax({
      type: 'POST',
      url: '../ajax_edit_profile.php',
      dataType: 'json',
      data: {comment_data: comment_data,
             user_id: user_id}
    })
    .done(function(data){
      // エラーメッセージがあれば表示

    }).fail(function(){
      location.reload();
    });
  });
  $('.profile_save').on('click',function(e){
    e.stopPropagation();
    var name_data = $('.profile .edit_name').val() || $('.slide_prof .edit_name').val() || '',
        comment_data = $('.profile .edit_comment').val() || $('.slide_prof .edit_comment').val() || '',
        icon_data = $('.profile_icon > img').attr('src'),
        user_id = $(this).data('user_id');

    $.ajax({
      type: 'POST',
      url: 'ajax_edit_profile.php',
      dataType: 'json',
      data: {name_data: name_data,
             comment_data: comment_data,
             icon_data: icon_data,
             user_id: user_id}