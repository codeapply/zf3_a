<?php

namespace Groups\Entity;

class Item
{
    protected $id;

    protected $name;

    protected $parent_id;


    public function setId($id)
    {
      $this->id = $id;
    }

    public function getId()
    {
      return $this->id;
    }

    public function getName()
    {
      return $this->name;
    }

    public function setName($name)
    {
      $this->name = $name;
    }

    public function getParentId()
    {
      return $this->parent_id;
    }

    public function setParentId($parent_id)
    {
      $this->parent_id = $parent_id;
    }
}
