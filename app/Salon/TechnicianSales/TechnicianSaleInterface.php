<?php
namespace App\Salon\TechnicianSales;

interface TechnicianSaleInterface
{
    //public function getTechnicianSales();

    public function addTechnicianSale($technicianId, $sale);

    public function updateTechnicianSale($saleId, $sale);

    public function deleteTechnicianSale($saleId);
}
