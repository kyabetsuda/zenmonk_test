<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Picture[]|\Cake\Collection\CollectionInterface $pictures
 */
?>

<!--作品をフェードインさせるためのdiv -->
<div class="fadeIn">
	<h1 class="text-center">Result</h1>
	<div class="row">
	<?php foreach ($results as $result): ?>
		<div class="col-sm-4 mb-1">
			<div class="card mb-3" style="max-width: 25rem;">
			<a href="">
			<img class="card-img-top" src="/img/<?=$result->contName?>/<?=$result->thumbnail?>">
			</a>
			<div class="card-body text-center">
				<span><?=$result->title?>
				</span>
			</div>
			<div class="card-footer text-center" style="font-size:11px; background-color:#ffffff">
			<button class="btn btn-outline-dark border showModal" data-info='{"id":"<?=$result->id?>","cntName":"<?=$result->contName?>"}'>View</button>
				<span><?=$result->upd_ymd?></span>
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
