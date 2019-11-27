<?php

declare(strict_types=1);

namespace K9u\Router\Author;

use K9u\Router\Annotation\DeleteMapping;
use K9u\Router\Annotation\GetMapping;
use K9u\Router\Annotation\PatchMapping;
use K9u\Router\Annotation\PostMapping;
use K9u\Router\Annotation\PutMapping;

class AuthorController
{
    /**
     * @GetMapping("/authors")
     */
    public function index()
    {
    }

    /**
     * @GetMapping("/authors/{id}")
     */
    public function get()
    {
    }

    /**
     * @PostMapping("/authors")
     */
    public function post()
    {
    }

    /**
     * @PutMapping("/authors/{id}")
     */
    public function put()
    {
    }

    /**
     * @PatchMapping("/authors/{id}")
     */
    public function patch()
    {
    }

    /**
     * @DeleteMapping("/authors/{id}")
     */
    public function delete()
    {
    }
}
