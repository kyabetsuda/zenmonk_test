<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Article Entity
 *
 * @property int $id
 * @property string $title
 * @property int $category_id
 * @property string $text
 * @property \Cake\I18n\FrozenTime $ins_ymd
 * @property \Cake\I18n\FrozenTime $upd_ymd
 *
 * @property \App\Model\Entity\Category $category
 */
class Article extends Entity
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
        //'id' => true,
        'title' => true,
        'category_id' => true,
        'content' => true,
        'ins_ymd' => true,
        'upd_ymd' => true,
        'category' => true,
        'thumbnail' => true,
        'contName' => true,
        'draft' => true

    ];
}
