<?php

namespace Groups\Service;

use Groups\Entity\Item;

interface GroupsService
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
