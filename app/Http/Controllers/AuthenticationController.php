<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function createAccount(Request $request)
    {

        $validation = Validator::make($request->all(), [
            "key" => "required|string|min:10",
            "name" => "required|string|max:255",
            "email" => "required|email:rfc,dns",
            "password" => "required|string|min:6|confirmed"
        ]);

        if ($validation->fails()) {
            return response()->json(["errors" => $validation->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $key = Key::where("value", $request->key)->first();

        if (!$key) {
            return \response()->json(["errors" => ["Key not found"]], Response::HTTP_NOT_FOUND);
        }

        $user = User::create([
            'keyID' => $key->id,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'name' => $request->name
        ]);

        $permissions = User::getUserPermission($user->id);

        $permissionname = $permissions[0]->permissionname;
        $token = $user->createToken('token', [$permissionname])->plainTextToken;

        return \response()->json([
            "token" => $token,
            "permissionName" => $permissionname,
            "userID" => $user->id
        ]);
    }

    public function signin(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "email" => "required|email:rfc,dns",
            "password" => "required|string|min:6"
        ]);

        if ($validation->fails()) {
            return response()->json(["errors" => $validation->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::where("email", $request->email)->first();

        if (!$user) {
            return \response()->json(["errors" => ["User not found"]], Response::HTTP_NOT_FOUND);
        }


        if (!Hash::check($request->password, $user->password)) {
            return \response()->json(["errors" => ["Invalid credentials"]], Response::HTTP_FORBIDDEN);
        }

        Auth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        Auth::user()->tokens()->delete();

        $id = Auth::id();

        $permissions = User::getUserPermission($id);

        $permissionname = $permissions[0]->permissionname;
        $token = Auth::user()->createToken('token', [$permissionname])->plainTextToken;

        return \response()->json([
            "token" => $token,
            "permissionName" => $permissionname,
            "userID" => Auth::id()
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();


        return response()->json([
            'message' => 'Tokens Revoked'
        ], Response::HTTP_OK);
    }
}
