function loadArticles(containerClassName, callback){
  //$('.' + containerClassName).empty();
  var csrf = $('input[name=_csrfToken]').val();
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
      url: "http://" + location.hostname + "/articles/index",
      success: function(data,dataType)
      {
        //alert("success");
        insertHtmlForArticleList(containerClassName, data)
        //makeJsonToHtmlGzList(data, containerClassName);
        //callbackが定義されていない場合は実行しない。
        if(typeof callback == 'function') {
          callback();
        }else{
          console.log("callbackForLoadが定義されていません");
        }
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
  return '<div class="col-sm-4 mb-1">'
    + '<div class="card mb-3" style="max-width: 25rem;">'
    + '<a href="/articles/post/' + article.id + '">'
    + '<img class="card-img-top" src="/img/uploaded/' + article.thumbnail + '">'
    + '</a>'
    + '<div class="card-body text-center">'
    + '<span>' + article.title + '</span>'
    + '</div>'
    + '<div class="card-footer text-center" style="font-size:11px; background-color:#ffffff">'
    + '<span>' + article.upd_ymd + '</span>'
    + '</div>'
    + '</div>'
    + '</div>'
    ;
}

/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  loadArticles('articleList');
});
