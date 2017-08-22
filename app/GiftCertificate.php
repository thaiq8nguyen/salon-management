<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class GiftCertificate extends Model
{
    protected $fillable = ['squareId','amount','sold_at','expired_at'];

    public function detail(){
        return $this->hasMany(GiftCerticateDetail::class);
    }

    public function scopeHasValue(){

        return $this->where('amount','>',0.00);
    }

    public function scopeActive($query){

        $today = Carbon::now()->toDateTimeString();

        return $query->whereDate('expired_at','>=',$today);
    }
}


