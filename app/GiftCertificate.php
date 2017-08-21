<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftCertificate extends Model
{
    protected $fillable = ['squareId','amount','sold_at','expired_at'];

    public function detail(){
        return $this->hasMany(GiftCerticateDetail::class);
    }
}


