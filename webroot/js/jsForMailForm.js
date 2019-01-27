/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  $('.sendMail').click(function(){
    var name = $('.mailName').val();
    var title = $('.mailTitle').val();
    var content = $('.mailContent').val();
    var inputJson = {
      'name' : name,
      'title' : title,
      'content' : content
    };
    var url = '/articles/sendMail';
    var callback = new Callback();
    callback.callback = function(){
      alert('管理者にメールが送信されました');
    }
    getJsonAndDoSomething(inputJson, url, callback);
  });
});
