<?php

namespace Materials\Controller;

use Interop\Container\ContainerInterface;

class IndexControllerFactory
{
  public function __invoke(ContainerInterface $container)
  {
    return new IndexController($container->get('Materials\Service\MaterialsService'));
  }
}
