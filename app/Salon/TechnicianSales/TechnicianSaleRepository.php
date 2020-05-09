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

        // find the technician book account in the accounts table
        $technicianAccount = Account::where('role_user_id', $technicianRoleUserId->pivot->id)->first();

        // find and retrieve the last transaction in the technician account in order to get the running balance
        //$lastTransaction = $technicianAccount->lastTransaction;

        $runningBalance = $technicianAccount->lastTransaction->running_balance;



        // insert technician sale and technician tip (if any) into as transactions under the technician account
        $saleTransaction = '';
        if ($sale['sales']) {
            $saleItem = TransactionItem::item('technician sales')->first();

            $saleTransaction = Transaction::create([
                'account_id' => $technicianAccount->id,
                'transaction_item_id' => $saleItem->id,
                'date' => $sale['date'],
                'description' => $sale['description'] ? $sale['description'] : '',
                'credit' => $sale['sales'],
                'running_balance' => $sale['sales'] + $runningBalance,
            ]);
        }
//        $tipTransaction = '';
//        if ($sale['tips']) {
//            $tipItem = TransactionItem::item('technician tips')->first();
//            $tipTransaction = Transaction::create([
//                'account_id' => $technicianAccount->id,
//                'transaction_item_id' => $tipItem->id,
//                'date' => $sale['date'],
//                'note' => $sale['note'] ? $sale['note'] : '',
//                'credit' => $sale['tips']
//            ]);
//        }
//
        $created = ['sale' => Transaction::where('id',$saleTransaction->id)->first()];
        //$created = $lastTransaction->running_balance;

        return $created;

    }

    public function updateTechnicianSale($saleId, $sale)
    {
    }

    public function deleteTechnicianSale($saleId)
    {
    }
}
