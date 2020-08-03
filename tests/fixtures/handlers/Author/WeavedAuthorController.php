<?php

declare(strict_types=1);

namespace K9u\RequestMapper\Author;

class WeavedAuthorController extends AuthorController
{
    public function index()
    {
        return "weaved::" . parent::index();
    }

    public function get($id)
    {
        return "weaved::" . parent::get($id);
    }

    public function post()
    {
        return "weaved::" . parent::post();
    }

    public function put($id)
    {
        return "weaved::" . parent::put($id);
    }

    public function patch($id)
    {
        return "weaved::" . parent::patch($id);
    }

    public function delete($id)
    {
        return "weaved::" . parent::delete($id);
    }
}
