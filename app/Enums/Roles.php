<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum Roles:string
{
    use EnumHelper;

    case Admin = 'admin';
    case Customer = 'customer';
}
