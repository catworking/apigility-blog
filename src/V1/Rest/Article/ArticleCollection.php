<?php
namespace ApigilityBlog\V1\Rest\Article;

use Zend\Paginator\Paginator;
use Zend\Stdlib\ArrayObject as ZendArrayObject;

class ArticleCollection extends Paginator
{
    public function getCurrentItems()
    {
        $set = parent::getCurrentItems();
        $collection = new ZendArrayObject();

        foreach ($set as $item) {
            $collection->append(new ArticleEntity($item));
        }
        return $collection;
    }
}
