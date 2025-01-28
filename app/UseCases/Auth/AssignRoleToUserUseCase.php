<?php

namespace App\UseCases\Auth;

use App\Enums\Roles;
use App\Models\User;
use App\Repositories\Base\BaseRepository;
use App\UseCases\Model\StoreModelUseCase;

class AssignRoleToUserUseCase
{

    public function execute(User $user,$role): void
    {
         $user->assignRole(Roles::fromName($role)) ;
    }

}
