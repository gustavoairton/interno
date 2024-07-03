<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\Sale;
use App\Models\User;
use App\Models\UserPermission;

class UserObserver
{
    public function created(User $user): void
    {
        if ($user->user_level == 3) {
            UserPermission::create([
                'user_id' => $user->id,
                'permission' => '*'
            ]);
        }
        if ($user->user_level == 2) {
            UserPermission::create([
                'user_id' => $user->id,
                'permission' => 'recebimentos'
            ]);
            UserPermission::create([
                'user_id' => $user->id,
                'permission' => 'venda'
            ]);
        }
    }
}
