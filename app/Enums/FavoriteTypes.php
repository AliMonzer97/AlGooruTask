<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum FavoriteTypes: int
{
    use EnumHelper;
    case Category = 1;
    case Author = 2;
}
