<?php

namespace App\Http\Controllers;

use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\User;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class UserController extends Controller
{
    private $factal, $userTransform;
    function __construct(Manager $fractal, UserTransformer $userTransform)
    {
        $this->fractal = $fractal;
        $this->userTransform = $userTransform;
    }

    public function index()
    {
        $users = User::all(); // Get users from DB
        $users = new Collection($users, $this->userTransform); // Create a resource collection transformer
        $users = $this->fractal->createData($users); // Transform data

        return $users->toArray();
    }

    public function createUser() {
        $check = User::create([
            'name' => "Le Dac Khoan",
            'email' => 'khoanld98@gmail.com',
            'password' => bcrypt("12345678")
        ]);

        return $check ? "thanh cong" : "that bai";
    }
}
