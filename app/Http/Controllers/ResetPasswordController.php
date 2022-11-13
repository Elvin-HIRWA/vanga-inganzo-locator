<?php

namespace App\Http\Controllers;

use App\Mail\emailConfirmReseting;
use App\Mail\emailLinkResseting;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class ResetPasswordController extends Controller
{
    public function forgot(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "email" => "required|email:rfc,dns"
        ]);
        if ($validation->fails()) {
            return response()->json(["errors" => $validation->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $getpswd = User::where('email', $request->email)->first();
        if (!$getpswd) {
            return response()->json(["errors" => ["User email not found"]], Response::HTTP_NOT_FOUND);
        }
        $payload =  [
            "email" => $request->email,
            'duration_in_minutes' => 30,
            "timestamp" => time(),
        ];
        $generatekey = JWT::encode($payload, $getpswd->password, 'HS256');

        $resettingurl = ENV('GET_RESETING_URL') . $request->email . "?token=" . $generatekey;

        $useremail = $request->email;
        Mail::to($useremail)->send(new emailLinkResseting($resettingurl, $useremail));

        return \response()->json(["success" => ["recovery email link sent to your email "]], Response::HTTP_OK);
    }

    public function reset(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "email" => "required|email:rfc,dns",
            "tokenkey" => "required",
            "password" => "required|string|min:6|confirmed",


        ]);
        if ($validation->fails()) {
            return response()->json(["errors" => $validation->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $getemil = User::where('email', $request->email)->first();
        if (!$getemil) {
            return \response()->json(["errors" => ["User email not found"]], Response::HTTP_NOT_FOUND);
        }

        // decode pswd from the cuurent 
        try {
            $decodedtoken = JWT::decode($request->tokenkey, new Key($getemil->password, 'HS256'));
            $timeformt = $decodedtoken->timestamp;
            $durtion = $decodedtoken->duration_in_minutes;
            $nowtime = time();
            $diff = $nowtime - $timeformt;
            $minutes = floor($diff / (60));
            // check if link not expired ... 
            if ($minutes > $durtion) {
                return \response()->json(["errors" => ["the link to reset is expired in 30 min please resend again"]], Response::HTTP_UNAUTHORIZED);
            }
            User::where('email', $getemil->email)->update([
                'password' => Hash::make($request->password),
            ]);
            Auth::attempt([
                "email" => $request->email,
                "password" => $request->password
            ]);
            Auth::user()->tokens()->delete();
            $token = Auth::user()->createToken(Uuid::uuid4()->toString())->plainTextToken;
            // send confirmation email
            $getemailing = $getemil->email;
            Mail::to($getemil->email)->send(new emailConfirmReseting($getemailing));

            return response()->json(["token" => $token]);
        } catch (Exception $e) {
            return \response()->json(["errors" => ["Invalid signature"]], 500);
        }
    }
}
