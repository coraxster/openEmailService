<?php

namespace App\Jobs;

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

        Mail::send('email.blank', ['body' => $this->body], function ($message) use ($from, $to, $title) {
            $message->from([$from]);
            $message->to($to);
            $message->subject($title);
        });

    }
}
