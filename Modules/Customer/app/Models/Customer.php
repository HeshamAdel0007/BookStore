<?php

namespace Modules\Customer\Models;

use App\Trait\General;
use Modules\Order\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements MustVerifyEmail
{
    use General, SoftDeletes;
    protected $table = 'customers';
    protected $guard_name = 'customer';

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

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    } //end of orders
} // End of model
