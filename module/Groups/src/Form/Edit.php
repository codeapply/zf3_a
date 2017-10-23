<?php

namespace Groups\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Groups\Entity\Hydrator\ItemHydrator;
use Zend\Hydrator\Aggregate\AggregateHydrator;


class Edit extends Form
{
  public function __construct($groupsService)
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
    $parent_id->setValueOptions($this->getGroups($groupsService));      
    
    $submit = new Element\Submit('submit');
    $submit->setValue('Update group');
    $submit->setAttribute('class', 'btn btn-primary');

    $this->add($id);
    $this->add($name);
    $this->add($parent_id);
    $this->add($submit);
    
  }    
  
  public function getGroups($groupsService) 
  {
    $groupsArray = $groupsService->fetchAll();
    foreach ($groupsArray as $k => $group) {
      $group_id = $group->getId();
      $options[$group_id] = $group->getName();
    }
    return $options;
  }
  
}
