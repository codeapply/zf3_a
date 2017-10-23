<?php

namespace Materials\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Materials\Entity\Hydrator\ItemHydrator;
use Zend\Hydrator\Aggregate\AggregateHydrator;

class Add extends Form
{
  public function __construct($materialsService)
  {
    parent::__construct('add');

    $hydrator = new AggregateHydrator();
    $hydrator->add(new ItemHydrator());

    $this->setHydrator($hydrator);

    $name = new Element\Text('name');
    $name->setLabel('Name');
    $name->setAttribute('class', 'form-control');

    $code = new Element\Text('code');
    $code->setLabel('Code');
    $code->setAttribute('class', 'form-control');

    $group = new Element\Select('group_id');
    $group->setLabel('Group');
    $group->setAttribute('class', 'form-control');
    $group->setValueOptions($this->getGroupsOptions($materialsService));  
    
    $unit = new Element\Select('unit_id');
    $unit->setLabel('Unit');
    $unit->setAttribute('class', 'form-control');
    $unit->setValueOptions($this->getUnitsOptions($materialsService));  

    $submit = new Element\Submit('submit');
    $submit->setValue('Add material');
    $submit->setAttribute('class', 'btn btn-primary');

    $this->add($name);
    $this->add($code);
    $this->add($group);
    $this->add($unit);
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
    $options[0] = "Undefinied";
    foreach ($unitsArray as $k => $item) {
      $item_id = $item->getId();
      $options[$item_id] = $item->getName();
    }
    return $options;
  }
  
}
