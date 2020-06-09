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
    protected $hidden = [
        'laravel_through_key',
        'first_name',
        'last_name',
        'created_at',
        'updated_at',
        'is_active',
        'is_contractor',
        'email',
        'user_id',
        'id'
    ];
    protected $maps = ['first_name' => 'firstName', 'last_name' => 'lastName', 'id' => 'technicianId'];
    protected $appends = ['firstName', 'lastName', 'fullName', 'technicianId'];


    public function accounts()
    {
        return $this->hasMany(TechnicianAccount::class);
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, TechnicianAccount::class,
            'technician_id', 'transactionable_id', 'id', 'id');
    }

    public function sales()
    {
        return $this->transactions()->selectRaw('transactions.id, transaction_items.name, 
        transactions.credit as credit, transactions.date')->orderBy('transactions.date','asc')
            ->join('transaction_items', 'transactions.transaction_item_id', '=', 'transaction_items.id');
    }

    public function payPeriods()
    {
        return $this->belongsToMany(Technician::class, 'payment_reports')->withPivot('url');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getFirstNameAttribute()
    {
        return $this->attributes['first_name'];
    }

    public function getLastNameAttribute()
    {
        return $this->attributes['last_name'];
    }

    public function getTechnicianIdAttribute()
    {
        return $this->attributes['id'];
    }



}
