<?php

namespace Materials\Controller;

use Zend\Mvc\Controller\AbstractActionController;   
use Zend\View\Model\ViewModel;

class Index extends AbstractActionController
{                                 
    public function indexAction()
    {
        $variables = [
        ];
        return new ViewModel($variables);
    }
}
