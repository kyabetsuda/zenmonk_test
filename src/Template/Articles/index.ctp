<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>

<!--作品をフェードインさせるためのdiv -->
<div class="fadeIn">
	<h1 class="text-center">Articles</h1>
	<div class="row">
	<?php foreach ($articles as $article): ?>
		<div class="col-sm-4 mb-1">
			<div class="card mb-3" style="max-width: 25rem;">
			<a href="">
			<img class="card-img-top" src="/img/articles/<?=$article->thumbnail?>">
			</a>
			<div class="card-body text-center">
				<span><?=$article->title?>
				</span>
			</div>
			<div class="card-footer text-center" style="font-size:11px; background-color:#ffffff">
			<button href="#" class="btn btn-outline-dark border showModal" data-info='{"id":"<?=$article->id?>","cntName":"<?=$article->contName?>"}'>View</button>
				<span><?=$article->upd_ymd?></span>
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
