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
				<div id="title" style="font-size:7vw">&lt;!-- 雑記です --&gt;</div>
			</div>
		</div>
	</div>

	<div class="elements">
		<!-- 記事一覧 -->
		<?php echo $this->element('Articles/articleList'); ?>
		<br>
		<br>
		<!-- カテゴリー一覧 -->
		<?php echo $this->element('Articles/categoryList'); ?>
		<br>
		<br>
		<!-- メールフォーム-->
		<?php echo $this->element('Articles/mailForm'); ?>
	</div>

</div>
