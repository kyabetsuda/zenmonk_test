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

});
