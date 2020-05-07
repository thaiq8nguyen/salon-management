<?php

namespace App\Salon\TechnicianSales;


use Illuminate\Database\Eloquent\Builder;

use App\Account;
use App\Role;
use App\Transaction;
use App\TransactionItem;
use App\User;

class TechnicianSaleRepository implements TechnicianSaleInterface
{
    public function addTechnicianSale($sale)
    {
        // find the technician account using the technician Id

        $user = User::find($sale['technician_id']);

        // find the technician role user Id
        $technicianRole = Role::where('name', 'technician')->first();
        $technicianRoleUserId = $user->roles()->wherePivot('role_id', $technicianRole->id)->first();

        // find the technician account

        $technicianAccount = Account::where('role_user_id', $technicianRoleUserId->pivot->id)->first();

        // insert technician sale and technician tip (if any) into as transactions under the technician account
        if ($sale['sales']) {
            $saleItem = TransactionItem::item('technician sales')->first();
            $saleTransaction = Transaction::create([
                'account_id' => $technicianAccount->id,
                'transaction_item_id' => $saleItem->id,
                'date' => $sale['date'],
                'note' =>$sale['note'],
                'credit' => $sale['sales']
            ]);
        }


        return true;


        //$sale = Transaction::create(['owner_id' => $technicianId, '']);
    }

    public function updateTechnicianSale($saleId, $sale)
    {
    }

    public function deleteTechnicianSale($saleId)
    {
    }
}
