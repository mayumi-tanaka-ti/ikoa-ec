<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCompletedUser extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $orderItems;
    public $total;

    /**
     * Create a new message instance.
     */
    public function __construct($userName, $orderItems, $total)
    {
        $this->userName = $userName;
        $this->orderItems = $orderItems;
        $this->total = $total;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ご注文ありがとうございます',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order_completed_user',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
