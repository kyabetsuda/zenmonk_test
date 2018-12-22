<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Processing Entity
 *
 * @property int $id
 * @property string $title
 * @property string $code
 */
class Processing extends Entity
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
        'content' => true,
        'extension' => true,
        'ins_ymd' => true,
        'upd_ymd' => true,
        'contName' => true
    ];
}
