<?php
return [
    'service_manager' => [
        'factories' => [
            \ApigilityBlog\V1\Rest\Article\ArticleResource::class => \ApigilityBlog\V1\Rest\Article\ArticleResourceFactory::class,
            \ApigilityBlog\V1\Rest\Category\CategoryResource::class => \ApigilityBlog\V1\Rest\Category\CategoryResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'apigility-blog.rest.article' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/blog/article[/:article_id]',
                    'defaults' => [
                        'controller' => 'ApigilityBlog\\V1\\Rest\\Article\\Controller',
                    ],
                ],
            ],
            'apigility-blog.rest.category' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/blog/category[/:category_id]',
                    'defaults' => [
                        'controller' => 'ApigilityBlog\\V1\\Rest\\Category\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'apigility-blog.rest.article',
            1 => 'apigility-blog.rest.category',
        ],
    ],
    'zf-rest' => [
        'ApigilityBlog\\V1\\Rest\\Article\\Controller' => [
            'listener' => \ApigilityBlog\V1\Rest\Article\ArticleResource::class,
            'route_name' => 'apigility-blog.rest.article',
            'route_identifier_name' => 'article_id',
            'collection_name' => 'article',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilityBlog\V1\Rest\Article\ArticleEntity::class,
            'collection_class' => \ApigilityBlog\V1\Rest\Article\ArticleCollection::class,
            'service_name' => 'Article',
        ],
        'ApigilityBlog\\V1\\Rest\\Category\\Controller' => [
            'listener' => \ApigilityBlog\V1\Rest\Category\CategoryResource::class,
            'route_name' => 'apigility-blog.rest.category',
            'route_identifier_name' => 'category_id',
            'collection_name' => 'category',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilityBlog\V1\Rest\Category\CategoryEntity::class,
            'collection_class' => \ApigilityBlog\V1\Rest\Category\CategoryCollection::class,
            'service_name' => 'Category',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'ApigilityBlog\\V1\\Rest\\Article\\Controller' => 'HalJson',
            'ApigilityBlog\\V1\\Rest\\Category\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'ApigilityBlog\\V1\\Rest\\Article\\Controller' => [
                0 => 'application/vnd.apigility-blog.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'ApigilityBlog\\V1\\Rest\\Category\\Controller' => [
                0 => 'application/vnd.apigility-blog.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'ApigilityBlog\\V1\\Rest\\Article\\Controller' => [
                0 => 'application/vnd.apigility-blog.v1+json',
                1 => 'application/json',
            ],
            'ApigilityBlog\\V1\\Rest\\Category\\Controller' => [
                0 => 'application/vnd.apigility-blog.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \ApigilityBlog\V1\Rest\Article\ArticleEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-blog.rest.article',
                'route_identifier_name' => 'article_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilityBlog\V1\Rest\Article\ArticleCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-blog.rest.article',
                'route_identifier_name' => 'article_id',
                'is_collection' => true,
            ],
            \ApigilityBlog\V1\Rest\Category\CategoryEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-blog.rest.category',
                'route_identifier_name' => 'category_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilityBlog\V1\Rest\Category\CategoryCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-blog.rest.category',
                'route_identifier_name' => 'category_id',
                'is_collection' => true,
            ],
        ],
    ],
];
