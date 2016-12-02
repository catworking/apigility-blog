<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/11/16
 * Time: 14:52
 */
return [
    'service_manager' => array(
        'factories' => array(
            'ApigilityBlog\Service\MediaService'=>'ApigilityBlog\Service\MediaServiceFactory',
            'ApigilityBlog\Service\CategoryService'=>'ApigilityBlog\Service\CategoryServiceFactory',
            'ApigilityBlog\Service\ArticleService'=>'ApigilityBlog\Service\ArticleServiceFactory',
        ),
    )
];