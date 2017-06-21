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
    protected $guid;

    public function __construct($from, $to, $title, $body, $guid)
    {
        $this->from = $from;
        $this->to = $to;
        $this->title = $title;
        $this->body = $body;
        $this->guid = $guid;
        Log::info('SendEmailJob created', [$guid, $from, $to, $title, $body]);
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

        Log::info('SendEmailJob processing', [$this->guid, $from, $to, $title]);

        try{
            Mail::send('email.blank', ['body' => $body], function ($message) use ($from, $to, $title) {
                $message->from($from);
                $message->to($to);
                $message->subject($title);
            });
        }catch (\Exception $exception){
            Log::notice('SendEmailJob failed', [$this->guid, 'exception' => $exception->getMessage() ?? null, $this->from, $this->to, $this->title]);
            return;
        }

        Log::info('SendEmailJob done', [$this->guid, $from, $to, $title]);
    }

}
