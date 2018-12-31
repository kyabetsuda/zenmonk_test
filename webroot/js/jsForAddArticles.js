function insertCodeBlock(containerClassName){
  var val = $('.' + containerClassName).val();
  //中身が空じゃないときは改行コードを入れる
  if (!val == "" ) {
    $('.' + containerClassName).val($('.' + containerClassName).val() + '\n');
  }

  $('.' + containerClassName).val($('.' + containerClassName).val()
    + '<pre>\n'
    + '<code>\n'
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
    + '</blockquote>');
}

function makeJsonToHtmlGzList(jsonData, containerClassName){

    var tmp = [];
    for(var i in jsonData){
      var rowDiv = $("<div></div>", {
        "class": "row"
      });

      tmp.push(makeDivForGzlist(makeImgHtmlForGzList(jsonData[i].title)));

      //要素が3の倍数個または最後の要素の場合はrowをappend
      if(i%3 == 2 | i==jsonData.length - 1){
        for(var j in tmp){
            rowDiv.append(tmp[j]);
        }
        $('.' + containerClassName).append(rowDiv);
        tmp = [];
      }
    }

}

function makeDivForGzlist(imgHtml){
  return "<div class='col-sm-4 my-auto'>"
      + imgHtml
      + "</div>";
}

function makeImgHtmlForGzList(title){
  return "<div class='btn'><img style='max-width: 100%; margin : 1%;' src='/webroot/img/uploaded/"
      + title
      + "'></div>";
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

function loadImg(){
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
      url: "http://" + location.hostname + "/Uplpictures/load",
      success: function(data,dataType)
      {
        makeJsonToHtmlGzList(data, 'uploadedList');

        //画像を全部挿入し終わってからイベントリスナーをつける
        $('img').click(function(){
          insertGzHtmlIntoArticle(makeHtmlForArticle(this.src), "articleContent");
        })
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

$(document).ready(function(e)
{
  //アップロード画像のロード
  loadImg();

  $('.addCode').click(function(){
    insertCodeBlock('articleContent');
  });

  $('.addCitation').click(function(){
    insertCitationBlock('articleContent');
  });
  /**
  * 送信ボタンクリック
  */
  $('.uploadPictures').click(function()
  {
    // フォームデータを取得
    var formdata = new FormData($('#uploadPictures').get(0));
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
        url: "http://" + location.hostname + "/Uplpictures/add",
        data: formdata,
        cache       : false,
        contentType : false,
        processData : false,
        dataType    : "html",
        success: function(data,dataType)
        {
          alert("image was successfully uploaded");
          $('.uploadedList').empty();
          loadImg();
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

    return false;

  });
});
