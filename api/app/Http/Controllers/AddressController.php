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

    public function index(Request $request) {
        $id = $this->reuso->descriptografarId($request->user);
        $addresses = Address::where('user_id', $id)->get();
        return UserResource::collection($addresses);
    }

    public function create(Request $request) {
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
