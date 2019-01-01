function addEventListenerToImg(){
  //画像を全部挿入し終わってからイベントリスナーをつける
  $('img').click(function(){
    var url = this.src;
    var splittedUrl = url.split('/');
    $('#thumbnail').val(splittedUrl[splittedUrl.length - 1]);
  })
}

$(document).ready(function(e)
{
  //uploadPictureのためのグローバルメソッド
  callbackForLoad = function(){
    addEventListenerToImg();
  };

});
