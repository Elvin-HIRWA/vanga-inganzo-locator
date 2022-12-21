<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'User';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'keyID',
        'name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUsersWithTheirPermissions(): array
    {
        $user = DB::select(
            "SELECT u.email as userEmail, p.name as `permissionName`
            FROM User u 
            INNER JOIN `KeyPermission` k  
            ON u.keyID = k.id 
            INNER JOIN Permission p 
            on k.PermissionID = p.id"
        );

        return $user;
    }

    public static function getUserPermission(int $userId): array
    {
        $userPermission = DB::select('SELECT Permission.id AS id, Permission.name AS permissionname 
        FROM User
        INNER JOIN KeyPermission 
        ON User.keyId=KeyPermission.id 
        INNER JOIN Permission
        ON KeyPermission.permissionId=Permission.id 
        WHERE User.id =?', [$userId]);

        return $userPermission;
    }
}
