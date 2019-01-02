function loadPictures(containerClassName, callback){
  $('.' + containerClassName).empty();
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
        makeJsonToHtmlGzList(data, containerClassName);

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

function uploadPictures(callback){
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
        callback();
      },
      /**
       * Ajax通信が失敗した場合に呼び出されるメソッド
       */
      error: function(XMLHttpRequest, textStatus, errorThrown)
      {
        alert('ErrorCode : ' + XMLHttpRequest.status + '\n'
          + 'textStatus : ' + textStatus + '\n'
          + 'Error : ' + XMLHttpRequest.responseText
        );
      }
  });

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

$(document).ready(function(){
  //画像のロード。callbackForLoadは外部ファイルで定義しなければならない。
  //callbackが定義されていない場合は実行しない。
  if(typeof callbackForLoad == 'function') {
    loadPictures('uploadedList',callbackForLoad);
  }else{
    loadPictures('uploadedList');
  }


  /**
  * 送信ボタンクリック
  */
  $('.uploadPictures').click(function()
  {
    if(typeof callbackForLoad == 'function') {
      uploadPictures(function(){loadPictures('uploadedList',callbackForLoad)});
    }else{
      uploadPictures(function(){loadPictures('uploadedList')});
    }

    return false;
  });

});
