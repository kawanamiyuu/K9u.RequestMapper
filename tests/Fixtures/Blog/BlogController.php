<?php

declare(strict_types=1);

namespace K9u\RequestMapper\Blog;

use K9u\RequestMapper\Annotation\DeleteMapping;
use K9u\RequestMapper\Annotation\GetMapping;
use K9u\RequestMapper\Annotation\RequestMapping;
use K9u\RequestMapper\Annotation\PatchMapping;
use K9u\RequestMapper\Annotation\PostMapping;
use K9u\RequestMapper\Annotation\PutMapping;

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
