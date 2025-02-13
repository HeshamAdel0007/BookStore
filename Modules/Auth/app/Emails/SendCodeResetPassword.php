<?php

namespace Modules\Auth\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCodeResetPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $code;

    /**
     * Create a new message instance.
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    public function build()
    {
        return $this->markdown('vendor.mail.send-code-reset-password');
    }
}
