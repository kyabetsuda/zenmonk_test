<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Picture[]|\Cake\Collection\CollectionInterface $pictures
 */
?>
<script>
var height = $('.navbar').height();
$(document).ready(function(e)
	{
		$('.topString').css({
			'height':$(window).height() - (height*2.5*2),
			'width' : '100vw',
			'display' : 'flex',
			'align-items' : 'center',
			'justify-content' : 'center'
		});

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

</script>

<!--作品をフェードインさせるためのdiv -->
<div class="fadeIn">

<div class="row">
	<div class="topString">
		<div>
			<div id="title" style="font-size:10vw">Tsudarticles</div>
		</div>
	</div>
</div>


</div>
