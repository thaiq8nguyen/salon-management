<?php
namespace App\Salon\TransactionTypes;

use App\TransactionType;

class TransactionTypeRepository implements TransactionTypeInterface
{
    public function getTransactionType($name)
    {
        $transaction = TransactionType::where('name', $name)->first();
        return $transaction;
    }
}
