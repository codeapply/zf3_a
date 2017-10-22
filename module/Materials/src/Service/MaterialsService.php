<?php

namespace Materials\Service;

use Materials\Entity\Item;

interface MaterialsService
{
  public function save(Item $item);

  public function fetchAll();

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
