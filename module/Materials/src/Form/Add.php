<?php

namespace Materials\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Materials\Entity\Hydrator\ItemHydrator;
use Zend\Hydrator\Aggregate\AggregateHydrator;

class Add extends Form
{
  public function __construct()
  {
    parent::__construct('add');

    $hydrator = new AggregateHydrator();
    $hydrator->add(new ItemHydrator());
    //$hydrator->add(new GroupHydrator());
    //$hydrator->add(new UnitHydrator());

    $this->setHydrator($hydrator);

    $name = new Element\Text('name');
    $name->setLabel('name');
    $name->setAttribute('class', 'form-control');

    $code = new Element\Text('code');
    $code->setLabel('Code');
    $code->setAttribute('class', 'form-control');

    $group = new Element\Select('group_id');
    $group->setLabel('Group');
    $group->setAttribute('class', 'form-control');
    $group->setValueOptions([
      1 => 'Something 1',
      2 => 'Something 2',
      3 => 'Something 3'
    ]);

    $unit = new Element\Select('unit_id');
    $unit->setLabel('Unit');
    $unit->setAttribute('class', 'form-control');
    $unit->setValueOptions([
      1 => 'Something 1',
      2 => 'Something 2',
      3 => 'Something 3'
    ]);

    $submit = new Element\Submit('submit');
    $submit->setValue('Add material');
    $submit->setAttribute('class', 'btn btn-primary');

    $this->add($name);
    $this->add($code);
    $this->add($group);
    $this->add($unit);
    $this->add($submit);
  }
}
