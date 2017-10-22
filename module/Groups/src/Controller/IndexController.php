<?php

namespace Groups\Controller;

use Zend\Mvc\Controller\AbstractActionController;   
use Zend\View\Model\ViewModel;                         
use Groups\Entity\Item;

class IndexController extends AbstractActionController
{                                              
    protected $groupsService;
    
    public function __construct($groupsService)
    {
      $this->groupsService = $groupsService;
    }

    public function indexAction()
    {                                           
        $items = $this->groupsService->fetch(
            $this->params()->fromRoute('page')
        );
        
        $variables = [
          'items' => $items
        ];
        return new ViewModel($variables);
    }
}
