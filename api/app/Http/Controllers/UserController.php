<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($page) {
        $users = User::paginate(5);
        return UserResource::collection($users);
    }
}
