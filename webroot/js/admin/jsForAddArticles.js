/********************************************************************************************
*変数定義
*********************************************************************************************/
//動画パス
var mvSrc = "/mv/videos/";

//画像パス
var gzSrc = "";

//uploadPictureのためのグローバルメソッド
callbackForLoad = function(){
  addEventListenerToImg();
};

//uploadVideosのためのグローバルメソッド
callbackForMvLoad = function(){
  addEventListenerToImgForMv()
};

/********************************************************************************************
*各種挿入用
*********************************************************************************************/
//コードブロックの挿入
function insertCodeBlock(containerClassName){
  var block = '<pre>\n'
      + '<code>\n'
      + '\n'
      + '</code>\n'
      + '</pre>';

  insertAtCaret(containerClassName,block);

}

//引用ブロックの挿入
function insertCitationBlock(containerClassName){
  var block = '<blockquote>\n'
  + '<p>\n'
  + '\n'
  + '</p>\n'
  + '</blockquote>';

  insertAtCaret(containerClassName,block);

}

//見出しの挿入
function insertHeading(containerClassName){
  var heading = '<h3 class="heading" id=""></h3>'

  insertAtCaret(containerClassName,heading);
}

//目次の挿入
function insertToc(containerClassName){
  var toc = '<div id="toc_container">\n'
  + '<p class="toc_title">\n'
  + ' 目次\n'
  + '</p>\n'
  + '<ul class="toc_list">\n'
  + '<li><a href="#"></a></li>\n'
  + '</ul>\n'
  + '</div>'

  insertAtCaret(containerClassName,toc);
}

//Hrefの挿入
function insertHref(containerClassName){
  var href = '<a href=""></a>'

  insertAtCaret(containerClassName,href);
}

//Hrefの挿入
function insertSmallHref(containerClassName){
  var href = '<a href="" style="font-size:1.5vh"></a>'

  insertAtCaret(containerClassName,href);
}

//文字色の挿入
function insertColorFont(containerClassName, color){
  var span = '<span style="color:' + color + '"></span>'

  insertAtCaret(containerClassName,span);
}

//中央揃えの文字の挿入
function insertCenteredFont(containerClassName){
  var span = '<div style="display: flex; justify-content: center;">\n'
    + '\n'
    + '</div>'

  insertAtCaret(containerClassName,span);
}

//記事の引用を挿入する
function insertArticleCitation(id, containerClassName){
  var inputJson = {
    'no' : id
  };
  var url = '/articles/getPost'
  var callback = new Callback();
  callback.callback = function(){
    console.log(this.result);
    var citation ='<a href="/articles/post/' + this.result.id + '">'
      + '<div style="width:100%; border: 1px solid #dcdcdc; overflow:hidden">'
      + '<br>'
      + '<img src="/img/uploaded/' + this.result.thumbnail + '" style="float:left; margin:10px; max-height:15vh; width:auto"/>'
      + '<div class="mr-3 ml-3">'
      + '<h6 style="font-weight:bold; text-decoration:underline">' + this.result.title + '</h6>'
      + '<div class="">' + getFirstSentenceFromStr(this.result.content) + '</div>'
      + '</div>'
      + '<br>'
      + '</div>'
      + '</a>'
      ;

    insertAtCaret(containerClassName, citation);
  };

  getJsonAndDoSomething(inputJson, url, callback);
}

/********************************************************************************************
*画像にイベントリスナーを追加する
*********************************************************************************************/
//画像挿入ようHTML作成
function makeGzHtmlForArticle(gzSrc){
  return "<img class='mx-auto d-block' style='max-width: 100%; margin : 1%;' src='"
      + gzSrc
      + "'>";
}

//画像HTML挿入
function insertGzHtmlIntoArticle(gzHtml, containerClassName){
  insertAtCaret(containerClassName,gzHtml);
}

//画像リストにイベントリスナーを追加する
function addEventListenerToImg(){
  //画像を全部挿入し終わってからイベントリスナーをつける
  $('.pictThumbnail').click(function(){
    if($('input[name=q1]:checked').val() == 'content'){
      insertGzHtmlIntoArticle(makeGzHtmlForArticle(this.src), "articleContent");
    }else if($('input[name=q1]:checked').val() == 'thumbnail'){
      var url = this.src;
      var splittedUrl = url.split('/');
      $('#thumbnail').val(splittedUrl[splittedUrl.length - 1]);
    }else{

    }
  })
}

