<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ArticlesCategory Entity
 *
 * @property int $article_id
 * @property int $category_id
 * @property \Cake\I18n\FrozenTime $ins_ymd
 * @property \Cake\I18n\FrozenTime $upd_ymd
 *
 * @property \App\Model\Entity\Article $article
 * @property \App\Model\Entity\Category $category
 */
class ArticlesCategory extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'id' => true,
        'article_id' => true,
        'category_id' => true,
        'ins_ymd' => true,
        'upd_ymd' => true,
        'article' => true,
        'category' => true
    ];
}
