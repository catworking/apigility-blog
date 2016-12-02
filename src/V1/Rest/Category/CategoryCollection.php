<?php
namespace ApigilityBlog\V1\Rest\Category;

use Zend\Paginator\Paginator;
use Zend\Stdlib\ArrayObject as ZendArrayObject;

class CategoryCollection extends Paginator
{
    public function getCurrentItems()
    {
        $set = parent::getCurrentItems();
        $collection = new ZendArrayObject();

        foreach ($set as $item) {
            $collection->append(new CategoryEntity($item));
        }
        return $collection;
    }
}
