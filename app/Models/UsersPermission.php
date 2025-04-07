<?php
// app/Models/UsersPermission.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersPermission extends Model
{
    protected $table = 'users_permissions';

    // Quan hệ với User và Permission
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
