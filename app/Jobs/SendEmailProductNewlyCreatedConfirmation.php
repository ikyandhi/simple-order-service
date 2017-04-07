<?php

namespace App\Jobs;

use App\Contracts\Repository\ProductRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailProductNewlyCreatedConfirmation implements ShouldQueue
{

    protected $skus;

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($skus)
    {
        $this->skus = $skus;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ProductRepositoryInterface $repository,
                           \Illuminate\Mail\Mailer $mailer)
    {
        $emailReceipient = env('ADMIN_EMAIL');

        $data = [
            'skus' => $this->skus
        ];

        $mailer->send('emails.products_newly_created_confirmation', $data, function($message) use($emailReceipient) {
            $message->to($emailReceipient)->subject("Product(s) newly created confirmation");
        });
    }

}
