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

  //スクロール
  var height = $('.navbar').height();
  $("html,body").animate({scrollTop:(height*2.5)});
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
