<?php

namespace Materials\Repository;

use Materials\Entity\Hydrator\ItemHydrator;
use Materials\Entity\Hydrator\GroupsHydrator;
use Materials\Entity\Hydrator\UnitsHydrator;
use Zend\Hydrator\Aggregate\AggregateHydrator;
use Zend\Db\ResultSet\HydratingResultSet;
use Materials\Repository\ItemRepository;
use Zend\Db\Adapter\AdapterAwareTrait;
use Materials\Entity\Item;
use Materials\Entity\Group;
use Materials\Entity\Unit;

class ItemRepositoryImpl implements ItemRepository
{
  use AdapterAwareTrait;

  public function save(Item $item)
  {
      try {
          $this->adapter
            ->getDriver()
            ->getConnection()
            ->beginTransaction();

      $sql = new \Zend\Db\Sql\Sql($this->adapter);
      $insert = $sql->insert()
        ->values([
          'name' => $item->getName(),
          'code' => $item->getCode(),
          'group_id' => $item->getGroup()->getId(),
          'unit_id' => $item->getUnit()->getId()
        ])
        ->into('materials');
    
     $statement = $sql->prepareStatementForSqlObject($insert);
     $statement->execute();
     $this->adapter->getDriver()
      ->getConnection()
      ->commit();
   } catch (\Exception $e) {
        $this->adapter->getDriver()
          ->getConnection()->rollback();
   }
  }

  public function fetchAll()
  {
      $sql = new \Zend\Db\Sql\Sql($this->adapter);
      $select = $sql->select();
      $select->columns([
          'id',
          'name',
          'code'
      ])->from([
        'p' => 'materials'
      ]);

      $statement = $sql->prepareStatementForSqlObject($select);
      $result = $statement->execute();

      $hydrator = new AggregateHydrator();
      $hydrator->add(new ItemHydrator());
      $resultSet = new HydratingResultSet($hydrator, new Item());
      $resultSet->initialize($result);

      $items = [];
      foreach($resultSet as $item) {
          /**
           * @var \Materials\Entity\Item $item
           */
          $items[] = $item;
      }
      return $items;
  }
  
  
  public function fetchAllGroups()
  {
      $sql = new \Zend\Db\Sql\Sql($this->adapter);
      $select = $sql->select();
      $select->columns([
          'id',
          'name',
          'parent_id'
      ])->from([
        'p' => 'groups'
      ]);
    

      $statement = $sql->prepareStatementForSqlObject($select);
      $result = $statement->execute();

      $hydrator = new AggregateHydrator();
      $hydrator->add(new GroupsHydrator());
      $resultSet = new HydratingResultSet($hydrator, new Group());
      $resultSet->initialize($result);
      
      $items = [];
      foreach($resultSet as $item) {      
          /**
           * @var \Materials\Entity\Item $item
           */
          $items[] = $item;
      }
      
      return $items;
  }
  
  
  public function fetchAllUnits()
  {
      $sql = new \Zend\Db\Sql\Sql($this->adapter);
      $select = $sql->select();
      $select->columns([
          'id',
          'name',
          'shortname'
      ])->from([
        'p' => 'units'
      ]);

      $statement = $sql->prepareStatementForSqlObject($select);
      $result = $statement->execute();

      $hydrator = new AggregateHydrator();
      $hydrator->add(new UnitsHydrator());
      $resultSet = new HydratingResultSet($hydrator, new Unit());
      $resultSet->initialize($result);

      $items = [];
      foreach($resultSet as $item) {
          /**
           * @var \Materials\Entity\Item $item
           */
          $items[] = $item;
      }
      return $items;
  }

  public function fetch($page)
  {
      $sql = new \Zend\Db\Sql\Sql($this->adapter);
      $select = $sql->select();
      $select->columns([
          'id',
          'name',
          'code'
      ])->from([
        'p' => 'materials'
      ]);

      $hydrator = new AggregateHydrator();
      $hydrator->add(new ItemHydrator());
      $resultSet = new HydratingResultSet($hydrator, new Item());

        $paginatorAdapter = new \Zend\Paginator\Adapter\DbSelect(
            $select,
            $this->adapter,
            $resultSet
          );
          $paginator = new \Zend\Paginator\Paginator($paginatorAdapter);
          $paginator->setCurrentPageNumber($page);
          $paginator->setItemCountPerPage(3);

          return $paginator;
  }

  /**
   * @return Item|null
   */
  public function find($itemName)
  {
      $sql = new \Zend\Db\Sql\Sql($this->adapter);
      $select = $sql->select();
      $select->columns([
        'id',
        'name',
        'code'
      ])->from(
        ['p' => 'materials']
      )->where(
        [ 'p.name' => $itemName]
      );

      $statement = $sql->prepareStatementForSqlObject($select);
      $results = $statement->execute();

      $hydrator = new AggregateHydrator();
      $hydrator->add(new ItemHydrator());

      $resultSet = new HydratingResultSet($hydrator, new Item());
      $resultSet->initialize($results);

      return ($resultSet->count() ? $resultSet->current() : null);
  }

  /**
   * @return Item|null
   */
  public function findById($itemId)
  {
    $sql = new \Zend\Db\Sql\Sql($this->adapter);
    $select = $sql->select();
    $select->columns([
      'id',
      'name',
      'code'
    ])->from(
      ['p' => 'materials']
    )->where(
      [ 'p.id' => $itemId ]
    );

    $statement = $sql->prepareStatementForSqlObject($select);
    $results = $statement->execute();

    $hydrator = new AggregateHydrator();
    $hydrator->add(new ItemHydrator());

    $resultSet = new HydratingResultSet($hydrator, new Item());
    $resultSet->initialize($results);

    return ($resultSet->count() ? $resultSet->current() : null);
  }

  public function update(Item $item)
  {
    $sql = new \Zend\Db\Sql\Sql($this->adapter);
    
    $update = $sql->update('materials')
      ->set([
        'name'       => $item->getName(),
        'code'        => $item->getCode(),
        'group_id'        => $item->getGroup()->getId(),
        'unit_id'        => $item->getUnit()->getId(),
      ])->where([
        'id' => $item->getId()
      ]);

      $statement = $sql->prepareStatementForSqlObject($update);
      $statement->execute();
  }

  public function delete($itemId)
  {
      $sql = new \Zend\Db\Sql\Sql($this->adapter);
      $delete = $sql->delete()
        ->from('materials')
        ->where([
          'id' => $itemId
        ]);

        $statement = $sql->prepareStatementForSqlObject($delete);
        $statement->execute();
  }
}
