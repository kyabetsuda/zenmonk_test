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
				<div class="titleString" id="title" style="font-weight:bold">コーディング雑記</div>
			</div>
		</div>
	</div>

	<div class="elements">
		<!-- 記事一覧 -->
		<?php echo $this->element('Articles/articleList'); ?>
		<br>
		<!-- カテゴリー一覧-->
		<?php echo $this->element('Articles/categoryList'); ?>
		<br>
		<!-- メールフォーム-->
		<?php echo $this->element('Articles/mailForm'); ?>
		<br>
		<!-- プロフィール-->
		<?php echo $this->element('Articles/profile'); ?>
	</div>

</div>
