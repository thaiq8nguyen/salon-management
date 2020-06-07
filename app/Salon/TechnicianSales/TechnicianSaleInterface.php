<?php
namespace App\Salon\TechnicianSales;

interface TechnicianSaleInterface
{
    public function getTechnicianSales($technicianId = null, $date);

    public function addTechnicianSale($date, $transactions);

    public function updateTechnicianSale($saleId, $sale);

    public function deleteTechnicianSale($saleId);


}
