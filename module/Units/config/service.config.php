<?php

namespace Units;

return [
  'invokables' => [
    'Units\Repository\ItemRepository' => 'Units\Repository\ItemRepositoryImpl'
  ],
  'factories' => [
    'Units\Service\UnitsService' => function(\Zend\ServiceManager\ServiceManager $sl) {
        $unitsService = new \Units\Service\UnitsServiceImpl();
        $unitsService->setItemRepository($sl->get('Units\Repository\ItemRepository'));

        return $unitsService;
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
