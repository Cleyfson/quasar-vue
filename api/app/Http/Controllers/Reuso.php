<?php

namespace App\Http\Controllers;

use Hashids\Hashids;


class Reuso extends Controller
{

    public function criptografarId($id){
        $hashid = new Hashids();
        $idCriptografado = $hashid->encode($id,1,2);
        return $idCriptografado;
    }

    public function descriptografarId($idCriptografado){
        $hashid = new Hashids();
        $id = $hashid->decode($idCriptografado);
        if(empty($id[0])) {
            dd('Erro de acesso a rota. Entre em contato com o Suporte.');
        }
        return $id[0];
    }


    public function msgErro ($obj,$msg) {
      if (!$obj){
        return response()->json([
          'success' => false,
          'message' => $msg
        ], 422);
      }
    }

    public function jsonMessage($type, $msg, $code)
    {
        $type = $type === 'success' ? 'true' : 'false';
        return response()->json([
            'success' => $type, 'message' => $msg
        ], $code);
    }
}
