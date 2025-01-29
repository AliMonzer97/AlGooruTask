<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum GetNewsTypes:string
{
    use EnumHelper;
    case Guest = "guest";
    case PersonalizedNews = "personalized";
}
