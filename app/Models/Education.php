<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = ['author_id', 'category_id', 'title', 'slug', 'thumbnail', 'content_img', 'content_text'];
}
