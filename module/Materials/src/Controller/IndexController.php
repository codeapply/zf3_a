<?php

namespace Materials\Controller;

use Zend\Mvc\Controller\AbstractActionController;   
use Zend\View\Model\ViewModel;                         
use Materials\Entity\Item;

class IndexController extends AbstractActionController
{                                              
    protected $materialsService;
    
    public function __construct($materialsService)
    {
      $this->materialsService = $materialsService;
    }

    public function indexAction()
    {                                           
        $items = $this->materialsService->fetch(
            $this->params()->fromRoute('page')
        );
        
        $variables = [
          'items' => $items
        ];
        return new ViewModel($variables);
    }
}
