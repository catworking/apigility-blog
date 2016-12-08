<?php
namespace ApigilityBlog\V1\Rest\Article;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareCollection;

class ArticleCollection extends ApigilityObjectStorageAwareCollection
{
    protected $itemType = ArticleEntity::class;
}
