<?php

namespace Materials\Entity\Hydrator;

use Materials\Entity\Unit;
use Zend\Hydrator\HydratorInterface;

class UnitsHydrator implements HydratorInterface
{
  public function extract($object)
  {
      if (!$object instanceof Unit) {
        return [];
      }

      return [
        'id'        => $object->getId(),
        'name'     => $object->getName(),
        'shortname'      => $object->getShortName()
      ];
  }

  public function hydrate(array $data, $object)
  {
    if (!$object instanceof Unit) {
      return $object;
    }

    $object->setId(isset($data['id']) ? intval($data['id']) : null);
    $object->setName(isset($data['name']) ? $data['name'] : null);
    $object->setShortName(isset($data['shortname']) ? $data['shortname'] : null);

    return $object;
  }
}
