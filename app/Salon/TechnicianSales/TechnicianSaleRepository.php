<?php

namespace App\Salon\TechnicianSales;

use App\Technician;
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

        $sales = Technician::with(['sales' => function($query) use ($date){
            $query->where('date', '2020-05-12');
        }])->get(['id','first_name','last_name']);

        return $sales;


    }

    public function addTechnicianSale($sale)
    {

        $saleAccount = Account::where([['technician_id', $sale['technician_id']], ['name', 'sales']])->first();
        $tipAccount = Account::where([
            ['technician_id', $sale['technician_id']],
            ['name', 'tips']
        ])->first();

        $saleTransaction = '';
        if ($sale['sales']) {
            $saleItem = TransactionItem::item('technician sales')->first();

            $saleTransaction = Transaction::create([
                'account_id' => $saleAccount->id,
                'transaction_item_id' => $saleItem->id,
                'date' => $sale['date'],
                'description' => $sale['description'] ? $sale['description'] : '',
                'credit' => $sale['sales'],
            ]);
        }

        $tipTransaction = '';
        if ($sale['tips']) {
            $tipItem = TransactionItem::item('technician tips')->first();
            $tipTransaction = Transaction::create([
                'account_id' => $tipAccount->id,
                'transaction_item_id' => $tipItem->id,
                'date' => $sale['date'],
                'description' => $sale['description'] ? $sale['description'] : '',
                'credit' => $sale['tips'],
            ]);
        }

        return ['sale' => $saleTransaction, 'tip' => $tipTransaction];

    }

    public function updateTechnicianSale($saleId, $sale)
    {
        $transaction = Transaction::find($saleId);
        $transaction->credit = $sale;
        $transaction->save();

        return Transaction::find($saleId);
    }

    public function deleteTechnicianSale($saleId)
    {
        // find the deleting sale transaction
        $transaction = Transaction::find($saleId);

        // delete the sale transaction
        if (!$transaction->delete()) {
            return false;
        }
        return true;


    }
}
