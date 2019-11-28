<?php

declare(strict_types=1);

namespace K9u\Router\Blog;

use K9u\Router\Annotation\DeleteMapping;
use K9u\Router\Annotation\GetMapping;
use K9u\Router\Annotation\RequestMapping;
use K9u\Router\Annotation\PatchMapping;
use K9u\Router\Annotation\PostMapping;
use K9u\Router\Annotation\PutMapping;

/**
 * @RequestMapping("/blogs")
 */
class BlogController
{
    /**
     * @GetMapping("")
     */
    public function index()
    {
    }

    /**
     * @GetMapping("/{id}")
     */
    public function get()
    {
    }

    /**
     * @PostMapping("")
     */
    public function post()
    {
    }

    /**
     * @PutMapping("/{id}")
     */
    public function put()
    {
    }

    /**
     * @PatchMapping("/{id}")
     */
    public function patch()
    {
    }

    /**
     * @DeleteMapping("/{id}")
     */
    public function delete()
    {
    }
}
