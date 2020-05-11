<?php
namespace App\Salon\TechnicianSales;

interface TechnicianSaleInterface
{
    public function getTechnicianSales($date);

    public function addTechnicianSale($sale);

    public function updateTechnicianSale($saleId, $sale);

    public function deleteTechnicianSale($saleId);
}
