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
use Illuminate\Support\Facades\Hash;



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
     *     @OA\Parameter(
     *         name="page",
     *         description="number of page pagination",
     *         required=true,
     *         in="query",
     *         example="2"
     *     ),
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
     *     path="/api/v1/users/{id}",
     *     tags={"users"},
     *     summary="Returns a user",
     *     description="Returns a map of status codes to quantities",
     *     operationId="show",
     *     @OA\Parameter(
     *         name="id",
     *         description="hashID of the user",
     *         required=true,
     *         in="path",
     *         example="vZC7fX"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="usuario encontrado com sucesso",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Desculpe, Nao foi possivel encontrar usuario",
     *     ),
     *     security={{"bearer_token":{}}}
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
     *     path="/api/v1/users/",
     *     tags={"users"},
     *     summary="create a user",
     *     description="Returns a map of status codes to quantities",
     *     operationId="create",
     *     @OA\RequestBody(
     *       required=true,
     *       description="Pass user details",
     *       @OA\JsonContent(
     *          required={"nome", "email" ,"password"},
     *            @OA\Property(property="nome", type="string", format="name", example="Jon doe"),
     *            @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *            @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *       ),
     *     ),
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
        $user->password = Hash::make($request->password);
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
     *     path="/api/v1/users/{id}",
     *     tags={"users"},
     *     summary="upadate a user",
     *     description="Returns a map of status codes to quantities",
     *     operationId="update",
     *     @OA\Parameter(
     *         name="id",
     *         description="hashID of the user",
     *         required=true,
     *         in="path",
     *         example="vZC7fX"
     *     ),
     *     @OA\RequestBody(
     *       required=true,
     *       description="Pass user details",
     *       @OA\JsonContent(
     *          required={"nome", "email" ,"password"},
     *            @OA\Property(property="nome", type="string", format="name", example="Jon doe"),
     *            @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *            @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *       ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario criado com sucesso",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro ao criar novo usuario",
     *     ),
     *     security={{"bearer_token":{}}}
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
        $user->password = Hash::make($request->password);
        $user->update();
        return $user;
    }

    /**
     *
     * delete user.
     *
     * @OA\Delete(
     *     path="/api/v1/users/{id}",
     *     tags={"users"},
     *     summary="delete a user",
     *     description="Returns a map of status codes to quantities",
     *     operationId="destroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user hash id",
     *         required=true,
     *         example="vZC7fX"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="usuario deletado com sucesso",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Desculpe, o usuario não pode ser excluido.",
     *     ),
     *     security={{"bearer_token":{}}}
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
