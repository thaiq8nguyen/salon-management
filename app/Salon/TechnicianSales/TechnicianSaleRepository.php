<?php
namespace App\Salon\TechnicianSaleRepository;

use Illuminate\Database\Eloquent\Builder;

use App\TransactionType;
use App\Transaction;
use App\User;

class TechnicianSaleRepository implements TechnicianSaleInterface
{
    public function addTechnicianSale($technicianId, $sale)
    {
        $saleTransaction = TransactionType::where('name', 'technician sale')->first();
        
        $tipTransaction = TransactionType::where('name', 'technician tip')->first();


        

        //$sale = Transaction::create(['owner_id' => $technicianId, '']);
    }

    public function updateTechnicianSale($saleId, $sale)
    {
    }

    public function deleteTechnicianSale($saleId)
    {
    }
}
