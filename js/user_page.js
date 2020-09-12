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

  //いいね機能実装中