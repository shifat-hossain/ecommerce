<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //Permission.php
    public function roles() {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
    
    public function users() {
        return $this->belongsToMany(User::class, 'users_permissions');
    }
}
