<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Picture Entity
 *
 * @property int $id
 * @property string $title
 * @property string $path
 * @property \Cake\I18n\FrozenTime $ins_ymd
 * @property \Cake\I18n\FrozenTime $upd_ymd
 */
class Picture extends Entity
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
        'title' => true,
        'ins_ymd' => true,
        'upd_ymd' => true,
        'content' => true,
        'contName' => true,
        'thumbnail' => true
    ];
}
