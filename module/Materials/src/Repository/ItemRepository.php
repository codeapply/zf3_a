<?php

namespace Materials\Repository;

use Application\Repository\RepositoryInterface;
use Materials\Entity\Item;

interface ItemRepository extends RepositoryInterface
{
  public function save(Item $item);

  public function fetchAll();
  
  public function fetchAllGroups();
  
  public function fetchAllUnits();

  public function fetch($page);

  /**
   * @return Item|null
   */
  public function find($itemName);

  /**
   * @return Item|null
   */
  public function findById($itemId);

  public function update(Item $item);

  public function delete($itemId);
}
