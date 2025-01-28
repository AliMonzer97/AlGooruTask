<?php

namespace App\UseCases\News;

class GetGuestNewsUseCase extends GetNewsUseCase
{
    protected array $columns = [
        'id','service','section','title',
        'summary','content','author','url',
        'image_url','published_at','external_id',
        'created_at'
    ];

}
