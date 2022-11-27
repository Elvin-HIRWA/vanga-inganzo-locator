<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $table = 'BlogPost';

    protected $fillable = [
        "title",
        "description",
        "userID",
        "image_path"
    ];
}
