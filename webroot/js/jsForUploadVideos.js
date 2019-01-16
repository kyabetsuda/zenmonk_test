/********************************************************************************************
*アップロード動画のロード
*********************************************************************************************/
function loadVideos(containerClassName, callbackMethod){
  $('.' + containerClassName).empty();
  var inputJson = {};
  var url = '/videos/load';
  var callback = new Callback();
  callback.callback = function(){
    makeJsonToHtmlMvList(this.result, containerClassName);
    callbackMethod();
  }
  getJsonAndDoSomething(inputJson, url, callback);

}

/********************************************************************************************
*動画のアップロード
*********************************************************************************************/
function uploadVideos(callbackMethod){
  // フォームデータを取得
  var form = $('#uploadVideos').get(0);
  var inputJson = new FormData( form );
  var url = '/videos/add';
  var callback = new Callback();
  callback.callback = function(){
    callbackMethod();
  }
  getJsonWithFileAndDoSomething(inputJson, url, callback);

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
