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

$cakeDescription = 'コーディング雑記';
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
    <?= $this->Html->css('thisDefault.css') ?>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.2/styles/default.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.css"/>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Modaal/0.4.4/css/modaal.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.2/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Modaal/0.4.4/js/modaal.min.js"></script>
    <?= $this->Html->script('bootstrap.bundle.min.js') ?>
    <?= $this->Html->script('siema.min.js') ?>
    <?= $this->Html->script('default.js') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="d-flex flex-column">
<nav class="navbar navbar-expand-lg navbar-light d-print fixed-top">
	<a class="navbar-brand" href="/top">
    <img alt="" src="/img/zatsu.png" style="width : 7vh; height : 7vh">
  </a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topmenu" aria-controls="topmenu" aria-expanded="false" aria-label="toggledMenu">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="topmenu">
		<ul class="navbar-nav mr-auto">
			<!-- <li class="nav-item"><a class="nav-link" href="/articles/">Articles</a></li> -->
		</ul>
		<!-- <?= $this->Form->create(null, [
			'url'=>['controller'=>'SearchResult','action'=>'index'],
		]) ?> -->
		<ul class="navbar-nav">
				<div class="input-group">
					<li class="nav-item mr-2 mb-2">
						<!--<input type="text" class="form-control mr-auto rounded" placeholder="Search Works" aria-label="Search Works" aria-describedby="basic-addon1">-->
						<?=$this->Form->text('word',['class' => 'form-control mr-auto rounded searchWord', 'placeholder' => 'キーワード'])?>
					</li>
					<li class="nav-item">
						<div class="btn btn-outline-success searchBtn">検索</div>
					</li>
				</div>
		</ul>
		<!-- <?= $this->Form->end() ?> -->
	</div>
</nav>

<div class="container"　style="display:none;">
  <div class="searchResult">
  </div>
  <div class="row articleList2">
  </div>
  <div class="row" style="display:flex; justify-content: center;">
    <div class="pagination2">
    </div>
    <input type="hidden" class="page2" value="0" />
  </div>
</div>

<!-- コンテンツ -->
<div class="container contentBody">
	<?= $this->fetch('content') ?>
</div>

<footer class="footer mt-auto py-3">
	<div class="text-muted text-center" style="font-size:1.5vh">
    ©︎2019 Zakkidesu All Rights Reserved.
  </div>
</footer>

<!--csrfトークン生成-->
<?= $this->Form->create(null, [
// 'url'=>['controller'=>'Article','action'=>'index'],
]) ?>
<?= $this->Form->end() ?>

</body>
</html>
