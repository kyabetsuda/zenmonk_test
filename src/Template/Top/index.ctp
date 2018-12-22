<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Picture[]|\Cake\Collection\CollectionInterface $pictures
 */
?>
<script>
//ウィンドウの高さによって表示する画像を変更する
if ($(window).width() > $(window).height()) {
	$('head').append(
		'<style>.desk2{display:none;}'
	);
}else{
	$('head').append(
		'<style>.desk1{display:none;}'
	);
}

$(document).ready(function(e)
	{
		iziToast.settings({
			iconUrl: 'icon_133010.svg',
	    message: 'Please tap the object in the picture',
			timeout: false
		});
		if ($(window).width() > $(window).height()) {
			//iziToast
			iziToast.show({
					position: 'topCenter'
			});
    }else{
			//iziToast
			iziToast.show({
					position: 'bottomCenter'
			});
    }

	}
)
</script>

<!--作品をフェードインさせるためのdiv -->
<div class="fadeIn">
	<div class="row desk1">
		<figure class="mx-auto">
			<img class="img-fluid" src="/img/desk.jpg" usemap="#ImageMap1" alt="" />
			<div class="text-muted text-right mr-2 my-2" style="font-size:10px">- <a href="https://unsplash.com/photos/-xJAb5-NJSQ">Unsplash</a></div>
		</figure>
		<map name="ImageMap1">
		  <area shape="poly" coords="337,498,336,500,583,386,669,563,416,677,416,677" href="/articles" alt="" />
		  <area shape="poly" coords="709,88,797,268,844,315,1075,204,1076,148,1063,142,996,2,879,0,879,0" href="/processings" alt="" />
		  <area shape="poly" coords="919,495,921,624,982,620,983,490,983,490" href="/pictures" alt="" />
		</map>
	</div>

	<div class="row desk2">
		<figure class="mx-auto">
			<img class="img-fluid" src="/img/desk2.jpg" usemap="#ImageMap2" alt="" />
			<div class="text-muted text-right mr-2 my-2" style="font-size:10px">- <a href="https://unsplash.com/photos/tOVmshavtoo">Unsplash</a></div>
		</figure>
		<map name="ImageMap2">
		  <area shape="poly" coords="124,458,129,533,237,532,237,456,221,456" href="/articles" alt="" />
		  <area shape="poly" coords="161,542,263,551,296,646,301,646,399,675,400,721,396,727,407,847,401,851,379,727,317,733,321,810,314,812,306,738,273,740,272,876,261,875,256,738,210,730,189,829,179,830,194,723,183,714,183,714" href="/processings" alt="" />
		  <area shape="poly" coords="170,178,169,294,163,295,163,327,200,329,200,339,235,339,235,389,318,388,319,350,390,349,389,311,360,307,358,208,271,207,271,175,271,175" href="/pictures" alt="" />
		</map>
	</div>

</div>
