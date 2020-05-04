<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Transaction extends Model
{
    protected $fillable = [
        'role_user_id', 'transaction_type_id', 'amount', 'date',
    ];

    protected $hidden = [];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
