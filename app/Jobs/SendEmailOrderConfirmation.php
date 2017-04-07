<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailOrderConfirmation implements ShouldQueue
{

    protected $order;

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(\Illuminate\Mail\Mailer $mailer)
    {

        $emailReceipient = env('ADMIN_EMAIL');

        $mailer->send('emails.customer_order_confirmation', $data, function($message) use($emailReceipient, $invoice_number) {
            $message->to($customer_email)->subject("Invoice Status Update {$invoice_number}");
        });
    }

}
