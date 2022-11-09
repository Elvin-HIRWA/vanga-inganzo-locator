<?php

namespace App\Services;

use App\Models\Key;
use Firebase\JWT\JWT;

class KeyService
{
    public function createKey(int $id, string $keyname): Key
    {
        $payload =  [
            "permissionID" => $id,
            "timestamp" => time(),
        ];

        $jwt = JWT::encode($payload, $keyname, 'HS256');

        $keycreate = new Key();
        $keycreate->value = $jwt;
        $keycreate->permissionID = $id;
        $keycreate->save();

        return $keycreate;
    }

    public function listKey()
    {
        $keys = Key::all(['id', 'value', 'permissionID']);
        
        return $keys;
    }

    public function getKey(int $id)
    {
        $keys = Key::find($id);
        
        return $keys;
    }

    public function updateKey(int $permissionID, $keyname, $id)
    {
        $payload =  [
            "permissionID" => $permissionID,
            "timestamp" => time(),
        ];
        $jwt = JWT::encode($payload, $keyname, 'HS256');

        Key::where('id', $id)->update(['value' => $jwt]);
    }

    public function deleteKey(int $id)
    {
        $key = Key::find($id);
        $key->delete();
    }
}