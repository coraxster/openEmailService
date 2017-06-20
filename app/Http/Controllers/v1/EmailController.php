<?php

namespace App\Http\Controllers\v1;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class EmailController extends Controller
{



    /**
     *  на вход
     *  - e-mail
     *  - тема
     *  - содержимое, тело письма
     *  - файлы для вложения (возможно, но думаю можно не по необходимости сделать)
     *
     * @param Request $request
     * @return array
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'from' => 'required|email',
            'to' => 'required|email',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $this->dispatch(
            new SendEmailJob(
                    $request->get('from'),
                    $request->get('to'),
                    $request->get('title'),
                    $request->get('body')
            )
        );


        return ['status' => 'ok'];

    }



    public function getConfig()
    {
        return [
            'config' => config()->all(),
            'env' => getenv()
        ];
    }

}
