<?php

namespace App\Http\Controllers;

use App\Http\Requests\userFormRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use Mockery\Undefined;
use PhpParser\Node\Stmt\TryCatch;
use Hashids\Hashids;
use App\Http\Controllers\Reuso;


class UserController extends Controller
{
    protected $reuso;

    public function __construct(Reuso $reuso) {
        $this->reuso = $reuso;
    }

    public function index() {
        $users = User::paginate(6);
        return UserResource::collection($users);
    }

    public function show($id_hash) {
        $id = $this->reuso->descriptografarId($id_hash);
        if (!$user = User::findOrFail($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Desculpe, Nao foi possivel encontrar usuario'
            ], 422);
        }
        return $user;
    }

    public function create(userFormRequest $request) {
        $names = explode(' ', $request->nome);
        $user = new User;
        $user->email = fake()->unique()->safeEmail();
        $user->first_name = $names[0];
        $user->last_name = (isset($names[1]))  ? $names[1] : fake()->lastName();
        $user->avatar = fake()->imageUrl(360, 360);

        if(!$user->save()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar novo usuario'
            ], 422);
        };

        return $user;
    }

    public function update(userFormRequest $request, $id_hash) {
        $id = $this->reuso->descriptografarId($id_hash);

        if (!$user = User::findOrFail($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Desculpe, o administrador não pode ser excluido.'
            ], 422);
        }

        $names = explode(' ', $request->nome);
        $user->first_name = $names[0];
        $user->last_name = (isset($names[1]))  ? $names[1] : fake()->lastName();
        $user->update();
        return $user;
    }

    public function destroy($id_hash) {
        $id = $this->reuso->descriptografarId($id_hash);
        if (!$user = User::findOrFail($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Desculpe, o administrador não pode ser excluido.'
            ], 422);
        }

        $user->delete();
        return $user;
    }
}
