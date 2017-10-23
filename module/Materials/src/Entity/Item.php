<?php

namespace Materials\Entity;

class Item
{
    protected $id;

    protected $name;

    protected $code;
    
    protected $group;
    
    protected $unit;


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

    public function getCode()
    {
      return $this->code;
    }

    public function setCode($code)
    {
      $this->code = $code;
    }
    
    public function getGroup()
    {
      return $this->group;
    }

    public function setGroup($group)
    {
      $this->group = $group;
    }

    public function getUnit()
    {
      return $this->unit;
    }

    public function setUnit($unit)
    {
      $this->unit = $unit;
    }
}
