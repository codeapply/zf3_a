<?php

namespace Units\Controller;

use Zend\Mvc\Controller\AbstractActionController;   
use Zend\View\Model\ViewModel;                         
use Units\Entity\Item;

class IndexController extends AbstractActionController
{                                              
    protected $unitsService;
    
    public function __construct($unitsService)
    {
      $this->unitsService = $unitsService;
    }

    public function indexAction()
    {                                           
        $items = $this->unitsService->fetch(
            $this->params()->fromRoute('page')
        );
        
        $variables = [
          'items' => $items
        ];
        return new ViewModel($variables);
    }
}
