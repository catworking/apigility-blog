<?php
namespace ApigilityBlog\V1\Rest\Media;

class MediaResourceFactory
{
    public function __invoke($services)
    {
        return new MediaResource($services);
    }
}
