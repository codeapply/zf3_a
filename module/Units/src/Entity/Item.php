<?php

namespace Units\Entity;

class Item
{
    protected $id;

    protected $name;

    protected $code;


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

    public function getShortName()
    {
      return $this->code;
    }

    public function setShortName($code)
    {
      $this->code = $code;
    }
}
