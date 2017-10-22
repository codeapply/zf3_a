<?php

namespace Materials\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{                                 
    public function indexAction()
    {
        $variables = [
          'materials' => $materials
        ];
        return new ViewModel($variables);
    }
}
