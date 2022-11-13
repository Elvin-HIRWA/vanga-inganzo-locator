<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Services\SendingKeyService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class SendingKeyController extends Controller
{
    public function sendingKey(Request $request, SendingKeyService $services)
    {
        $validation = Validator::make($request->all(), [
            "key" => "required|int",
            "email" => "required|email:rfc,dns",
        ]);
        if ($validation->fails()) {
            return response()->json(["errors" => $validation->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $getkey = Key::find($request->key);
        if ($getkey === null) {
            return \response()->json(["error" => ["no key entered or invalid key"]], Response::HTTP_NOT_FOUND);
        }
        $getvalue = $getkey->value;
        $services->SendingKey(
            $request->email,
            $getvalue
            
        );

        return \response()->json(["success" => "email to send key has been sent"], Response::HTTP_OK);
    }
}
