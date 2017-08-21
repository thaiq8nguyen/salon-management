<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftCerticateDetail extends Model
{
    protected $fillable = ['date','amount','comments'];
    public function certificate(){
        $this->belongsTo(GiftCertificate::class);
    }
}
