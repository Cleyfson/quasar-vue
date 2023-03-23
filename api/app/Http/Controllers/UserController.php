<?php

namespace App\Http\Controllers;

use App\Http\Requests\userFormRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use Mockery\Undefined;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function index() {
        $users = User::paginate(6);
        return UserResource::collection($users);
    }

    public function show($id) {
        $user = User::findOrFail($id);
        return $user;
    }

    public function create(userFormRequest $request) {
        $names = explode(' ', $request->nome);
        $user = new User;
        $user->email = fake()->unique()->safeEmail();
        $user->first_name = $names[0];
        $user->last_name = (isset($names[1]))  ? $names[1] : fake()->lastName();
        $user->avatar = fake()->imageUrl(360, 360);
        $user->save();

        return $user;
    }

    public function update(userFormRequest $request, $id) {

        if ($user = User::findOrFail($id)) {
            $names = explode(' ', $request->nome);
            $user->first_name = $names[0];
            $user->last_name = (isset($names[1]))  ? $names[1] : fake()->lastName();
            $user->update();
            return $user;
        } else {
            return response()->json([
                'success' => false,
                'message' => "Não foi possivel encontrar usuario"
            ], 422);
        }
    }

    public function destroy($id) {

        if ($user = User::findOrFail($id)) {
            $user->delete();
            return $user;
        } else {
            return response()->json([
                'success' => false,
                'message' => "Não foi possivel encontrar usuario."
            ], 422);
        }
    }
}
