<?php

namespace Units\Service;

use Units\Entity\Item;

interface UnitsService
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
