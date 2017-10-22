<?php

namespace Groups\Controller;

use Interop\Container\ContainerInterface;

class GroupsItemControllerFactory
{
  public function __invoke(ContainerInterface $container)
  {
    return new BlogPostController($container->get('Groups\Service\GroupsService'));
  }
}
