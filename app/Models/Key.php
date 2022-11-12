<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Key extends Model
{
    use HasFactory;

    protected $table = 'KeyPermission';

    public static function getKeyWithTheirPermission(): array
    {
        $key = DB::select(
            "SELECT k.id, k.value as `keyValue`, p.name as `permissionName`
            FROM `KeyPermission` k  
            INNER JOIN Permission p 
            on k.PermissionID = p.id"
        );

        return $key;
    }
}
