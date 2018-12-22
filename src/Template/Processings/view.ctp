<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Processing $processing
 */
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/processing.js/1.4.1/processing.min.js"></script>
<?= $this->Html->script('runProcessing.js', array(
	'id' => 'codejs',
	'data-codejs' => htmlspecialchars_decode($processing->code, ENT_QUOTES|ENT_HTML5) 
)) ?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Processing'), ['action' => 'edit', $processing->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Processing'), ['action' => 'delete', $processing->id], ['confirm' => __('Are you sure you want to delete # {0}?', $processing->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Processings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Processing'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="processings view large-9 medium-8 columns content">
    <h3><?= h($processing->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($processing->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($processing->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Code') ?></h4>
	<div id="abc"></div>
	<div style="text-align:center">
	  <canvas id="processing"></canvas>
	</div>
    </div>
</div>
