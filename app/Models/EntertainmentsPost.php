<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntertainmentsPost extends Model
{
    use HasFactory;

    protected $table = "EntertainmentsPost";

    protected $fillable = [
        "title",
        "userID",
        "url"
    ];
}
