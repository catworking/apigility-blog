<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/2
 * Time: 16:40
 */
namespace ApigilityBlog\Service;

use Zend\ServiceManager\ServiceManager;

class CategoryServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new CategoryService($services);
    }
}