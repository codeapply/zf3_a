<?php

namespace Units\Controller;

use Zend\Mvc\Controller\AbstractActionController;   
use Zend\View\Model\ViewModel;                         
use Units\Entity\Item;                              
use Units\Form\Add;
use Units\Form\Edit;

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
    
    
  public function addAction()
  {
    $form = new Add();

    $variables = [
      'form' => $form
    ];

    if ($this->request->isPost()) { 
        $unitsItem = new Item();
        $form->bind($unitsItem);

        
        $data = $this->request->getPost(); 
        $form->setData($data);

        if ($form->isValid()) {
          $this->unitsService->save($unitsItem);

          return $this->redirect()->toRoute('units_home');
        }
    }

    return new ViewModel($variables);
  }


  public function deleteAction()
  {
    $this->unitsService->delete($this->params()->fromRoute('itemId'));
    $this->redirect()->toRoute('units_home');
  }

  public function editAction()
  {
    $form = new Edit();
    $variables = ['form' => $form];

    if ($this->request->isPost()) {    
      $unitsItem = new Item();
      $form->bind($unitsItem);
      $data = $this->request->getPost();
      $form->setData($data); 
      if ($form->isValid()) {
        $this->unitsService->update($unitsItem);
        return $this->redirect()->toRoute('units_home');
      }
    } else {  
        $item = $this->unitsService
          ->findById(
            $this->params()->fromRoute('itemId')
        );
        if (is_null($item)) {
          $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
        } else {
          $form->bind($item);
          $form->get('name')->setValue($item->getName());
          $form->get('shortname')->setValue($item->getShortName());
          $form->get('id')->setValue($item->getId());
        }
      }
    return new ViewModel($variables);
  }
  
}
