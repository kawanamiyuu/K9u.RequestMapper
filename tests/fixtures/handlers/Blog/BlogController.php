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
        return "BlogController::index()";
    }

    /**
     * @GetMapping("/{id}")
     */
    public function get($id)
    {
        return "BlogController::get($id)";
    }

    /**
     * @PostMapping("")
     */
    public function post()
    {
        return "BlogController::post()";
    }

    /**
     * @PutMapping("/{id}")
     */
    public function put($id)
    {
        return "BlogController::put($id)";
    }

    /**
     * @PatchMapping("/{id}")
     */
    public function patch($id)
    {
        return "BlogController::patch($id)";
    }

    /**
     * @DeleteMapping("/{id}")
     */
    public function delete($id)
    {
        return "BlogController::delete($id)";
    }
}
