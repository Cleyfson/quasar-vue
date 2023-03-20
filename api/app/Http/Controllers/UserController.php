<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

class UserController extends Controller
{
    public function index() {
        $users = User::paginate(5);
        return UserResource::collection($users);
    }

    public function show(Request $request) {

        $user = User::where('id', $request->id)->get();
        return ($user);
    }

    public function create(Request $request) {
        $user = new User;
        $user->email = fake()->unique()->safeEmail();
        $user->first_name = fake()->firstName();
        $user->last_name = fake()->lastName();
        $user->avatar = fake()->image(null, 360, 360);
        return $user->save();
    }
}
