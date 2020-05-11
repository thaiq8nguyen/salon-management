<?php

namespace App\Salon\TechnicianSales;
use Illuminate\Database\Eloquent\Builder;

use App\Account;
use App\Role;
use App\RoleUser;
use App\Transaction;
use App\TransactionItem;
use App\User;

class TechnicianSaleRepository implements TechnicianSaleInterface
{
    public function getTechnicianSales($date)
    {
        // TODO: Implement getTechnicianSales() method.
//        $technicians = User::with(['roles' => function($query)
//        {
//            $query->where('role_id', 2);
//        }])->get();
        $technicianRole = Role::with('users')->where('id',2)->first();
        $technicians = $technicianRole->users;
        $roleTechnicianIds = [];
        foreach ($technicians as $technician){
            array_push($roleTechnicianIds, $technician['pivot']['role_id']);
        }

        //$accounts = RoleUser::with('accounts')->whereIn('user_id',$roleTechnicianIds)->get();
        //$accountOnly = $accounts->pluck('accounts');

        $accounts = Account::with(['transactions' => function($query) use ($date){
            $query->where('date', $date);
        }])->get();



        return $accounts;

    }

    public function addTechnicianSale($sale)
    {
        // find the technician account using the technician Id
        $user = User::find($sale['technician_id']);

        // find the technician role user Id
        $technicianRole = Role::where('name', 'technician')->first();
        $technicianRoleUserId = $user->roles()->wherePivot('role_id', $technicianRole->id)->first();

        // find the technician book account in the accounts table
        $technicianAccount = Account::where('role_user_id', $technicianRoleUserId->pivot->id)->first();

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
                'running_balance' => $sale['sales'] + $technicianAccount->lastTransaction->running_balance,
            ]);
        }
        $tipTransaction = '';
        if ($sale['tips']) {
            $tipItem = TransactionItem::item('technician tips')->first();
            $tipTransaction = Transaction::create([
                'account_id' => $technicianAccount->id,
                'transaction_item_id' => $tipItem->id,
                'date' => $sale['date'],
                'description' => $sale['description'] ? $sale['description'] : '',
                'credit' => $sale['tips'],
                'running_balance' => $sale['tips'] + $technicianAccount->lastTransaction->running_balance,
            ]);
        }

        $created = ['running_balance' => $technicianAccount->lastTransaction->running_balance];


        return $created;
    }

    public function updateTechnicianSale($saleId, $sale)
    {
        $transaction = Transaction::find($saleId);
        $previousTransactionId = Transaction::where('id','<', $transaction->id)->max('id');
        $previousTransaction = Transaction::find($previousTransactionId);
        $previousRunningBalance = $previousTransaction->running_balance;
        $transaction->credit = $sale['credit'];

        $transaction->running_balance = $previousRunningBalance + $sale['credit'];
        $transaction->save();

        return Transaction::find($saleId);
    }

    public function deleteTechnicianSale($saleId)
    {
        $transaction = Transaction::find($saleId);
        if(!$transaction->delete()){
            return false;
        }
        return true;
    }
}
