function insertCodeBlock(containerClassName){
  var val = $('.' + containerClassName).val();
  //中身が空じゃないときは改行コードを入れる
  if (!val == "" ) {
    $('.' + containerClassName).val($('.' + containerClassName).val() + '\n');
  }

  $('.' + containerClassName).val($('.' + containerClassName).val()
    + '<pre>\n'
    + '<code>\n'
    + '\n'
    + '</code>\n'
    + '</pre>');
}

function insertCitationBlock(containerClassName){
  var val = $('.' + containerClassName).val();
  //中身が空じゃないときは改行コードを入れる
  if (!val == "" ) {
    $('.' + containerClassName).val($('.' + containerClassName).val() + '\n');
  }

  $('.' + containerClassName).val($('.' + containerClassName).val()
    + '<blockquote>\n'
    + '<p>\n'
    + '\n'
    + '</p>\n'
    + '</blockquote>');
}

function makeHtmlForArticle(gzSrc){
  return "<img style='max-width: 100%; margin : 1%;' src='"
      + gzSrc
      + "'>";

}

function insertGzHtmlIntoArticle(gzHtml, containerClassName){
  var val = $('.' + containerClassName).val();
  //中身が空じゃないときは改行コードを入れる
  if (!val == "" ) {
    $('.' + containerClassName).val($('.' + containerClassName).val() + '\n');
  }

  $('.' + containerClassName).val($('.' + containerClassName).val() + gzHtml);
}

function addEventListenerToImg(){
  //画像を全部挿入し終わってからイベントリスナーをつける
  $('img').click(function(){
    if($('input[name=q1]:checked').val() == 'content'){
      insertGzHtmlIntoArticle(makeHtmlForArticle(this.src), "articleContent");
    }else if($('input[name=q1]:checked').val() == 'thumbnail'){
      var url = this.src;
      var splittedUrl = url.split('/');
      $('#thumbnail').val(splittedUrl[splittedUrl.length - 1]);
    }else{

    }
  })
}

function uploadArticle(){
  var id = $('.articleId').val();
  var title = $('.articleTitle').val();
  var thumbnail = $('.articleThumbnail').val();
  var categories = [];
  var content = $('.articleContent').val();
  var csrf = $('input[name=_csrfToken]').val();

  var json = {
    "id" : id,
    "title" : title,
    "thumbnail" : thumbnail,
    "categories" : categories,
    "content" : content
  }

  $('.articleCategories').find('input').each(function(){
    categories.push($(this).val());
  });

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
      url: "http://" + location.hostname + "/articles/uploadArticle/" + id,
      data: json,
      success: function(data,dataType)
      {
        alert("成功");
      },
      /**
       * Ajax通信が失敗した場合に呼び出されるメソッド
       */
      error: function(XMLHttpRequest, textStatus, errorThrown)
      {
        // alert('Error : ' + errorThrown + '\n'
        //   + 'textStatus : ' + textStatus + '\n'
        //   + 'XMLHttpRequest : ' + XMLHttpRequest.status
        // );

        alert("コンテンツ取得時にエラーが発生しました。");
      }
  });


}

$(document).ready(function(e)
{
  //uploadPictureのためのグローバルメソッド
  callbackForLoad = function(){
    addEventListenerToImg();
  };

  $('.addCode').click(function(){
    insertCodeBlock('articleContent');
  });

  $('.addCitation').click(function(){
    insertCitationBlock('articleContent');
  });

  $('.addCategory').click(function(){
    alert("hello");
  });

  $('.plusCategory').click(function(){
    alert("a");
  });

  $('.uploadArticle').click(function(){
    uploadArticle();
  });


});
