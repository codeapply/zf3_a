<?php

namespace Materials;

return [
  'invokables' => [
    'Materials\Repository\ItemRepository' => 'Materials\Repository\ItemRepositoryImpl'
  ],
  'factories' => [
    'Materials\Service\MaterialsService' => function(\Zend\ServiceManager\ServiceManager $sl) {
        $materialsService = new \Materials\Service\MaterialsServiceImpl();
        $materialsService->setItemRepository($sl->get('Materials\Repository\ItemRepository'));

        return $materialsService;
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
