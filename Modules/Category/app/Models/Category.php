<?php

namespace Modules\Category\Models;

use Illuminate\Support\Str;
use Modules\Book\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Category\Database\Factories\CategoryFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected $fillable = ['name', 'slug'];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    } //end of boot

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    } // end of books
}
