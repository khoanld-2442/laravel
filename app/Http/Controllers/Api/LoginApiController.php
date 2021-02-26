<?php

namespace App\Http\Controllers\Api;

use App\Transformers\UserTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Hash;
use League\Fractal\Resource\Collection;
use App\User;
use League\Fractal\Manager;

class LoginApiController extends Controller
{
     private $factal, $userTransform;
    function __construct(Manager $fractal, UserTransformer $userTransform)
    {
        $this->fractal = $fractal;
        $this->userTransform = $userTransform;
    }

    public function login(Request $request)
    {

        // return Json_encode($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'email',
            'password' => 'required|min:8:max:16',
        ]);
        if ($validator->fails()) {
            $message = [
                'message' => "yeu cau nhap day du thong tin",
            ];

            return json_encode($message);
        }
        // Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return json_encode("login that bai");
        }
        $user = Auth::user();
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'data' => md5(rand(0, 10)),
        ];

        return json_encode($data);
    }

    public function index() {

         $users = User::all(); // Get users from DB
        $users = new Collection($users, $this->userTransform); // Create a resource collection transformer
        $users = $this->fractal->createData($users); // Transform data

        return $users->toArray();
    }

    public function delete($id) {
        $user = User::find($id);
        $data = [];
        if ($user->delete()) {
            $data['message'] = "xoa thanh cong";
        } else{
            $data['message'] = "xoa that bai";
        }

        return json_encode($data);
    }

    public function add(Request $request) {
     $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'name' => $request->name
        ]);

        return json_encode($user);
    }

    public function show($id) {
        $user = User::find($id);
        return json_encode($user);
    }
}
