<?php

namespace Materials\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Materials\Entity\Hydrator\ItemHydrator;
use Materials\Entity\Hydrator\GroupsHydrator;
use Materials\Entity\Hydrator\UnitsHydrator;
use Zend\Hydrator\Aggregate\AggregateHydrator;


class Edit extends Form
{
  public function __construct($materialsService)
  {
    parent::__construct('edit');
    
    $hydrator = new AggregateHydrator();
    $hydrator->add(new ItemHydrator());
    $hydrator->add(new GroupsHydrator());
    $hydrator->add(new UnitsHydrator());
    
    $this->setHydrator($hydrator);
    
    $id = new Element\Hidden('id');

    $name = new Element\Text('name');
    $name->setLabel('name');
    $name->setAttribute('class', 'form-control');

    $code = new Element\Text('code');
    $code->setLabel('Code');
    $code->setAttribute('class', 'form-control');

    $group_id = new Element\Select('group_id');
    $group_id->setLabel('Group');
    $group_id->setAttribute('class', 'form-control');
    $group_id->setValueOptions($this->getGroupsOptions($materialsService));  

    $unit_id = new Element\Select('unit_id');
    $unit_id->setLabel('Unit');
    $unit_id->setAttribute('class', 'form-control');
    $unit_id->setValueOptions($this->getUnitsOptions($materialsService));  


    $submit = new Element\Submit('submit');
    $submit->setValue('Update material');
    $submit->setAttribute('class', 'btn btn-primary');

    $this->add($id);
    $this->add($name);
    $this->add($code);
    $this->add($group_id);
    $this->add($unit_id);
    $this->add($submit);
  }
  
  public function getGroupsOptions($materialsService) 
  {
    $groupsArray = $materialsService->fetchAllGroups();
    foreach ($groupsArray as $k => $item) {
      $item_id = $item->getId();
      $options[$item_id] = $item->getName();
    }
    return $options;
  }
  
  public function getUnitsOptions($materialsService) 
  {
    $unitsArray = $materialsService->fetchAllUnits();
    foreach ($unitsArray as $k => $item) {
      $item_id = $item->getId();
      $options[$item_id] = $item->getName();
    }
    return $options;
  }
  
}
