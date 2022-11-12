<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendSignUpKey extends Mailable
{
    use Queueable, SerializesModels;

    public string $key;
    public string $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($key, $email)
    {
        //
        $this->key = $key;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('vangainganzo@muzik.com', 'Vanga Inganzo')
            ->subject('Signup to Vanga Inganzo')
            ->markdown('mail.SendSignUpKey')
            ->with([
                'name' => $this->email,
                'link' => $this->key
            ]);
    }
}

    