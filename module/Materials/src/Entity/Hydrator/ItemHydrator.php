<?php

namespace Materials\Entity\Hydrator;

use Materials\Entity\Item;
use Materials\Entity\Group;
use Materials\Entity\Unit;
use Zend\Hydrator\HydratorInterface;

class ItemHydrator implements HydratorInterface
{
  public function extract($object)
  {
      if (!$object instanceof Item) {
        return [];
      }

      return [
        'id'        => $object->getId(),
        'name'     => $object->getName(),
        'code'      => $object->getCode(),
        'group_id'      => ($object->getGroup()) ? $object->getGroup()->getId() : null,
        'unit_id'      => ($object->getUnit()) ? $object->getUnit()->getId() : null
      ];
  }

  public function hydrate(array $data, $object)
  {
    if (!$object instanceof Item) {
      return $object;
    }                                   

    $group = new Group();     
    $group->setId(isset($data['group_id']) ? intval($data['group_id']) : null);
    
    $unit = new Unit();     
    $unit->setId(isset($data['unit_id']) ? intval($data['unit_id']) : null);
    
    $object->setId(isset($data['id']) ? intval($data['id']) : null);
    $object->setName(isset($data['name']) ? $data['name'] : null);
    $object->setCode(isset($data['code']) ? $data['code'] : null);
                               
    $object->setGroup($group);
    
    $object->setUnit($unit);
    
    return $object;
  }
}
