<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::query()->updateOrCreate(['name' => Roles::Admin,'guard_name' => 'api']);
        Role::query()->updateOrCreate(['name' => Roles::Customer,'guard_name' => 'api']);
    }

}
