<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    // Allowed category types
    public const CATEGORY_MUSIC = 'music';
    public const CATEGORY_CINEMA = 'cinema';
    public const CATEGORY_VIDEO_GAMES = 'video_games';
    public const CATEGORY_ART = 'art';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'author',
        'published_at',
        'content',
        'image',
        'category',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'category' => 'array',
        ];
    }

    /**
     * Return available categories as array.
     *
     * @return string[]
     */
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
