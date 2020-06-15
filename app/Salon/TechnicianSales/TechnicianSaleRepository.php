<?php

namespace App\Salon\TechnicianSales;

use App\Technician;

use App\TechnicianAccount;
use App\Transaction;
use App\TransactionItem;
use Carbon\Carbon;

class TechnicianSaleRepository implements TechnicianSaleInterface
{
    public function getAllTechnicianSales($date)
    {
        $technicians = null;

        $technicians = Technician::with([
            'sales' => function ($query) use ($date) {
                $query->where('date', $date);
            }
        ])->get();

        $sales = $technicians->map(function ($technician) {
            $sale = $technician->sales->filter(function ($transaction) {
                return $transaction->name == 'technician sales';
            })->first();

            $tip = $technician->sales->filter(function ($transaction) {
                return $transaction->name == 'technician tips';
            })->first();

            return [
                'technicianId' => $technician->id,
                'sale' => $sale ? ['id' => $sale->id, 'amount' => $sale->credit] : null,
                'tip' => $tip ? ['id' => $tip->id, 'amount' => $tip->credit] : null,

            ];
        });

        return ['date' => $date, 'sales' => $sales];

    }

    public function addTechnicianSale($date, $transactions)
    {

        foreach ($transactions as $transaction) {
            if (isset($transaction['saleAmount'])) {

                $technicianSaleAccount = TechnicianAccount::where([
                    ['technician_id', $transaction['technicianId']],
                    ['name', 'sales']
                ])->first();

                $transactionSaleItem = TransactionItem::item('technician sales')->first();

                $existingSaleTransaction = Transaction::where([
                    ['transactionable_id', $technicianSaleAccount->id],
                    ['date', $date]
                ])->first();

                if (!$existingSaleTransaction) {
                    $technicianSaleAccount->transactions()->create([
                        'transaction_item_id' => $transactionSaleItem->id,
                        'date' => $date,
                        'credit' => $transaction['saleAmount'],
                    ]);
                }

            }

            if (isset($transaction['tipAmount'])) {

                $technicianTipAccount = TechnicianAccount::where([
                    ['technician_id', $transaction['technicianId']],
                    ['name', 'tips']
                ])->first();

                $transactionTipItem = TransactionItem::item('technician tips')->first();

                $existingTipAccount = Transaction::where([
                    ['transactionable_id', $technicianTipAccount->id],
                    ['date', $date]
                ])->first();

                if (!$existingTipAccount) {
                    $technicianTipAccount->transactions()->create([
                        'transaction_item_id' => $transactionTipItem->id,
                        'date' => $date,
                        'credit' => $transaction['tipAmount'],
                    ]);
                }

            }
        }
        return $this->getAllTechnicianSales($date);

    }

    public function updateTechnicianSale($saleId, $amount)
    {
        $transaction = Transaction::find($saleId);
        $transaction->credit = $amount;
        $transaction->save();

        $technicianAccount = TechnicianAccount::find($transaction->transactionable_id);

        return $this->getAllTechnicianSales($transaction->date);

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
