<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/2
 * Time: 16:40
 */
namespace ApigilityBlog\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use Zend\Math\Rand;

class CategoryService
{
    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
    }
}