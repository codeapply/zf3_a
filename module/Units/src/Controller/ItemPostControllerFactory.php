<?php

namespace Units\Controller;

use Interop\Container\ContainerInterface;

class UnitsItemControllerFactory
{
  public function __invoke(ContainerInterface $container)
  {
    return new BlogPostController($container->get('Units\Service\UnitsService'));
  }
}
