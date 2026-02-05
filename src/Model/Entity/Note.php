<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\I18n\FrozenTime;

/**
 * Note Entity
 *
 * @property int $id
 * @property int $group_id
 * @property string $name
 * @property string $description
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\Notecomment[] $notecomments
 */
class Note extends Entity {
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
        'group_id' => true,
        'name' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'group' => true,
        'notecomments' => true,
	];
	
	public function isExpirable() : bool {
		return false;
	}
	
}