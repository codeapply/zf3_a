<?php

namespace Materials\Entity\Hydrator;

use Materials\Entity\Item;
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
        'code'      => $object->getCode()
      ];
  }

  public function hydrate(array $data, $object)
  {
    if (!$object instanceof Item) {
      return $object;
    }

    $object->setId(isset($data['id']) ? intval($data['id']) : null);
    $object->setName(isset($data['name']) ? $data['name'] : null);
    $object->setCode(isset($data['code']) ? $data['code'] : null);

    return $object;
  }
}
