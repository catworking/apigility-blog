<?php
namespace ApigilityBlog\V1\Rest\Category;

class CategoryResourceFactory
{
    public function __invoke($services)
    {
        return new CategoryResource($services);
    }
}
