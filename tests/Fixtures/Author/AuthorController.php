<?php

declare(strict_types=1);

namespace K9u\RequestMapper\Author;

use K9u\RequestMapper\Annotation\DeleteMapping;
use K9u\RequestMapper\Annotation\GetMapping;
use K9u\RequestMapper\Annotation\PatchMapping;
use K9u\RequestMapper\Annotation\PostMapping;
use K9u\RequestMapper\Annotation\PutMapping;

class AuthorController
{
    /**
     * @GetMapping("/authors")
     */
    public function index()
    {
        return "AuthorController::index()";
    }

    /**
     * @GetMapping("/authors/{id}")
     */
    public function get($id)
    {
        return "AuthorController::get($id)";
    }

    /**
     * @PostMapping("/authors")
     */
    public function post()
    {
        return "AuthorController::post()";
    }

    /**
     * @PutMapping("/authors/{id}")
     */
    public function put($id)
    {
        return "AuthorController::put($id)";
    }

    /**
     * @PatchMapping("/authors/{id}")
     */
    public function patch($id)
    {
        return "AuthorController::patch($id)";
    }

    /**
     * @DeleteMapping("/authors/{id}")
     */
    public function delete($id)
    {
        return "AuthorController::delete($id)";
    }
}
