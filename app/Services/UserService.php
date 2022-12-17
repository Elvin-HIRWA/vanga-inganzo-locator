<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function getAllUsers()
    {
      return  User::all();
    }


    public function getSingleUser($id)
    {
        return User::find($id);
    }
}