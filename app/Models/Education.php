<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['author_id', 'category_id', 'title', 'slug', 'thumbnail', 'content_img', 'content_text'];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
