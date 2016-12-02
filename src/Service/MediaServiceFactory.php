<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/2
 * Time: 16:41
 */
namespace ApigilityBlog\Service;

use Zend\ServiceManager\ServiceManager;

class MediaServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new MediaService($services);
    }
}