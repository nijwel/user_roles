<?php

namespace Nijwel\UserRoles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    protected $table = 'role_user';

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
