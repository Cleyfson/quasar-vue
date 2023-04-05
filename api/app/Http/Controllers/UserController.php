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
     *     path="/api/v1/users",
     *     tags={"users"},
     *     summary="Returns a list of user(es)",
     *     description="Returns a map of status codes to quantities",
     *     operationId="index",
     *     @OA\Response(
     *         response=200,
     *         description="operação realizado com sucesso",
     *     ),
     *     security={{"bearer_token":{}}}
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
     *         description="ID of the user",
     *         required=true,
     *         in="path",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="usuario encontrado com sucesso",
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
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                type="object",
     *                required={"email", "full_name", "password"},
     *                @OA\Property(property="email", type="text"),
     *                @OA\Property(property="full_name", type="text"),
     *                @OA\Property(property="password", type="password"),
     *             ),
     *         ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="usuario criado com sucesso",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro ao criar novo usuario",
     *     ),
     *     security={{"bearer_token":{}}}
     * )
     */
    public function create(userFormRequest $request, User $user) {

        $request->validate([
            'nome' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id_hash,
            'password' => 'required',
        ]);

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
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                type="object",
     *                required={"email", "full_name", "password"},
     *                @OA\Property(property="email", type="text"),
     *                @OA\Property(property="full_name", type="text"),
     *                @OA\Property(property="password", type="password"),
     *             ),
     *         ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario criado com sucesso",
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
        $user->email = $request->email;
        $user->password = $request->password;
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
     *         description="usuario deletado com sucesso",
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
