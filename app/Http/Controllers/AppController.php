<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class AppController extends Controller
{
    public function index()
    {
        return view('app.index');
    }
}
