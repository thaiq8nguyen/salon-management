<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

/**
 * Class TransactionItem
 * @mixin Eloquent;
 */
class TransactionItem extends Model
{
    public function scopeItem($query, $item)
    {
        return $query->where('name', $item);
    }
}
