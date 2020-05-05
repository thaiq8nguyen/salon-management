<?php
namespace App\Salon\TransactionTypes;

interface TransactionTypeInterface
{
    public function getTransactionType($name);
}
