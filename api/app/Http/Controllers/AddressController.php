<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Reuso;



class AddressController extends Controller
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
     *     path="/api/v1/address",
     *     tags={"address"},
     *     summary="Returns a list of address(es) related to an user",
     *     description="Returns a map of status codes to quantities",
     *     operationId="getAddresses",
     *     @OA\Parameter(
     *         name="user",
     *         description="hashID of the user that owns the adress(es)",
     *         required=true,
     *         in="query",
     *         example="vZC7fX"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="operação realizado com sucesso",
     *     ),
     *     security={{"bearer_token":{}}}
     * )
     */
    public function getAddresses(Request $request) {
        $id = $this->reuso->descriptografarId($request->user);
        $addresses = Address::where('user_id', $id)->get();
        return UserResource::collection($addresses);
    }

    /**
     * Add a new address.
     *
     * @OA\Post(
     *     path="/api/v1/address/",
     *     tags={"address"},
     *     operationId="createAddress",
     *     @OA\RequestBody(
     *       required=true,
     *       description="Pass user details",
     *       @OA\JsonContent(
     *          required={"rua", "cidade", "estado" , "cep" ,"user_id"},
     *            @OA\Property(property="rua", type="string", format="text", example="Avenida parana"),
     *            @OA\Property(property="cidade", type="string", format="text", example="Nova Lima"),
     *            @OA\Property(property="estado", type="string", format="text", example="MG"),
     *            @OA\Property(property="cep", type="string", format="text", example="34000752"),
     *            @OA\Property(property="user_id", type="string", format="text", example="vZC7fX")
     *       ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro ao criar novo endereço",
     *     ),
     *     security={{"bearer_token":{}}}
     * )
     */
    public function createAddress(Request $request) {
        $id = $this->reuso->descriptografarId($request->user_id);
        $address = new Address;
        $address->rua = $request->rua;
        $address->cidade = $request->cidade;
        $address->estado = $request->estado;
        $address->cep = $request->cep;
        $address->user_id = $id;

        if(!$address->save()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar novo endereço'
            ], 422);
        };

        return $address;
    }
}
