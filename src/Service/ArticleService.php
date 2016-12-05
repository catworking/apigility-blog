<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/1
 * Time: 19:43
 */
namespace ApigilityBlog\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use Zend\Math\Rand;
use ApigilityBlog\DoctrineEntity;

class ArticleService
{
    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * @var MediaService
     */
    protected $mediaService;

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
        $this->categoryService = $services->get('ApigilityBlog\Service\CategoryService');
        $this->mediaService = $services->get('ApigilityBlog\Service\MediaService');
    }

    /**
     * 创建一篇文章
     *
     * @param $data
     * @param $user
     * @param array $medias
     * @return DoctrineEntity\Article
     */
    public function createArticle($data, $user, $medias = [])
    {
        $article = new DoctrineEntity\Article();
        $article->setTitle($data->title);
        $article->setSummary($data->summary);
        $article->setContent($data->content);
        $article->setCreateTime(new \DateTime());

        if (isset($data->category_id)) {
            $category = $this->categoryService->getCategory($data->category_id);
            $article->addCategory($category);
        }

        if (isset($data->medias)) {
            $ids = explode(',', $data->medias);
            if (count($ids) > 0) {
                foreach ($ids as $id) {
                    $media = $this->mediaService->getMedia($id);
                    if ($media instanceof DoctrineEntity\Media) $article->addMedia($media);
                }
            }
        }

        if (count($medias) > 0) {
            foreach ($medias as $media) {
                if ($media instanceof DoctrineEntity\Media) $article->addMedia($media);
            }
        }

        $article->setUser($user);

        $this->em->persist($article);
        $this->em->flush();

        return $article;
    }

    public function getArticle($article_id)
    {
        $article = $this->em->find('ApigilityBlog\DoctrineEntity\Article', $article_id);
        if (empty($article)) throw new \Exception('文章不存在', 404);
        else return $article;
    }

    public function getArticles($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('a')->from('ApigilityBlog\DoctrineEntity\Article', 'a');

        $where = null;
        if (isset($params->category_id)) {
            $qb->innerJoin('a.categories', 'c');
            if (!empty($where)) $where .= ' AND ';
            $where = 'c.id = :category_id';
        }

        if (!empty($where)) {
            $qb->where($where);
            if (isset($params->category_id)) $qb->setParameter('category_id', $params->category_id);
        }

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }
}