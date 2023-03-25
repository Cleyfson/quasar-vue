<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;
use App\Model\Address;

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
        'id_hash',
        'full_name'
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

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