/********************************************************************************************
*動画にイベントリスナーを追加する
*********************************************************************************************/
//動画リストにイベントリスナーを追加する
function addEventListenerToImgForMv(){
  //画像を全部挿入し終わってからイベントリスナーをつける
  $('.mvThumbnail').click(function(){
      insertMvHtmlIntoArticle(makeMvHtmlForArticle(mvSrc,$(this).attr('name')), "articleContent");
  });
}

//動画挿入用HTML作成
function makeMvHtmlForArticle(mvSrc,title){
  return "<video class='mx-auto d-block' style='max-width: 100%; margin : 1%;' src='"
      + mvSrc + title
      + "' controls></video>";
}

//動画HTML挿入
function insertMvHtmlIntoArticle(mvHtml, containerClassName){
  insertAtCaret(containerClassName,mvHtml);
}


/********************************************************************************************
*記事のアップロード
*********************************************************************************************/
function uploadArticle(){
  var id = $('.articleId').val();
  var title = $('.articleTitle').val();
  var thumbnail = $('.articleThumbnail').val();
  var categories = [];
  var content = replaceHtmlInsideCodeWithEscape($('.articleContent').val()); //codeタグ内をhtmlエスケープ
  var draft = -1;

  //下書きが清書か判定する
  if($('input[name=q2]:checked').val() == 'draft'){
    draft = 1;
  }else if($('input[name=q2]:checked').val() == 'clean'){
    draft = 0;
  }
  var csrf = $('input[name=_csrfToken]').val();

  //カテゴリーを全て追加する
  $('.articleCategories').find('input').each(function(){
    //console.log($(this).val());
    categories.push($(this).val());
  });

  //記事をアップロードする
  var inputJson = {
    "id" : id,
    "title" : title,
    "thumbnail" : thumbnail,
    "categories" : categories,
    "content" : content,
    "draft" : draft
  }
  for(var i in categories){
    console.log(categories[i]);
  }
  var url = '/articles/uploadArticle';
  var callback = new Callback();
  callback.callback = function(){
    alert("成功");
  }
  getJsonAndDoSomething(inputJson, url, callback);
}

/********************************************************************************************
*新規カテゴリー追加
*********************************************************************************************/
//カテゴリー追加
function plusCategory(){
  var category = $('.plusedCategory').val();
  var inputJson = {
    "category" : category
  }
  var url = '/articles/plusCategory';
  var callback = new Callback();
  callback.callback = function(){
    alert("成功");
    $('#category_id').empty();
    for(var i in this.result){
      $('#category_id').append(
        makeOptionForCategories(this.result[i])
      );
    }
  }
  getJsonAndDoSomething(inputJson, url, callback);
}

//セレクトボックス挿入用の HTML 作成
function makeOptionForCategories(data){
  return '<option value="' + data.id + '">' + data.name + '</option>';
}

//記事にカテゴリーを追加する
function addCategoryToArticle(){
  var id = $('#category_id option:selected').val();
  var name = $('#category_id option:selected').text();
  var flg = true;

  //すでにカテゴリーがある場合はflg = false
  $('.articleCategories').find('input').each(function(){
    if($(this).val() == id){
      flg = false;
    }
  });

  if(flg){
    $('.articleCategories').append(makeBtnForCategory(id, name)).ready(function(){
      //callbackでクリックしたら削除を追加
      $('.articleCategory').click(function(){
        var inputId = searchCategoryFromName($(this).text());
        $(this).remove();
        //同時にinput要素も削除
        $('.articleCategories').find('input[value="' + inputId + '"]').remove();
      });
    });
  }
}

//カテゴリー名からカテゴリーIDを検索する
function searchCategoryFromName(name){
  var val = 0;
  $('#category_id').find('option').each(function(){
    if($(this).text() == name){
      console.log("hello");
      val = $(this).val();
    }
  });

  return val;
}

//カテゴリー追加ようのHTML作成
function makeBtnForCategory(id, name){
  return '<input type="hidden" value="' + id + '">'
   + '<div class="btn btn-outline-dark border articleCategory">' + name + '</div>'
}

