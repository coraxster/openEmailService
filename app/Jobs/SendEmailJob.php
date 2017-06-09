<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailJob extends Job
{

    protected $from;
    protected $to;
    protected $title;
    protected $body;

    public function __construct($from, $to, $title, $body)
    {
        $this->from = $from;
        $this->to = $to;
        $this->title = $title;
        $this->body = $body;
        Log::info('SendEmailJob created', [$from, $to, $title, $body]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $from = $this->from;
        $to = $this->to;
        $title = $this->title;
        $body = $this->body;

        Log::info('SendEmailJob processing', [$from, $to, $title]);

        Mail::send('email.blank', ['body' => $body], function ($message) use ($from, $to, $title) {
            $message->from($from);
            $message->to($to);
            $message->subject($title);
        });

        Log::info('SendEmailJob done', [$from, $to, $title]);

    }

    public function fail($exception = null)
    {
        Log::notice('SendEmailJob failed', ['exception' => $exception->getMessage() ?? null, $this->from, $this->to, $this->title]);
    }
}
