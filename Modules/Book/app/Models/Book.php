<?php

namespace Modules\Book\Models;

use Illuminate\Support\Str;
use Modules\Order\Models\Discount;
use Modules\Order\Models\OrderItems;
use Modules\Category\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Modules\Publisher\Models\Publisher;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Book extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;
    protected $table = 'books';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'published_date',
        'isbn',
        'price',
        'sku',
        'stock_quantity',
        'average_rating',
        'review_count',
        'book_cover',
        'publisher_id'
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($book): void {
            if (empty($book->slug)) {
                $book->slug = Str::slug($book->name);
            }
            $book->sku = self::generateSKU($book);
        });
        static::updating(function ($book): void {
            if ($book->isDirty('name')) {
                $book->slug = Str::slug($book->name);
            }
        });
    } //end of boot

    public static function generateSKU($book): string
    {
        $prefix = Str::upper(Str::random(3));
        $name = $book->name ?? 'BOK';
        $randomNumber = random_int(100, 99999);
        $publisher = $book->publisher->name ?? 'NAN';

        $bookName = Str::upper(Str::substr($name, 0, 3));
        $publisherPart = Str::upper(Str::substr($publisher, 0, 3));

        return "{$prefix}-{$bookName}-{$randomNumber}-{$publisherPart}";
    } // end of generateSKU

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    } //end of category

    // relationship with Publisher
    public function publisher(): BelongsTo
    {
        // each book has one publisher
        return $this->belongsTo(Publisher::class);
    } // end of publishers

    // relationship with OrderItems
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItems::class);
    } //end of orderItems

    public function discount()
    {
        return $this->hasOne(Discount::class, 'id');
    } //end of discount

} // end of model
