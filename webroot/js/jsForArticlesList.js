/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  var inputJson = {};
  var url = '/articles/index';
  getJsonAndInsertHtmlForArticleList(inputJson, url, 'articleList');
});
