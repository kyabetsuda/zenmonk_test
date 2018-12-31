<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Portfolio';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
  	<?= $cakeDescription ?>
  	<?php
		//echo $this->fetch('title');
    	?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('bootstrap.css') ?>
    <?= $this->Html->css('iziToast.min.css') ?>
    <?= $this->Html->css('modaal.min.css') ?>
    <?= $this->Html->css('thisDefault.css') ?>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.2/styles/default.min.css"/>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.2/highlight.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/processing.js/1.4.1/processing.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <?= $this->Html->script('jquery.rwdImageMaps.min.js') ?>
    <?= $this->Html->script('bootstrap.bundle.min.js') ?>
    <?= $this->Html->script('iziToast.min.js') ?>
    <?= $this->Html->script('modaal.min.js') ?>
    <?= $this->Html->script('default.js') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="d-flex flex-column">
<nav class="navbar navbar-expand-lg navbar-light d-print fixed-top">
	<a class="navbar-brand" href="/top">Portfolio</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topmenu" aria-controls="topmenu" aria-expanded="false" aria-label="toggledMenu">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="topmenu">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item"><a class="nav-link" href="/articles/">Articles</a></li>
			<li class="nav-item"><a class="nav-link" href="/pictures/">Pictures</a></li>
			<li class="nav-item"><a class="nav-link" href="/processings/">Processings</a></li>
		</ul>
		<?= $this->Form->create(null, [
			'url'=>['controller'=>'SearchResult','action'=>'index'],
		]) ?>
		<ul class="navbar-nav">
				<div class="input-group">
					<li class="nav-item mr-2">
						<!--<input type="text" class="form-control mr-auto rounded" placeholder="Search Works" aria-label="Search Works" aria-describedby="basic-addon1">-->
						<?=$this->Form->text('word',['class' => 'form-control mr-auto rounded', 'placeholder' => 'Search Works'])?>
					</li>
					<li class="nav-item">
						<button class="btn btn-outline-success" type="submit">Search</button>
					</li>
				</div>
		</ul>
		<?= $this->Form->end() ?>
	</div>
</nav>

<div class="container">
	<?= $this->fetch('content') ?>
</div>

<a href="#modal" class="inline" style="display:none"></a>
<div id="modal" class="" style="display: none">
  <div class="container">
  <div class="row">
    <div class="ml-auto"><button class="btn btn-outline-dark border modal-close">close</button></div>
  </div>
  <br>
  <h3 class="modalTitle"></h3>
  <div class="modalBody"></div>
  </div>
</div>

<footer class="footer mt-auto py-3">
  <div class="text-muted text-center" style="font-size:10px"></div>
	<div class="text-muted text-center" style="font-size:12px">©︎2018 Shiran All Rights Reserved. </div>
	</div>
</footer>


</body>
</html>
