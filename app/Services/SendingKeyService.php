<?php

namespace App\Services;

use App\Mail\SendSignUpKey;
use Illuminate\Support\Facades\Mail;

class SendingKeyService
{

    public function SendingKey(string $email, string $getvalue) {

        $keyurl = Env('GET_REGISTER');
        $urltosend  = $keyurl . '/' . $email . "?token="  . $getvalue;
        Mail::to($email)->send(new SendSignUpKey($urltosend, $email));
    }
}
