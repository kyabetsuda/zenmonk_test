// var height = $('.navbar').height();
$(document).ready(function(e)
	{
		//タイトルをクリックするとスクロール
		$('.topString').click(function(){
			scrollToArticleListTitle();
		});

		//タイトル文字にアニメーションを追加する
		var id = 'title'
		var classes = 'animated rubberBand';
		var interval = 2000;
		addClassInterval(id, classes, interval);
	}
);

function addClassInterval(id, classes, interval){
	setInterval(
			function(){
				$('#' + id).addClass(classes);
				//一定時間経過後にクラスを消す
				setTimeout(function(){
					$('#' + id).removeClass("animated");
					$('#' + id).removeClass("rubberBand");
				},interval*0.8);
			},
			interval
	);
}
