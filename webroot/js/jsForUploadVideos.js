function loadVideos(containerClassName, callback){
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
      url: "http://" + location.hostname + "/videos/load",
      success: function(data,dataType)
      {
        makeJsonToHtmlMvList(data, containerClassName);
        //callbackが定義されていない場合は実行しない。
        if(typeof callback == 'function') {
          callback();
        }else{
          console.log("callbackForMvLoadが定義されていません");
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

function uploadVideos(callback){
  // フォームデータを取得
  var form = $('#uploadVideos').get(0);
  var formData = new FormData( form );

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
      url: "http://" + location.hostname + "/videos/add",
      datatype:'json',
      contentType : false,
      processData : false,
      data: formData,
      success: function(data,dataType)
      {
        alert("Video was successfully uploaded");
        //callback();
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

function makeJsonToHtmlMvList(jsonData, containerClassName){

    var tmp = [];
    for(var i in jsonData){
      var rowDiv = $("<div></div>", {
        "class": "row"
      });

      tmp.push(makeDivForMvlist(makeImgHtmlForMvList(jsonData[i].thumbnail, jsonData[i].title)));

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

function makeDivForMvlist(mvHtml){
  return "<div class='col-sm-4 my-auto'>"
      + mvHtml
      + "</div>";
}

function makeImgHtmlForMvList(thumbnail,title){
  return "<div class='btn'><img name='" + title + "' class='mvThumbnail' style='max-width: 100%; margin : 1%;' src='/webroot/img/uploaded/"
      + thumbnail
      + "'></img>";
}

$(document).ready(function(){
  // 画像のロード。callbackForLoadは外部ファイルで定義しなければならない。
  // callbackが定義されていない場合は実行しない。
  if(typeof callbackForMvLoad == 'function') {
    loadVideos('uploadedMvList',callbackForMvLoad);
  }else{
    loadVideos('uploadedMvList');
  }


  /**
  * 送信ボタンクリック
  */
  $('.uploadVideos').click(function()
  {
    if(typeof callbackForLoad == 'function') {
      uploadVideos(function(){loadVideos('uploadedMvList',callbackForMvLoad)});
    }else{
      uploadVideos(function(){loadVideos('uploadedMvList')});
     }

    return false;
  });

});
