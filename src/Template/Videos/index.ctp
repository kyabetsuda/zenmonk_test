<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\video[]|\Cake\Collection\CollectionInterface $videos
 */
?>

<!--作品をフェードインさせるためのdiv -->
<div class="fadeIn">
	<h1 class="text-center">Videos</h1>
	<div class="row">
	<?php foreach ($videos as $video): ?>
		<div class="col-sm-4 mb-1">
			<div class="card mb-3" style="max-width: 25rem;">
			<a href="">
			<img class="card-img-top" src="/img/uploaded/<?=$video->thumbnail?>">
			</a>
			<div class="card-body text-center">
				<span><?=$video->title?>
				</span>
			</div>
			<div class="card-footer text-center" style="font-size:11px; background-color:#ffffff">
			<button class="btn btn-outline-dark border showModal" data-info='{"id":"<?=$video->id?>","cntName":"<?=$video->contName?>"}'>View</button>
				<span><?=$video->upd_ymd?></span>
				</div>
			</div>
		</div>
	<?php endforeach?>
	</div>
</div>

<!--csrfトークン生成-->
<?= $this->Form->create(null, [
'url'=>['controller'=>'videos','action'=>'index'],
]) ?>
<?= $this->Form->end() ?>
