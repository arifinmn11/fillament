<?php

namespace App\Policies;

use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePolicy
{
    protected $policies = [
        'Spatie\Permission\Models\Role' => 'App\Policies\RolePolicy',
    ];
}
