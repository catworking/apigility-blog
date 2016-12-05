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
}