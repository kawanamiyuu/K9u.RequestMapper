<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/authors' => [
            [['_route' => 'k9u_requestmapper_author_authorcontroller_index', '_handler_class' => 'K9u\\RequestMapper\\Author\\AuthorController', '_handler_method' => 'index'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'k9u_requestmapper_author_authorcontroller_post', '_handler_class' => 'K9u\\RequestMapper\\Author\\AuthorController', '_handler_method' => 'post'], null, ['POST' => 0], null, false, false, null],
        ],
        '/blogs' => [
            [['_route' => 'k9u_requestmapper_blog_blogcontroller_index', '_handler_class' => 'K9u\\RequestMapper\\Blog\\BlogController', '_handler_method' => 'index'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'k9u_requestmapper_blog_blogcontroller_post', '_handler_class' => 'K9u\\RequestMapper\\Blog\\BlogController', '_handler_method' => 'post'], null, ['POST' => 0], null, false, false, null],
        ],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/authors/([^/]++)(?'
                    .'|(*:27)'
                .')'
                .'|/blogs/([^/]++)(?'
                    .'|(*:53)'
                .')'
            .')/?$}sD',
    ],
    [ // $dynamicRoutes
        27 => [
            [['_route' => 'k9u_requestmapper_author_authorcontroller_get', '_handler_class' => 'K9u\\RequestMapper\\Author\\AuthorController', '_handler_method' => 'get'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'k9u_requestmapper_author_authorcontroller_put', '_handler_class' => 'K9u\\RequestMapper\\Author\\AuthorController', '_handler_method' => 'put'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'k9u_requestmapper_author_authorcontroller_patch', '_handler_class' => 'K9u\\RequestMapper\\Author\\AuthorController', '_handler_method' => 'patch'], ['id'], ['PATCH' => 0], null, false, true, null],
            [['_route' => 'k9u_requestmapper_author_authorcontroller_delete', '_handler_class' => 'K9u\\RequestMapper\\Author\\AuthorController', '_handler_method' => 'delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        53 => [
            [['_route' => 'k9u_requestmapper_blog_blogcontroller_get', '_handler_class' => 'K9u\\RequestMapper\\Blog\\BlogController', '_handler_method' => 'get'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'k9u_requestmapper_blog_blogcontroller_put', '_handler_class' => 'K9u\\RequestMapper\\Blog\\BlogController', '_handler_method' => 'put'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'k9u_requestmapper_blog_blogcontroller_patch', '_handler_class' => 'K9u\\RequestMapper\\Blog\\BlogController', '_handler_method' => 'patch'], ['id'], ['PATCH' => 0], null, false, true, null],
            [['_route' => 'k9u_requestmapper_blog_blogcontroller_delete', '_handler_class' => 'K9u\\RequestMapper\\Blog\\BlogController', '_handler_method' => 'delete'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
