<?php

namespace Materials\Entity;

class Unit
{
    protected $id;

    protected $name;

    protected $shortname;


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
      return $this->shortname;
    }

    public function setShortName($shortname)
    {
      $this->shortname = $shortname;
    }
}
