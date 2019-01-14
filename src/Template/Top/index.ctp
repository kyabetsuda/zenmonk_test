<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Picture[]|\Cake\Collection\CollectionInterface $pictures
 */
?>

<?= $this->Html->script('jsForIndexTop.js') ?>

<!--作品をフェードインさせるためのdiv -->
<div class="fadeIn">
	<div class="row">
		<div class="topString">
			<div>
				<div id="title" style="font-size:10vw">Tsudarticles</div>
			</div>
		</div>
	</div>

	<!-- 記事一覧 -->
	<?php echo $this->element('Articles/articleList'); ?>

	<!-- カテゴリー一覧 -->
	<?php echo $this->element('Articles/categoryList'); ?>

</div>
