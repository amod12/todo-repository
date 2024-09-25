<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $email;

    /**
     * Create a new message instance.
     *
     * @param string $code
     * @param string $email
     */
    public function __construct($code, $email)
    {
        $this->code = $code;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('welcome')
                    ->with([
                        'code' => $this->code,
                        'email' => $this->email,
                    ]);
    }
}
