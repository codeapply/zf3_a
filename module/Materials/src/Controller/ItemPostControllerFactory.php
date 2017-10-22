<?php

namespace Materials\Controller;

use Interop\Container\ContainerInterface;

class MaterialsItemControllerFactory
{
  public function __invoke(ContainerInterface $container)
  {
    return new BlogPostController($container->get('Materials\Service\MaterialsService'));
  }
}
