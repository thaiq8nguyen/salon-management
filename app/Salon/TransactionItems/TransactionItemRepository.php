<?php
namespace App\Salon\TransactionItems;

use App\TransactionItem;

class TransactionItemRepository implements TransactionItemInterface
{
    public function getTransactionItems()
    {
        $transactionItems = TransactionItem::all()->get();
        return $transactionItems;
    }
}
