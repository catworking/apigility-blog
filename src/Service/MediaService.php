<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/2
 * Time: 16:39
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

class MediaService
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

    public function createMedia($data, $user)
    {
        $media = new DoctrineEntity\Media();
        $media->setType($data->type);
        $media->setTitle(isset($data->title) ? $data->title : '无标题');
        $media->setUri($data->uri);
        $media->setCreateTime(new \DateTime());
        $media->setUser($user);

        $this->em->persist($media);
        $this->em->flush();

        return $media;
    }

    public function getMedia($media_id)
    {
        $media = $this->em->find('ApigilityBlog\DoctrineEntity\Media', $media_id);
        if (empty($media)) throw new \Exception('媒体不存在', 404);
        else return $media;
    }

    public function getMedias($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('m')->from('ApigilityBlog\DoctrineEntity\Media', 'm');

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    public function deleteMedia($media_id, User $user)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('m')->from('ApigilityBlog\DoctrineEntity\Media', 'm');
        $qb->innerJoin('m.user', 'u');
        $qb->where('u.id = :user_id AND m.id = :media_id');
        $qb->setParameter('user_id',$user->getId());
        $qb->setParameter('media_id',$media_id);

        $medias = $qb->getQuery()->getResult();

        if (count($medias) == 0) throw new \Exception('媒体不存在', 404);
        else {
            $this->em->remove($medias[0]);
            $this->em->flush();
            return true;
        }
    }
}