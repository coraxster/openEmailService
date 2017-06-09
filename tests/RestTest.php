<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RestTest extends TestCase
{

    protected $faker;


    public function __construct($name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);

        $this->faker = Faker\Factory::create();
    }



    /**
     * A basic rest test.
     *
     * @return void
     */
    public function testAddJobSuccess()
    {
//       на вход
//        - e-mail
//        - тема
//        - содержимое, тело письма
//        - файлы для вложения (возможно, но думаю можно не по необходимости сделать)


        $request_data = [
            'email' => $this->faker->email,
            'title' => $this->faker->title,
            'body' => $this->faker->text,
        ];

        $this->expectsJobs(\App\Jobs\SendEmailJob::class);

        $this->json('POST', '/v1/send', $request_data)
            ->seeJson([
                'status' => 'ok',
            ])
            ->assertResponseStatus(200);
    }


    public function testAddJobInvalidAttrs()
    {
        $request_data = [
            'email' => 'not_valid*email+',
            'title' => '',
            'body' => false,
        ];

        $this->json('POST', '/v1/send', $request_data)
        ->seeJson([
            'email' => ['The email must be a valid email address.'],
            'title' => ['The title field is required.'],
            'body' => ['The body must be a string.']
    ])
        ->assertResponseStatus(422);
    }


}
