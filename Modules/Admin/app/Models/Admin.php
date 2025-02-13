<?php

namespace Modules\Admin\Models;

use App\Trait\General;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use General;
    protected $table = 'admins';
    protected $guard_name = 'admin';

    protected $fillable = [
        'name',
        'email',
        'status',
        'password',
        'phone',
    ]; // End of $fillable
    protected $hidden = [
        'password',
        'remember_token',
    ]; // End of $hidden

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
        ];
    } // End of casts
} // End of model
