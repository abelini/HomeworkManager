<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Book Entity
 *
 * @property int $id
 * @property string $name
 * @property int $size
 * @property int $subject_id
 * @property string $path
 *
 * @property \App\Model\Entity\Subject $subject
 */
class Book extends Entity {
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'name' => true,
        'size' => true,
        'subject_id' => true,
        'path' => true,
        'subject' => true,
    ];
    
    public function humanSize() : float {
	    return round(($this->size / 1024 / 1024), 1);
    }
}
