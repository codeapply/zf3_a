<?php

namespace Groups\Controller;

use Zend\Mvc\Controller\AbstractActionController;   
use Zend\View\Model\ViewModel;                         
use Groups\Entity\Item;
use Groups\Form\Add;
use Groups\Form\Edit;

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
        $itemsRef = $this->groupsService->fetchAll();
        
        $variables = [
          'items' => $items,
          'ref' => $itemsRef
        ];
        return new ViewModel($variables);
    }
    
    
  public function addAction()
  {    
    $form = new Add();
    $form->setGroupOptions($this->groupsService->fetchAll());  

    $variables = [
      'form' => $form
    ];

    if ($this->request->isPost()) { 
        $groupsItem = new Item();
        $form->bind($groupsItem);
        
        $data = $this->request->getPost();  
        $form->setData($data);

        if ($form->isValid()) {
          $this->groupsService->save($groupsItem);
          return $this->redirect()->toRoute('groups_home');
        }
    }

    return new ViewModel($variables);
  }


  public function deleteAction()
  {
    $this->groupsService->delete($this->params()->fromRoute('itemId'));
    $this->redirect()->toRoute('groups_home');
  }

  public function editAction()
  {
    $form = new Edit();
    $form->setGroupOptions($this->groupsService->fetchAll());
    $variables = ['form' => $form];

    if ($this->request->isPost()) {    
      $groupsItem = new Item();
      $form->bind($groupsItem);
      $data = $this->request->getPost();
      $form->setData($data); 
      if ($form->isValid()) {
        $this->groupsService->update($groupsItem);
        return $this->redirect()->toRoute('groups_home');
      }
    } else {  
        $item = $this->groupsService
          ->findById(
            $this->params()->fromRoute('itemId')
        );
        if (is_null($item)) {
          $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
        } else {
          $form->bind($item);
          $form->get('name')->setValue($item->getName());
          $form->get('parent_id')->setValue($item->getParentId());
          $form->get('id')->setValue($item->getId());
          //$form->get('group_id')->setValue($item->getGroup()->getId());
        }
      }
    return new ViewModel($variables);
  }
  
}
