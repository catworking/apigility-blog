<?php
namespace ApigilityBlog\V1\Rest\Category;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareCollection;

class CategoryCollection extends ApigilityObjectStorageAwareCollection
{
    protected $itemType = CategoryEntity::class;
}
