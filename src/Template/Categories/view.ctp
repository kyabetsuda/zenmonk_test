<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Category'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articles Categories'), ['controller' => 'ArticlesCategories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articles Category'), ['controller' => 'ArticlesCategories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="categories view large-9 medium-8 columns content">
    <h3><?= h($category->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($category->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($category->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ins Ymd') ?></th>
            <td><?= h($category->ins_ymd) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Upd Ymd') ?></th>
            <td><?= h($category->upd_ymd) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Articles Categories') ?></h4>
        <?php if (!empty($category->articles_categories)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Article Id') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Ins Ymd') ?></th>
                <th scope="col"><?= __('Upd Ymd') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($category->articles_categories as $articlesCategories): ?>
            <tr>
                <td><?= h($articlesCategories->article_id) ?></td>
                <td><?= h($articlesCategories->category_id) ?></td>
                <td><?= h($articlesCategories->ins_ymd) ?></td>
                <td><?= h($articlesCategories->upd_ymd) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ArticlesCategories', 'action' => 'view', $articlesCategories->]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ArticlesCategories', 'action' => 'edit', $articlesCategories->]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ArticlesCategories', 'action' => 'delete', $articlesCategories->], ['confirm' => __('Are you sure you want to delete # {0}?', $articlesCategories->)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
