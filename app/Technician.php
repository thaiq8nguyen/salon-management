<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

/**
 * Class Technician
 * @mixin Eloquent
 */
class Technician extends Model
{
    protected $fillable = ['user_id', 'first_name', 'last_name', 'email', 'is_active'];
    protected $hidden = ['laravel_through_key'];

    public function accounts()
    {
        return $this->hasMany(TechnicianAccount::class);
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, TechnicianAccount::class);
    }

    public function sales()
    {
        return $this->transactions()->selectRaw('transactions.id, transaction_items.name, 
        transactions.credit as credit, transactions.date')
            ->join('transaction_items', 'transactions.transaction_item_id', '=', 'transaction_items.id');
    }

}
