<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Processing $processing
 */
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/processing.js/1.4.1/processing.min.js"></script>
<?= $this->Html->script('runScript.js') ?>
<div class="processings form large-9 medium-8 columns content">
    <?= $this->Form->create(null, [
    	'url'=>['controller'=>'processings','action'=>'add'],
	'type'=>'file'
    ]) ?>
    <fieldset>
        <legend><?= __('Add Processing') ?></legend>
        <?php
	    echo $this->Form->control('title');
	?>
	<br>
    	<legend><?= __('image') ?></legend>
	<?=$this->Form->control('image',['type'=>'file','label'=>false])?>
    	<legend><?= __('Js') ?></legend>
	<?=$this->Form->control('js',['type'=>'file','label'=>false])?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Form->button(__('Test'),array('id'=>'testbutton')) ?>
<div id="abc"></div>
<div style="text-align:center">
  <canvas id="processing"></canvas>
</div>
