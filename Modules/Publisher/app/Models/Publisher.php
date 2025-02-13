<?php

namespace Modules\Publisher\Models;

use App\Trait\General;
use Modules\Book\Models\Book;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderItems;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Publisher extends Authenticatable implements MustVerifyEmail
{
    use General, SoftDeletes;
    protected $table = 'publishers';
    protected $guard_name = 'publisher';

    protected $fillable = [
        'name',
        'email',
        'about',
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

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function orderItems(): HasManyThrough
    {
        return $this->hasManyThrough(
            OrderItems::class,
            Book::class,
            'publisher_id', // Foreign key on books table
            'book_id',    // Foreign key on order_items table
            'id',         // Local key on publishers table
            'id'   // Local key on books table
        );
    }

    public function orders()
    {
        return Order::whereHas('orderItems.book', function ($query) {
            $query->where('publisher_id', $this->id);
        })->with('customer:id,name')->distinct();
    }
} // End of model
