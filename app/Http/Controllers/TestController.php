<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Controllers\HomeController;

class TestController extends Controller
{
    public function index()
    {
        $user = new HomeController();
        $user->getAll();
    }
}
