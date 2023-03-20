<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

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
}
