<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/1
 * Time: 19:43
 */
namespace ApigilityBlog\Service;

use ApigilityUser\DoctrineEntity\Identity;
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
        if (isset($data->title)) $article->setTitle($data->title);
        if (isset($data->summary)) $article->setSummary($data->summary);
        if (isset($data->content)) $article->setContent($data->content);
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

    /**
     * @param $article_id
     * @return \ApigilityBlog\DoctrineEntity\Article
     * @throws \Exception
     */
    public function getArticle($article_id)
    {
        $article = $this->em->find('ApigilityBlog\DoctrineEntity\Article', $article_id);
        if (empty($article)) throw new \Exception('文章不存在', 404);
        else return $article;
    }

    /**
     * @param $params
     * @return DoctrinePaginatorAdapter
     */
    public function getArticles($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('a')->from('ApigilityBlog\DoctrineEntity\Article', 'a');

        $where = '';
        if (isset($params->category_id)) {
            $qb->innerJoin('a.categories', 'c');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'c.id = :category_id';
        }

        if (isset($params->user_id)) {
            $qb->innerJoin('a.user', 'user');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'user.id = :user_id';
        }

        if (!empty($where)) {
            $qb->where($where);
            if (isset($params->category_id)) $qb->setParameter('category_id', $params->category_id);
            if (isset($params->user_id)) $qb->setParameter('user_id', $params->user_id);
        }

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    /**
     * 修改文章
     *
     * @param $article_id
     * @param $data
     * @param Identity $identity
     * @return DoctrineEntity\Article
     * @throws \Exception
     */
    public function updateArticle($article_id, $data, Identity $identity)
    {
        $article = $this->getArticle($article_id);

        if ($article->getUser()->getId() === $identity->getId()) {
            if (isset($data->title)) $article->setTitle($data->title);
            if (isset($data->summary)) $article->setSummary($data->summary);
            if (isset($data->content)) $article->setContent($data->content);
            if (isset($data->medias)) {
                // 先清空原有媒体
                $article->emptyMedias();
                $media_ids = explode(',', $data->medias);
                if (!empty($media_ids)) {
                    foreach ($media_ids as $media_id) {
                        $article->addMedia($this->mediaService->getMedia($media_id));
                    }
                }
            }
            $this->em->flush();
        } else {
            throw new \Exception('没有修改此文章的权限', 403);
        }

        return $article;
    }

    /**
     * 删除一篇文章
     *
     * @param $article_id
     * @param Identity $identity
     * @return bool
     * @throws \Exception
     */
    public function deleteArticle($article_id, Identity $identity)
    {
        $article = $this->getArticle($article_id);

        if ($article->getUser()->getId() === $identity->getId()) {
            $this->em->remove($article);
            $this->em->flush();
        } else {
            throw new \Exception('没有删除此文章的权限', 403);
        }

        return true;
    }
}