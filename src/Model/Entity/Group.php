<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Group Entity
 *
 * @property int $id
 * @property string|null $turno
 * @property string $grupo
 * @property string $icon
 *
 * @property \App\Model\Entity\Note[] $notes
 * @property \App\Model\Entity\Paper[] $papers
 * @property \App\Model\Entity\User[] $users
 */
class Group extends Entity {
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
        'turno' => true,
        'grupo' => true,
        'icon' => true,
        'notes' => true,
        'papers' => true,
        'users' => true,
    ];
    
    protected function _getUCGroup(){
	    return mb_strtoupper($this->grupo);
    }
}
