function loadArticles(containerClassName,url,word){
  $('.' + containerClassName).empty();
  var csrf = $('input[name=_csrfToken]').val();
  var json = {
    'word' : word
  }

  /**
   * Ajax通信メソッド
   * @param type  : HTTP通信の種類
   * @param url   : リクエスト送信先のURL
   * @param data  : サーバに送信する値
   */
  $.ajax({
      type: 'POST',
      beforeSend: function(xhr){
        xhr.setRequestHeader('X-CSRF-Token', csrf);
      },
      datatype:'json',
      data : json,
      url: "http://" + location.hostname + url,
      success: function(data,dataType)
      {
        insertHtmlForArticleList(containerClassName, data);
        //スクロール時に記事一覧をフェードインさせる処理
        $(window).scroll(function(){
          $('.cardWrapper').each(function(i){
            var bottom_of_object = $(this).position().top + ($(this).outerHeight()/2);
            var bottom_of_window = $(window).scrollTop() + $(window).height();
            /* If the object is completely visible in the window, fade it it */
            if( bottom_of_window > bottom_of_object ){
                $(this).animate({'opacity':'1'},500);
            }
          });
        });

      },
      /**
       * Ajax通信が失敗した場合に呼び出されるメソッド
       */
      error: function(XMLHttpRequest, textStatus, errorThrown)
      {
        alert('Error : ' + errorThrown + '\n'
          + 'textStatus : ' + textStatus + '\n'
          + 'XMLHttpRequest : ' + XMLHttpRequest.status
        );
      }
  });

}

function insertHtmlForArticleList(containerClassName, jsonData){
  for(var i in jsonData){
    $('.' + containerClassName).append(
      makeHtmlForArticleList(jsonData[i])
    );
  }
}

function makeHtmlForArticleList(article){
  return '<div class="col-sm-4 mb-1 cardWrapper" style="opacity : 0;">'
    + '<div class="card mb-3" style="max-width: 25rem;">'
    + '<a href="/articles/post/' + article.id + '">'
    + '<img class="card-img-top" src="/img/uploaded/' + article.thumbnail + '">'
    + '</a>'
    + '<div class="card-body text-center">'
    + '<span>' + article.title + '</span>'
    + '</div>'
    + '<div class="card-footer text-center" style="font-size:11px; background-color:#ffffff">'
    + '<span>' + sampleDate(new Date(article.upd_ymd),'YYYY/MM/DD') + '</span>'
    + '</div>'
    + '</div>'
    + '</div>'
    ;
}

function sampleDate(date, format) {

    format = format.replace(/YYYY/, date.getFullYear());
    format = format.replace(/MM/, date.getMonth() + 1);
    format = format.replace(/DD/, date.getDate());

    return format;
}

/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  loadArticles('articleList','/articles/index');
});
