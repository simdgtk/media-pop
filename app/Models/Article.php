<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public const CATEGORY_MUSIC = 'music';
    public const CATEGORY_CINEMA = 'cinema';
    public const CATEGORY_VIDEO_GAMES = 'video_games';
    public const CATEGORY_ART = 'art';

    protected $fillable = [
        'title',
        'author',
        'published_at',
        'content',
        'image',
        'category',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'category' => 'array',
        ];
    }

    public function getImageURLAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return asset('storage/' . $this->image);
    }

    public static function availableCategories(): array
    {
        return [
            self::CATEGORY_MUSIC,
            self::CATEGORY_CINEMA,
            self::CATEGORY_VIDEO_GAMES,
            self::CATEGORY_ART,
        ];
    }
}
