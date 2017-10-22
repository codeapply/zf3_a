<?php

namespace Materials\Service;

use Materials\Entity\Item;
use Materials\Service\MaterialsService;

class MaterialsServiceImpl implements MaterialsService
{
  protected $itemRepository;

  public function getItemRepository()
  {
      return $this->itemRepository;
  }

  public function setItemRepository($itemRepository)
  {
    $this->itemRepository = $itemRepository;
  }

  public function save(Item $item)
  {
    $this->itemRepository->save($item);
  }

  public function fetchAll()
  {
    return $this->itemRepository->fetchAll();
  }

  public function fetch($page)
  {
    return $this->itemRepository->fetch($page);
  }

  /**
   * @return Item|null
   */
  public function find($itemName)
  {
    return $this->itemRepository->find($itemName);
  }

  /**
   * @return Item|null
   */
  public function findById($itemId)
  {
    return $this->itemRepository->findById($itemId);
  }

  public function update(Item $item)
  {
    $this->itemRepository->update($item);
  }

  public function delete($itemId)
  {
    $this->itemRepository->delete($itemId);
  }
}
