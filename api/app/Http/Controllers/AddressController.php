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
     * get list with adress(es).
     *
     * @OA\Get(
     *     path="/address",
     *     tags={"address"},
     *     summary="Returns a list of adress(es) related to an user",
     *     description="Returns a map of status codes to quantities",
     *     operationId="getAddresses",
     *     @OA\Parameter(
     *         name="userHashID",
     *         in="path",
     *         description="ID of the users that owns the adress(es)",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     )
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
     *     path="/address/",
     *     tags={"address"},
     *     operationId="createAddress",
     *     @OA\Parameter(
     *         name="Adress",
     *         in="path",
     *         description="attributes related to an user adress",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     )
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
                'message' => 'Erro ao criar novo usuario'
            ], 422);
        };

        return $address;
    }
}
