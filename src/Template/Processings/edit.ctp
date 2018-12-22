<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Processing $processing
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $processing->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $processing->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Processings'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="processings form large-9 medium-8 columns content">
    <?= $this->Form->create($processing) ?>
    <fieldset>
        <legend><?= __('Edit Processing') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('code');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
