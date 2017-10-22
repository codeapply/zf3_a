<?php

namespace Groups\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Groups\Entity\Item;
use Groups\Entity\Category;
use Zend\Cache\StorageFactory;

class GroupsItemController extends AbstractRestfulController
{
  protected $blogService;
  protected $cache;

  public function __construct($blogService)
  {
    $this->blogService = $blogService;
    $this->cache = StorageFactory::factory([
      'adapter' => [
        'name'  => 'filesystem', // could be apc, memcache etc....
        'options' => [
          'namespace' => 'api_items'
        ]
      ],
      'plugins' => [
        'exception_handler' => [
          'throw_exceptions'  => false
        ],
        'Serializer'
      ]
    ]);
  }

  public function create($data)
  {
    $item = $this->setItem($data);

    $this->blogService->save($item);
    return new JsonModel(['success']);
  }

  public function delete($id)
  {
    try {
      $this->blogService->delete($id);
      $message = 'success';
    } catch (\Exception $e) {
      $message = $e->getMessage();
    }

    return new JsonModel([$message]);
  }

  public function deleteList($data)
  {

  }

  public function get($id)
  {
    $item = $this->blogService->findById($id);

    $result = $this->itemToArray($item);

    return new JsonModel($result);
  }

  public function getList()
  {
    $cacheKey = 'list';
    $items = $this->cache->getItem($cacheKey);

    if (is_array($items) && count($items)) {
      return new JsonModel($items);
    }

    $items = $this->blogService->fetchAll();

    $results = [];
    foreach ($items as $item) {
      $results[] = $this->itemToArray($item);
    }
    $this->cache->setItem($cacheKey, $results);

    return new JsonModel($results);
  }

  public function update($id, $data)
  {
    $item = $this->setItem($data);
    $item->setId($id);

    $this->blogService->update($item);
    return new JsonModel(['success']);
  }

  public function patch($id, $data)
  {
    try {
      $item = $this->blogService->findById($id);
      if (!$item) {
        throw new \Exception(sprintf("Item %s not found", $id));
      }

      foreach ($data as $key => $value) {
        $setter = 'set' . ucfirst($key);
        if (method_exists($item, $setter)) {
          $item->$setter($value);
        }
      }
      $this->blogService->update($item);
    } catch (\Exception $e) {
      return new JsonModel([$e->getMessage()]);
    }

    return new JsonModel(["success"]);
  }

  protected function itemToArray($item)
  {
      return [
        'id'        => $item->getId(),
        'name'     => $item->getName(),
        'slug'      => $item->getCode(),
        //'group'  => $item->getGroup()->getName()
        //'unit'  => $item->getUnit()->getName()
      ];
  }

  protected function setItem($data)
  {
    $item = new Item();
    $item->setName($data['name']);
    $item->setCode($data['parent_id']);
    /*
    $group = new Group();
    $group->setId($data['group']);
    $item->setGroup($group);
    $unit = new Unit();
    $group->setId($data['unit']);
    $item->setUnit($unit);
    */
    return $item;
  }
}
