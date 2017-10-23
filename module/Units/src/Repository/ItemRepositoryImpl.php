<?php

namespace Units\Repository;

use Units\Entity\Hydrator\ItemHydrator;
use Zend\Hydrator\Aggregate\AggregateHydrator;
use Zend\Db\ResultSet\HydratingResultSet;
use Units\Repository\ItemRepository;
use Zend\Db\Adapter\AdapterAwareTrait;
use Units\Entity\Item;

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
          'shortname' => $item->getShortName()
        ])
        ->into('units');
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
          'shortname'
      ])->from([
        'p' => 'units'
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
           * @var \Units\Entity\Item $item
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
          'shortname'
      ])->from([
        'p' => 'units'
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
          $paginator->setItemCountPerPage(5);

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
        'shortname'
      ])->from(
        ['p' => 'units']
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
      'shortname'
    ])->from(
      ['p' => 'units']
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
    $update = $sql->update('units')
      ->set([
        'name'       => $item->getName(),
        'shortname'        => $item->getShortName(),
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
        ->from('units')
        ->where([
          'id' => $itemId
        ]);

        $statement = $sql->prepareStatementForSqlObject($delete);
        $statement->execute();
  }
}
