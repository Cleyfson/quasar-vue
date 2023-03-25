<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'avatar'
    ];

    protected $appends = [
        'id_hash'
    ];

    protected $hidden = [
        'id'
    ];

    public function getIdHashAttribute()
    {
        $hashid = new Hashids();
        $idCriptografado = $hashid->encode($this->id, 1, 2);
        return $idCriptografado;
    }
}