//プレビュー用のHTML作成
function makeHtmlForPreview(content){
  return '<div style="max-width:100%">'
    + '<pre class="post">'
    + content
    + '</pre>'
    + '</div>'
    + '<script src="/js/jsForArticle.js"></script>';
}


/********************************************************************************************
*テキストエリアのカーソル位置に文字列挿入(http://d.hatena.ne.jp/spitfire_tree/20131209/1386575758)
*********************************************************************************************/
function insertAtCaret(target, str) {
  var obj = $('.' + target);
  obj.focus();
  //ブラウザがIEの場合
  if(navigator.userAgent.match(/MSIE/)) {
    var r = document.selection.createRange();
    r.text = str;
    r.select();
  //それ以外
  } else {
    var s = obj.val();
    var p = obj.get(0).selectionStart;
    var np = p + str.length;
    obj.val(s.substr(0, p) + str + s.substr(p));
    //挿入したテキストの最後にカーソルを合わせる
    obj.get(0).setSelectionRange(np, np);
  }
}

/********************************************************************************************
*codeタグ内のhtmlをエスケープする
*********************************************************************************************/
function replaceHtmlInsideCodeWithEscape(str){
  return str.replace(/(<code.*>)([\s\S]*?)(<\/code>)/gim, function(){
    return arguments[1] + escape_html(arguments[2]) + arguments[3];
  });
}

//htmlのエスケープ(https://qiita.com/saekis/items/c2b41cd8940923863791)
function escape_html (string) {
  if(typeof string !== 'string') {
    return string;
  }
  return string.replace(/[&'`"<>]/g, function(match) {
    return {
      '&': '&amp;',
      "'": '&#x27;',
      '`': '&#x60;',
      '"': '&quot;',
      '<': '&lt;',
      '>': '&gt;',
    }[match]
  });
}

/********************************************************************************************
*各種ボタンにイベントリスナーを追加する
*********************************************************************************************/
$(document).ready(function(e)
{
  //uploadpictures
  loadPictures('uploadedList',callbackForLoad);
  $('.uploadPictures').click(function()
  {
    uploadPictures(function(){loadPictures('uploadedList',callbackForLoad)});
    return false;
  });

  //uploadvideos
  loadVideos('uploadedMvList',callbackForMvLoad);
  $('.uploadVideos').click(function()
  {
    uploadVideos(function(){loadVideos('uploadedMvList',callbackForMvLoad)});
    return false;
  });


  $('.addCode').click(function(){
    insertCodeBlock('articleContent');
  });

  $('.addCitation').click(function(){
    insertCitationBlock('articleContent');
  });

  $('.addHeading').click(function(){
    insertHeading('articleContent');
  });

  $('.addToc').click(function(){
    insertToc('articleContent');
  });

  $('.addHref').click(function(){
    insertHref('articleContent');
  });

  $('.addSmallHref').click(function(){
    insertSmallHref('articleContent');
  });

  $('.addColorFont').click(function(){
    var color = $('.font-color option:selected').val();
    insertColorFont('articleContent', color);
  });

  $('.addCenteredFont').click(function(){
    insertCenteredFont('articleContent');
  });

  $('.addCategory').click(function(){
    addCategoryToArticle();
  });

  $('.plusCategory').click(function(){
    plusCategory();
  });

  $('.uploadArticle').click(function(){
    uploadArticle();
  });

  $('.addArticleCitation').click(function(){
    var id = $('.addedCitation').val();
    insertArticleCitation(id, 'articleContent');
  });

  $('.articleCategory').click(function(){
    var inputId = searchCategoryFromName($(this).text());
    $(this).remove();
    $('.articleCategories').find('input[value="' + inputId + '"]').remove();
  });

  $(".previewArticle").click(function(){
    var content = $(".articleContent").val();
    $("#previewArticle").empty();
    $("#previewArticle").append(
      makeHtmlForPreview(
        //codeタグ内をhtmlエスケープ
        replaceHtmlInsideCodeWithEscape(content)
      )
    );
    $(".previewArticle").modaal({
        content_source: '#previewArticle',
        fullscreen: true
    });
  });

});
