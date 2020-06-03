<?php

namespace App\Salon\TechnicianSales;

use App\Technician;

use App\TechnicianAccount;
use App\Transaction;
use App\TransactionItem;


class TechnicianSaleRepository implements TechnicianSaleInterface
{
    public function getTechnicianSales($technicianId = null ,$date)
    {
        $technicians = null;

        $technicians = Technician::with([
            'sales' => function ($query) use ($date) {
                $query->where('date', $date);
            }
        ])->get();

        if(!empty($technicianId)){
            $technicians = Technician::with([
                'sales' => function ($query) use ($date) {
                    $query->where('date', $date);
                }
            ])->where('id', $technicianId)->get();
        }

        $sales = $technicians->map(function ($technician) {
            $sale = $technician->sales->filter(function ($transaction) {
                return $transaction->name == 'technician sales';
            })->first();

            $tip = $technician->sales->filter(function ($transaction) {
                return $transaction->name == 'technician tips';
            })->first();

            return [
                'technicianId' => $technician->id,
                'firstName' => $technician->first_name,
                'lastName' => $technician->last_name,
                'fullName' => $technician->full_name,
                'sale' => $sale ? ['id' => $sale->id, 'amount' => $sale->credit]:null,
                'tip' => $tip ? ['id' => $tip->id, 'amount' => $tip->credit]:null,

            ];
        });

        return ['date' => $date, 'sales' => $sales];

    }

    public function addTechnicianSale($sale)
    {

        foreach ($sale['transactions'] as $transaction) {
            if ($transaction['saleAmount']) {
                $saleAccount = TechnicianAccount::where([
                    ['technician_id', $transaction['technicianId']],
                    ['name', 'sales']
                ])->first();
                $saleItem = TransactionItem::item('technician sales')->first();

                $saleAccount->transactions()->create([
                    'transaction_item_id' => $saleItem->id,
                    'date' => $sale['date'],
                    'credit' => $transaction['saleAmount'],
                ]);
            }

            if ($transaction['tipAmount']) {

                $tipAccount = TechnicianAccount::where([
                    ['technician_id', $transaction['technicianId']],
                    ['name', 'tips']
                ])->first();
                $tipItem = TransactionItem::item('technician tips')->first();
                $tipAccount->transactions()->create([
                    'transaction_item_id' => $tipItem->id,
                    'date' => $sale['date'],
                    'credit' => $transaction['tipAmount'],
                ]);
            }

        }

        return $this->getTechnicianSales(null, $sale['date']);

    }

    public function updateTechnicianSale($saleId, $amount)
    {
        $transaction = Transaction::find($saleId);
        $transaction->credit = $amount;
        $transaction->save();

        $technicianAccount = TechnicianAccount::find($transaction->transactionable_id);

        return $this->getTechnicianSales($technicianAccount->technician_id, $transaction->date);

    }

    public function deleteTechnicianSale($saleId)
    {
        // find the deleting sale transaction
        $transaction = Transaction::find($saleId);

        $technicianAccount = TechnicianAccount::find($transaction->transactionable_id);

        // delete the sale transaction
        if (!$transaction->delete()) {
            return false;
        }

        return $this->getTechnicianSales($technicianAccount->technician_id, $transaction->date);


    }


}
