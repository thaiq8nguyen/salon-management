<?php

namespace App\Salon\TechnicianSales;

use App\Technician;

use App\TechnicianAccount;
use App\Transaction;
use App\TransactionItem;


class TechnicianSaleRepository implements TechnicianSaleInterface
{
    public function getTechnicianSales($date)
    {

        $sales = Technician::with(['sales' => function($query) use ($date){
            $query->where('date', $date);
        }])->get(['id','first_name','last_name']);

        return $sales;


    }

    public function addTechnicianSale($sale)
    {

        $saleAccount = TechnicianAccount::where([['technician_id', $sale['technician_id']], ['name', 'sales']])->first();
        $tipAccount = TechnicianAccount::where([
            ['technician_id', $sale['technician_id']],
            ['name', 'tips']
        ])->first();

        $saleTransaction = '';
        if ($sale['sales']) {
            $saleItem = TransactionItem::item('technician sales')->first();

            $saleTransaction = $saleAccount->transactions()->create([
                'transaction_item_id' => $saleItem->id,
                'date' => $sale['date'],
                'description' =>  $sale['description'],
                'credit' => $sale['sales'],
            ]);
        }

        $tipTransaction = '';
        if ($sale['tips']) {
            $tipItem = TransactionItem::item('technician tips')->first();
            $tipTransaction = $tipAccount->transactions()->create([
                'transaction_item_id' => $tipItem->id,
                'date' => $sale['date'],
                'description' => $sale['description'],
                'credit' => $sale['tips'],
            ]);
        }

        return ['sale' => $saleTransaction, 'tip' => $tipTransaction];

    }

    public function updateTechnicianSale($saleId, $sale)
    {
        $transaction = Transaction::find($saleId);
        $transaction->credit = $sale['credit'];
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
