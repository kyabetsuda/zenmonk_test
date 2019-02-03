var height = $('.navbar').height();
$(document).ready(function(e)
	{

		//高さは文字が画面の真ん中に来るように調整されている
		//topStringの高さは ブラウザの縦 - 画面上のnavbar分の高さ*2.5 - 画面下からnavbar分の高さ*2.5
		//navbar*2.5となっているのは、もともとbodyがnavbarの下に隠れるのを防ぐためにnavbar*2.5下げているから
		$('.topString').css({
			'height':$(window).height() - (height*2.5*2),
			'width' : '100vw',
			'display' : 'flex',
			'align-items' : 'center',
			'justify-content' : 'center'
		});

		//タイトルの大きさを画面サイズによって可変対応
		if($(window).height() >= $(window).width()){
			$('.titleString').css({
				'font-size' : '6vh'
			});
		}else{
			$('.titleString').css({
				'font-size' : '6vw'
			});
		}

		//topStringの下にはnavbar*2.5の余白があるため、articleListはそれ分下げる
		$('.articleListTitle').css({
		  'margin-top' : height*2.5,
		});

		//それぞれの要素の高さを取得
		var heightOfTopString = $('.topString').height();
		var heightOfArticleList = $('.articleList').height();

		//bodyの最小の高さは全てのコンテンツ(要素)の1.2倍になるように設定
		$('body').css({
		  'min-height' : (heightOfTopString + (height*2.5) + heightOfArticleList)*1.5
		});

		//タイトルをクリックするとスクロール
		$('.topString').click(function(){
			$("html,body").animate({scrollTop:heightOfTopString + (height*2.5)});
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
					$('#' + id).removeClass();
				},interval*0.8);
			},
			interval
	);
}
