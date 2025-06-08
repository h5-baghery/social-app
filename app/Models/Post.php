<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use Searchable;
    use HasFactory;
    protected $fillable = ['title', 'body', 'user_id'];

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'body'  => $this->body,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function ratingCount()
    {
        return $this->ratings()->count();
    }

    public function comments(): HasMany
    {
        return $this->hasMany((Comment::class));
    }
}
