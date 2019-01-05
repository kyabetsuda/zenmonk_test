/*
*削除チェック
*/
function deleteCheck(id){
  var res = confirm("削除しますか");
    if( res == true ) {
      var csrf = $('input[name=_csrfToken]').val();

      var json = {
        "id" : id
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
          url: "http://" + location.hostname + "/articles/delete",
          data: json,
          success: function(data,dataType)
          {
            alert("削除されました");
            window.location.reload();
          },
          /**
           * Ajax通信が失敗した場合に呼び出されるメソッド
           */
          error: function(XMLHttpRequest, textStatus, errorThrown)
          {
            alert("エラーが発生しました。");
          }
      });

    }
    else {
        return false;
    }
}

/*
*各種ボタンにイベントリスナー追加
*/
$(document).ready(function(e)
{

  $('.delete').click(function(){
    //console.log("id is " + $(this).find('input').val());
    deleteCheck($(this).find('input').val());
  });

});
