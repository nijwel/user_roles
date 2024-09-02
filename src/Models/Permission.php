<?php

namespace Nijwel\UserRoles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nijwel\UserRoles\Models\Role;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
