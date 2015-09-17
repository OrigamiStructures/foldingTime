<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Time Entity.
 */
class Time extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
    
    protected function _getDuration() {
        $seconds = $this->_properties['time_out']->toUnixString() - $this->_properties['time_in']->toUnixString();
        return $seconds/3600;
    }
}
