<?php

namespace Modules\Order\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Created',
        );
    }

    public function attachments(): array
    {
        return [];
    }

    public function build(): self
    {
        return $this
            ->html('
                <html>
                    <body>
                        <h1>Order Created</h1>
                    </body>
                </html>
            ')->subject('Order Created');
    }
}
