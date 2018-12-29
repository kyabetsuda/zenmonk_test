<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Picture[]|\Cake\Collection\CollectionInterface $pictures
 */
?>

<!--作品をフェードインさせるためのdiv -->
<div class="fadeIn">
	<h1 class="text-center">Pictures</h1>
	<div class="row">
	<?php foreach ($pictures as $picture): ?>
		<div class="col-sm-4 mb-1">
			<div class="card mb-3" style="max-width: 25rem;">
			<a href="">
			<img class="card-img-top" src="/img/pictures/<?=$picture->thumbnail?>">
			</a>
			<div class="card-body text-center">
				<span><?=$picture->title?>
				</span>
			</div>
			<div class="card-footer text-center" style="font-size:11px; background-color:#ffffff">
			<button class="btn btn-outline-dark border showModal" data-info='{"id":"<?=$picture->id?>","cntName":"<?=$picture->contName?>"}'>View</button>
				<span><?=$picture->upd_ymd?></span>
				</div>
			</div>
		</div>
	<?php endforeach?>
	</div>
</div>

<!--csrfトークン生成-->
<?= $this->Form->create(null, [
'url'=>['controller'=>'pictures','action'=>'index'],
]) ?>
<?= $this->Form->end() ?>
