<?php

namespace Groups\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Groups\Entity\Hydrator\ItemHydrator;
use Zend\Hydrator\Aggregate\AggregateHydrator;


class Edit extends Form
{
  public function __construct()
  {
    parent::__construct('edit');
    
    $hydrator = new AggregateHydrator();
    $hydrator->add(new ItemHydrator());
    //$hydrator->add(new GroupHydrator());
    
    $this->setHydrator($hydrator);
    
    $id = new Element\Hidden('id');

    $name = new Element\Text('name');
    $name->setLabel('name');
    $name->setAttribute('class', 'form-control');

    $parent_id = new Element\Select('parent_id');
    $parent_id->setLabel('Parent group');
    $parent_id->setAttribute('class', 'form-control');
    $parent_id->setValueOptions([
      1 => 'Something 1',
      2 => 'Something 2',
      3 => 'Something 3'
    ]);
    
    $submit = new Element\Submit('submit');
    $submit->setValue('Update group');
    $submit->setAttribute('class', 'btn btn-primary');

    $this->add($id);
    $this->add($name);
    $this->add($parent_id);
    $this->add($submit);
    
  }
}
