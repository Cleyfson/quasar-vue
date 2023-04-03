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

    /**
     *
     * get list with user(es).
     *
     * @OA\Get(
     *     path="/users",
     *     tags={"users"},
     *     summary="Returns a list of user(es)",
     *     description="Returns a map of status codes to quantities",
     *     operationId="index",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     )
     * )
     */
    public function index() {
        $users = User::paginate(6);
        return UserResource::collection($users);
    }

     /**
     *
     * get user.
     *
     * @OA\Get(
     *     path="/users/{id}",
     *     tags={"users"},
     *     summary="Returns a user",
     *     description="Returns a map of status codes to quantities",
     *     operationId="show",
     *     @OA\Parameter(
     *         name="userHashID",
     *         in="path",
     *         description="ID of the user",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Desculpe, Nao foi possivel encontrar usuario",
     *     )
     * )
     */
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

    /**
     *
     * create user.
     *
     * @OA\Post(
     *     path="/users/",
     *     tags={"users"},
     *     summary="create a user",
     *     description="Returns a map of status codes to quantities",
     *     operationId="create",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="attributes related to an user",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro ao criar novo usuario",
     *     )
     * )
     */
    public function create(userFormRequest $request) {
        $names = explode(' ', $request->nome);
        $user = new User;
        $user->email = $request->email;
        $user->first_name = $names[0];
        $user->last_name = (isset($names[1]))  ? $names[1] : fake()->lastName();
        $user->password = $request->password;
        $user->avatar = fake()->imageUrl(360, 360);

        if(!$user->save()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar novo usuario'
            ], 422);
        };

        return $user;
    }

    /**
     *
     * update user.
     *
     * @OA\Put(
     *     path="users/{id}",
     *     tags={"users"},
     *     summary="upadate a user",
     *     description="Returns a map of status codes to quantities",
     *     operationId="update",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="attributes related to an user",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro ao criar novo usuario",
     *     )
     * )
     */
    public function update(userFormRequest $request, $id_hash) {
        $id = $this->reuso->descriptografarId($id_hash);

        if (!$user = User::findOrFail($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Desculpe, o usuario não pode ser alterado.'
            ], 422);
        }

        $names = explode(' ', $request->nome);
        $user->first_name = $names[0];
        $user->last_name = (isset($names[1]))  ? $names[1] : fake()->lastName();
        $user->update();
        return $user;
    }

    /**
     *
     * delete user.
     *
     * @OA\Delete(
     *     path="users/{id}",
     *     tags={"users"},
     *     summary="delete a user",
     *     description="Returns a map of status codes to quantities",
     *     operationId="destroy",
     *     @OA\Parameter(
     *         name="userHashId",
     *         in="path",
     *         description="user hash id",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Desculpe, o usuario não pode ser excluido.",
     *     )
     * )
     */
    public function destroy($id_hash) {
        $id = $this->reuso->descriptografarId($id_hash);
        if (!$user = User::findOrFail($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Desculpe, o usuario não pode ser excluido.'
            ], 422);
        }

        $user->delete();
        return $user;
    }
}
