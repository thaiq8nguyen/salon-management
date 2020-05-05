<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salon\TransactionItems\TransactionItemInterface;

class TransactionItemController extends BaseController
{
    protected $transationItem;

    public function __construct(TransactionItemInterface $transactionItem)
    {
        $this->transationItem = $transactionItem;
    }

    public function all()
    {
        $transactionItems = $this->transationItem->getTransactionItems();
        return $this->sendResponse(['name' => 'transaction items', 'value' => $transactionItems]);
    }
}
