<?php
namespace ApigilityBlog\V1\Rest\Media;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareCollection;

class MediaCollection extends ApigilityObjectStorageAwareCollection
{
    protected $itemType = MediaEntity::class;
}
