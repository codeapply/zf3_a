<?php

namespace Groups;

return [
  'invokables' => [
    'Groups\Repository\ItemRepository' => 'Groups\Repository\ItemRepositoryImpl'
  ],
  'factories' => [
    'Groups\Service\GroupsService' => function(\Zend\ServiceManager\ServiceManager $sl) {
        $groupsService = new \Groups\Service\GroupsServiceImpl();
        $groupsService->setItemRepository($sl->get('Groups\Repository\ItemRepository'));

        return $groupsService;
    }
  ],
  // initializers are called on every instantiation
  'initializers' => [
    function (\Zend\ServiceManager\ServiceManager $sl, $instance) {
        if ($instance instanceof \Zend\Db\Adapter\AdapterAwareInterface) {
          $instance->setDbAdapter($sl->get('Zend\Db\Adapter\Adapter'));
        }
    }
  ]
];
