/********************************************************************************************
*カテゴリーから記事を取得
*********************************************************************************************/
function searchByCategory(word){
  var inputJson = {
    'word' : word
  }
  var url = '/articles/getContentByCategory';
  getJsonAndInsertHtmlForArticleList2(inputJson, url, 'articleList2');
  insertSearchTitleIntoArticleList('searchResult');
}

/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  $('.articleCategory').click(function(){
    searchByCategory($(this).text());
  })

});
