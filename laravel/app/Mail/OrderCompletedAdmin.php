<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCompletedAdmin extends Mailable
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
     * Build the message.
     */
    public function build()
    {
        return $this->subject('新規注文がありました')
            ->view('emails.order_completed_admin')
            ->with([
                'userName' => $this->userName,
                'orderItems' => $this->orderItems,
                'total' => $this->total,
            ]);
    }
}
