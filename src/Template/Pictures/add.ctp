<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Picture $picture
 */
?>
<div class="pictures form large-9 medium-8 columns content">
    <?= $this->Form->create(null, [
	    'url'=>['controller'=>'pictures','action'=>'add'],
	    'type'=>'file'
    ])?>
    <fieldset>
        <legend><?= __('Add Picture') ?></legend>
        <?php
            echo $this->Form->control('title');
        ?>
    <legend><?= __('image') ?></legend>
	  <?=$this->Form->control('image',['type'=>'file','label'=>false])?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
