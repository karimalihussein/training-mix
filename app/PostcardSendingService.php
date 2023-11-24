<?php

declare(strict_types=1);

namespace App;

use Illuminate\Support\Facades\Mail;

class PostcardSendingService
{
    public string $country;

    public int $width;

    public int $height;

    public function __construct(string $country, int $width, int $height)
    {
        $this->country = $country;
        $this->width = $width;
        $this->height = $height;
    }

    public function hello($message, $email)
    {
        Mail::raw($message, function ($message) use ($email) {
            $message->to($email);
        });
        var_dump('postcard was successfully sent with the message: '.$message);
    }
}
