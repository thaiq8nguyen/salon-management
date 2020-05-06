<?php
namespace App\Salon\TechnicianSaleRepository;

use Illuminate\Database\Eloquent\Builder;

use App\Account;
use App\Customer;
use App\Transaction;
use App\User;

class TechnicianSaleRepository implements TechnicianSaleInterface
{
    public function addTechnicianSale($technicianId, $sale)
    {
        $saleTransaction = Customer::where('name', 'clients')->first();
        
        


        

        //$sale = Transaction::create(['owner_id' => $technicianId, '']);
    }

    public function updateTechnicianSale($saleId, $sale)
    {
    }

    public function deleteTechnicianSale($saleId)
    {
    }
}
