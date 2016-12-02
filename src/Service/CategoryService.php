<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/2
 * Time: 16:40
 */
namespace ApigilityBlog\Service;

use ApigilityUser\DoctrineEntity\User;
use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use Zend\Math\Rand;
use ApigilityBlog\DoctrineEntity;

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

    /**
     * 创建一个文章分类
     * @param $name
     * @param $parent
     * @param $user
     * @return DoctrineEntity\Category
     */
    public function createCategory($name, DoctrineEntity\Category $parent = null, User $user = null)
    {
        $category = new DoctrineEntity\Category();
        $category->setName($name);
        if ($parent instanceof DoctrineEntity\Category) $category->setParent($parent);
        if ($user instanceof User)$category->setUser($user);

        $this->em->persist($category);
        $this->em->flush();

        return $category;
    }

    public function getCategory($category_id)
    {
        $category = $this->em->find('ApigilityBlog\DoctrineEntity\Category', $category_id);
        if (empty($category)) throw new \Exception('分类不存在', 404);
        else return $category;
    }

    public function getCategories($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('c')->from('ApigilityBlog\DoctrineEntity\Category', 'c');

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    public function deleteCategory($category_id, User $user)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('c')->from('ApigilityBlog\DoctrineEntity\Category', 'c');
        $qb->innerJoin('c.user', 'u');
        $qb->where('u.id = :user_id AND c.id = :category_id');
        $qb->setParameter('user_id',$user->getId());
        $qb->setParameter('category_id',$category_id);

        $categories = $qb->getQuery()->getResult();

        if (count($categories) == 0) throw new \Exception('分类不存在', 404);
        else {
            $this->em->remove($categories[0]);
            $this->em->flush();
            return true;
        }
    }
}