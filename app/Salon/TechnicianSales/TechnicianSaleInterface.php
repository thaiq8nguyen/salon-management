<?php
namespace App\Salon\TechnicianSales;

interface TechnicianSaleInterface
{
    public function getAllTechnicianSales($date);

    public function getTechnicianSale($technicianId, $date);

    public function addTechnicianSale($date, $transactions);

    public function updateTechnicianSale($saleId, $sale);

    public function deleteTechnicianSale($saleId);


}
