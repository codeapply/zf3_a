<?php

namespace Groups\Entity\Hydrator;

use Groups\Entity\Item;
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
        'parent_id'      => $object->getParentId()
      ];
  }

  public function hydrate(array $data, $object)
  {
    if (!$object instanceof Item) {
      return $object;
    }

    $object->setId(isset($data['id']) ? intval($data['id']) : null);
    $object->setName(isset($data['name']) ? $data['name'] : null);
    $object->setParentId(isset($data['parent_id']) ? $data['parent_id'] : null);

    return $object;
  }
}
