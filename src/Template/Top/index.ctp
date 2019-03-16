<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Picture[]|\Cake\Collection\CollectionInterface $pictures
 */
?>

<!-- <?= $this->Html->script('jsForIndexTop.js') ?> -->
<link rel="stylesheet" href="/css/cssForIndexTop.css<?php echo '?time='.time(); ?>"/>
<script src="/js/jsForIndexTop.js<?php echo '?time='.time(); ?>"></script>

<!--作品をフェードインさせるためのdiv -->
<div class="row">
	<div class="topString">
		<!-- <div> -->
			<div class="titleString" id="title" style="font-weight:bold">コーディング雑記</div>
		<!-- </div> -->
	</div>
</div>

<div class="elements">
	<!-- 記事一覧 -->
	<?php echo $this->element('Articles/articleList'); ?>
	<!-- プロフィール-->
	<br>
	<?php echo $this->element('Articles/profile'); ?>
</div>
