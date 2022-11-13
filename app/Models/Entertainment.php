<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entertainment extends Model
{
    use HasFactory;

    protected $table = 'Entertainment';

    protected $fillable = [
        "name",
        "venue",
        "startTime",
        "endTime",
        "eventDate",
        "userID",
        "img_path"
    ];
}
