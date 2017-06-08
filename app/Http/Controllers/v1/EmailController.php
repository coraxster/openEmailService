<?php

namespace App\Http\Controllers\v1;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


class EmailController extends Controller
{



    public function __construct()
    {
        //
    }


    public function add()
    {
//       на вход
//        - e-mail
//        - тема
//        - содержимое, тело письма
//        - файлы для вложения (возможно, но думаю можно не по необходимости сделать)

        return 'Hello world!';


    }

}
