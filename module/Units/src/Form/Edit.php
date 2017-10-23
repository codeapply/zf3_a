<?php

namespace Units\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Units\Entity\Hydrator\ItemHydrator;
use Zend\Hydrator\Aggregate\AggregateHydrator;


class Edit extends Form
{
  public function __construct()
  {
    parent::__construct('edit');
    
    $hydrator = new AggregateHydrator();
    $hydrator->add(new ItemHydrator());
    
    $this->setHydrator($hydrator);
    
    $id = new Element\Hidden('id');

    $name = new Element\Text('name');
    $name->setLabel('name');
    $name->setAttribute('class', 'form-control');

    $shortname = new Element\Text('shortname');
    $shortname->setLabel('Shortname');
    $shortname->setAttribute('class', 'form-control');
    
    $submit = new Element\Submit('submit');
    $submit->setValue('Update unit');
    $submit->setAttribute('class', 'btn btn-primary');

    $this->add($id);
    $this->add($name);
    $this->add($shortname);
    $this->add($submit);
    
  }
}
