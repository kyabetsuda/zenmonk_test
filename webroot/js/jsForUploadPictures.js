/********************************************************************************************
*アップロード画像のロード
*********************************************************************************************/
function loadPictures(containerClassName, callbackMethod){
  $('.' + containerClassName).empty();
  var inputJson = {};
  var url = '/uplpictures/load';
  var callback = new Callback();
  callback.callback = function(){
    makeJsonToHtmlGzList(this.result, containerClassName);
    callbackMethod();
  }
  getJsonAndDoSomething(inputJson, url, callback);

}

/********************************************************************************************
*画像のアップロード
*********************************************************************************************/
function uploadPictures(callbackMethod){
  // フォームデータを取得
  var form = $('#uploadPictures').get(0);
  var inputJson = new FormData( form );
  var url = '/uplpictures/add';
  var callback = new Callback();
  callback.callback = function(){
    callbackMethod();
  }
  getJsonWithFileAndDoSomething(inputJson, url, callback);
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
  return "<div class='btn'><img class='pictThumbnail' style='max-width: 100%; margin : 1%;' src='/webroot/img/uploaded/"
      + title
      + "'></div>";
}
