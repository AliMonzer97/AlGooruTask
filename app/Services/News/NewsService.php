<?php

namespace App\Services\News;

class NewsService
{

    /**
     * @throws \Exception
     */
    public function index(array $data = [])
    {

        if (!isset($data['type']))
            throw new \Exception('You must specify type');

        $type = ucfirst($data["type"]);

        //Declare Dynamic Use Case depending on type
        $useCaseClassName = "App\UseCases\News\Get{$type}NewsUseCase";

        if (!class_exists($useCaseClassName))
            throw new \Exception("Invalid type: {$data['type']}");

        return app($useCaseClassName)->execute($data);
    }
}
