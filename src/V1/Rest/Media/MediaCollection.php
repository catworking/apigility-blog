<?php
namespace ApigilityBlog\V1\Rest\Media;

use Zend\Paginator\Paginator;
use Zend\Stdlib\ArrayObject as ZendArrayObject;

class MediaCollection extends Paginator
{
    public function getCurrentItems()
    {
        $set = parent::getCurrentItems();
        $collection = new ZendArrayObject();

        foreach ($set as $item) {
            $collection->append(new MediaEntity($item));
        }
        return $collection;
    }
}
