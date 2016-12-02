<?php
return [
    'service_manager' => [
        'factories' => [
            \ApigilityBlog\V1\Rest\Article\ArticleResource::class => \ApigilityBlog\V1\Rest\Article\ArticleResourceFactory::class,
            \ApigilityBlog\V1\Rest\Category\CategoryResource::class => \ApigilityBlog\V1\Rest\Category\CategoryResourceFactory::class,
            \ApigilityBlog\V1\Rest\Media\MediaResource::class => \ApigilityBlog\V1\Rest\Media\MediaResourceFactory::class,
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
            'apigility-blog.rest.media' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/blog/media[/:media_id]',
                    'defaults' => [
                        'controller' => 'ApigilityBlog\\V1\\Rest\\Media\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'apigility-blog.rest.article',
            1 => 'apigility-blog.rest.category',
            2 => 'apigility-blog.rest.media',
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
        'ApigilityBlog\\V1\\Rest\\Media\\Controller' => [
            'listener' => \ApigilityBlog\V1\Rest\Media\MediaResource::class,
            'route_name' => 'apigility-blog.rest.media',
            'route_identifier_name' => 'media_id',
            'collection_name' => 'media',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilityBlog\V1\Rest\Media\MediaEntity::class,
            'collection_class' => \ApigilityBlog\V1\Rest\Media\MediaCollection::class,
            'service_name' => 'Media',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'ApigilityBlog\\V1\\Rest\\Article\\Controller' => 'HalJson',
            'ApigilityBlog\\V1\\Rest\\Category\\Controller' => 'HalJson',
            'ApigilityBlog\\V1\\Rest\\Media\\Controller' => 'HalJson',
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
            'ApigilityBlog\\V1\\Rest\\Media\\Controller' => [
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
            'ApigilityBlog\\V1\\Rest\\Media\\Controller' => [
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
            \ApigilityBlog\V1\Rest\Media\MediaEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-blog.rest.media',
                'route_identifier_name' => 'media_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilityBlog\V1\Rest\Media\MediaCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-blog.rest.media',
                'route_identifier_name' => 'media_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-content-validation' => [
        'ApigilityBlog\\V1\\Rest\\Media\\Controller' => [
            'input_filter' => 'ApigilityBlog\\V1\\Rest\\Media\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'ApigilityBlog\\V1\\Rest\\Media\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'id',
                'field_type' => 'int',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'type',
                'description' => '媒体文件类型',
                'field_type' => 'int',
                'error_message' => '请输入媒体文件类型',
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'title',
                'description' => '标题',
                'error_message' => '请输入标题',
                'allow_empty' => true,
                'continue_if_empty' => true,
            ],
            3 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'uri',
                'description' => '文件相对地址',
                'field_type' => 'string',
                'error_message' => '请输入文件地址',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'ApigilityBlog\\V1\\Rest\\Media\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
];
