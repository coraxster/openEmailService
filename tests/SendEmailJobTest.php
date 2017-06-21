<?php

use \Illuminate\Support\Facades\Mail as Mail;

class SendEmailJobTest extends TestCase
{

    protected $faker;
    protected $mailer_mock;


    public function __construct($name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);

        $this->faker = Faker\Factory::create();
        app()->mailer->setSwiftMailer(Mockery::mock('Swift_Mailer'));
    }



    /**
     * A basic rest test.
     *
     * @return void
     */
    public function testSending()
    {
        $from = $this->faker->email;
        $to = $this->faker->email;
        $title = $this->faker->title;
        $body = $this->faker->paragraph;

        $job = new \App\Jobs\SendEmailJob($from, $to, $title, $body, 'string');


        Mail::shouldReceive('send')
            ->once()
            ->with('email.blank',
                ['body' => $body],
                Mockery::on(function($closure) use ($from, $to, $title) {
                    $message = Mockery::mock('Illuminate\Mailer\Message');
                    $message->shouldReceive('from')
                        ->with($from)
                        ->andReturn(Mockery::self());
                    $message->shouldReceive('to')
                        ->with($to)
                        ->andReturn(Mockery::self());
                    $message->shouldReceive('subject')
                        ->with($title)
                        ->andReturn(Mockery::self());
                    $closure($message);
                    return true;
                })
            )->andReturn(true);


        $job->handle();

        $this->assertTrue(true);
    }




}
