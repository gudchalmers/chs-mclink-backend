<?php


namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Register extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var string
     */
    public $uuid;
    /**
     * @var string
     */
    public $name;

    /**
     * Create a new message instance.
     *
     * @param string $uuid
     * @param string $name
     */
    public function __construct(string $uuid, string $name)
    {
        $this->uuid = hash('sha256', $uuid . config('app.key'));
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.register');
    }
}
