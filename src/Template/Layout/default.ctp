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
		// echo $this->fetch('title');
    // $this->Html->meta('icon') → favicon.icoをアイコンにする
    ?>
    </title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/default.css<?php echo '?time='.time(); ?>"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css"/>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Modaal/0.4.4/css/modaal.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.14.2/styles/rainbow.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.6/css/swiper.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/js/default.js<?php echo '?time='.time(); ?>"></script>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="d-flex flex-column">
<nav class="navbar navbar-light d-print fixed-top">
	<a class="navbar-brand" href="/top">
    <img alt="" src="/img/zatsu.png" style="width : 7vh; height : 7vh">
  </a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topmenu" aria-controls="topmenu" aria-expanded="false" aria-label="toggledMenu">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse"id="topmenu">
    <div class="nav-item">
      <div class="container">
        <div class="row">
          <input class="form-control searchWord" type="text" placeholder="記事検索"/>
          <button class="btn btn-outline-success searchBtn d-flex ml-auto">検索</button>
        </div>
        <br>
        <div class="row categoryList">
        </div>
      </div>
    </div>
	</div>
</nav>

<!-- コンテンツ -->
<div class="container contentBody fadeIn">
	<?= $this->fetch('content') ?>
</div>

<!-- フッター -->
<footer class="footer mt-auto py-3">
	<div class="text-muted text-center" style="font-size:1.5vh">
    ©︎2019 CodingZakki All Rights Reserved.
  </div>
</footer>

<?= $this->Form->create(null, []) ?>
<?= $this->Form->end() ?>

<!-- スクリプト -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.6/js/swiper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.14.2/highlight.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Modaal/0.4.4/js/modaal.min.js"></script>

</body>
</html>
