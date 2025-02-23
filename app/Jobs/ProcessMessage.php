<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\UserMessage;
use Illuminate\Support\Facades\Log;

class ProcessMessage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct( public UserMessage $message )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Processing message: ' . $this->message);
        $userMessage = UserMessage::find($this->message->id);
        if ($userMessage->status != 'pending') {
            return;
        }
        $userMessage->status = 'processing';
        $userMessage->save();

        // Simulate processing time
        $randomTime = rand(1, 300); // Random time between 1 and 300 seconds
        print_r($randomTime.PHP_EOL);
        sleep($randomTime);

        $userMessage->processMessage();
        $userMessage->status = 'done';
        $userMessage->save();
    }
}
