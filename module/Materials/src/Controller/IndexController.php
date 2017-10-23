<?php

namespace Materials\Controller;

use Zend\Mvc\Controller\AbstractActionController;   
use Zend\View\Model\ViewModel;                         
use Materials\Entity\Item;
use Materials\Form\Add;
use Materials\Form\Edit;

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
    
    
  public function addAction()
  {
    $form = new Add();

    $variables = [
      'form' => $form
    ];

    if ($this->request->isPost()) { 
        $materialsItem = new Item();
        $form->bind($materialsItem);

        
        $data = $this->request->getPost(); 
        $form->setData($data);

        if ($form->isValid()) {
          $this->materialsService->save($materialsItem);

          return $this->redirect()->toRoute('materials_home');
        }
    }

    return new ViewModel($variables);
  }


  public function deleteAction()
  {
    $this->materialsService->delete($this->params()->fromRoute('itemId'));
    $this->redirect()->toRoute('materials_home');
  }

  public function editAction()
  {
    $form = new Edit();
    $variables = ['form' => $form];

    if ($this->request->isPost()) {    
      $materialsItem = new Item();
      $form->bind($materialsItem);
      $data = $this->request->getPost();
      $form->setData($data); 
      if ($form->isValid()) {
        $this->materialsService->update($materialsItem);
        return $this->redirect()->toRoute('materials_home');
      }
    } else {  
        $item = $this->materialsService
          ->findById(
            $this->params()->fromRoute('itemId')
        );
        if (is_null($item)) {
          $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
        } else {
          $form->bind($item);
          $form->get('name')->setValue($item->getName());
          $form->get('code')->setValue($item->getCode());
          $form->get('id')->setValue($item->getId());
          //$form->get('group_id')->setValue($item->getGroup()->getId());
          //$form->get('unit_id')->setValue($item->getUnit()->getId());
        }
      }
    return new ViewModel($variables);
  }
  
}
