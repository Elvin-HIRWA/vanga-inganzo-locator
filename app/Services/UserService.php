<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserService
{
  public function getAllUsers()
  {
    $users = DB::select(
      'SELECT a.id as id,
                         a.name,
                         a.email,
                         c.name as permissionName,
                         a.created_at as createdDate
                         FROM User as a
                         JOIN KeyPermission as b
                         ON a.keyID = b.id
                         JOIN Permission AS c
                         ON b.permissionID = c.id
                         ORDER BY a.created_at DESC'
    );

    $result = [];

    foreach ($users as $value) {
      $user = [
        "id" => $value->id,
        "name" => $value->name,
        "email" => $value->email,
        "status" => $value->permissionName,
        "since" => Carbon::parse($value->createdDate)->format('Y-m-d'),
      ];

      array_push($result, $user);
    }

    return $result;
  }


  public function getSingleUser($id)
  {
    return User::find($id);
  }
}
