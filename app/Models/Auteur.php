<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'image',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'author', 'id');
    }

    public function getImageURLAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
        return asset('storage/' . $this->image);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        // rien à cacher pour le moment
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
        ];
    }
}
