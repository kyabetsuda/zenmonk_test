<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Processing[]|\Cake\Collection\CollectionInterface $processings
 */
?>
<!--作品をフェードインさせるためのdiv -->
<div class="fadeIn">
	<h1 class="text-center">Processings</h1>
	<div class="row">
	<?php foreach ($processings as $processing): ?>
		<div class="col-sm-4 mb-1">
			<div class="card mb-3" style="max-width: 25rem;">
			<a href="">
			<img class="card-img-top" src="/img/processings/<?=$processing->title . '.' . $processing->extension?>">
			</a>
			<div class="card-body text-center">
				<span><?=$processing->title?>
				</span>
			</div>
			<div class="card-footer text-center" style="font-size:11px; background-color:#ffffff">
			<button href="#" class="btn btn-outline-dark border showModal" data-info='{"id":"<?=$processing->id?>","cntName":"<?=$processing->contName?>"}'>View</button>
				<span><?=$processing->upd_ymd?></span>
				</div>
			</div>
		</div>
	<?php endforeach?>
	</div>
</div>
<!--csrfトークン生成-->
<?= $this->Form->create(null, [
'url'=>['controller'=>'Article','action'=>'index'],
]) ?>
<?= $this->Form->end() ?>
