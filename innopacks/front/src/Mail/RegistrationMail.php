<?php
/* */

namespace InnoShop\Front\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use InnoShop\Common\Models\Customer;

class RegistrationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private Customer $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('mails.registration', [
            'customer' => $this->customer,
        ]);
    }
}
