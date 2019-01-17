/********************************************************************************************
*削除チェック
*********************************************************************************************/
function deleteCheck(id){
  var res = confirm("削除しますか");
    if( res == true ) {
      //var csrf = $('input[name=_csrfToken]').val();
      var inputJson = {
        "id" : id
      }
      var url = '/articles/delete';
      var callback = new Callback();
      callback.callback = function(){
        alert("削除されました");
        window.location.reload();
      }
      getJsonAndDoSomething(inputJson, url, callback);
    }
    else {
        return false;
    }
}

/********************************************************************************************
*各種ボタンにイベントリスナー追加
*********************************************************************************************/
$(document).ready(function(e)
{
  $('.delete').click(function(){
    //console.log("id is " + $(this).find('input').val());
    deleteCheck($(this).find('input').val());
  });

});
