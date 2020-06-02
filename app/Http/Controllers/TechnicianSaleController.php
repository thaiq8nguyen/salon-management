<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Salon\TechnicianSales\TechnicianSaleInterface;

class TechnicianSaleController extends BaseController
{
    protected $technicianSale;

    public function __construct(TechnicianSaleInterface $technicianSale)
    {
        $this->technicianSale = $technicianSale;
    }

    public function getTechnicianSales(Request $request)
    {
        $technicianSales = $this->technicianSale->getTechnicianSales(null,$request->query('date'));

        return $this->sendResponse(['name' => 'allTechnicianSales', 'value' => $technicianSales]);
    }


    public function addTechnicianSale(Request $request)
    {
        $technicianSales = $this->technicianSale->addTechnicianSale($request->all());

        return $this->sendResponse(['name' => 'allTechnicianSales', 'value' => $technicianSales]);

    }

    public function updateTechnicianSale($saleId, Request $request)
    {
        $updatedSale = $this->technicianSale->updateTechnicianSale($saleId, $request->input('amount'));

        return $this->sendResponse(['name' => 'updateTechnicianSale', 'value' =>$updatedSale]);
    }

    public function deleteTechnicianSale($saleId)
    {
        $deletedSale = $this->technicianSale->deleteTechnicianSale($saleId);

        return $this->sendResponse(['name' => 'delete_technician_sale', 'value' => $deletedSale]);
    }

}
