<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    // jika nama model kita Post udh otomatis dia ke detect tables posts (karena plural)
    use HasFactory;
    protected $fillable = [
        'title',
        'news_content',
        'author',
    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    public function Comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}
