<?php
/* */

namespace InnoShop\Front\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgottenMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private string $code;

    private string $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $code, string $email)
    {
        $this->code  = $code;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('mails.forgotten', [
            'code'     => $this->code,
            'is_admin' => false,
            'email'    => $this->email,
        ]);
    }
}
