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

    public function getTechnicianSales($date)
    {
        $technicianSales = $this->technicianSale->getTechnicianSales($date);

        return $this->sendResponse(['name' => 'technician sales', 'value' => $technicianSales]);
    }


    public function addTechnicianSale(Request $request)
    {
        $newTechnicianSale = $this->technicianSale->addTechnicianSale($request->all());

        return $this->sendResponse(['name' => 'new technician sale', 'value' => $newTechnicianSale]);
        //return $this->sendResponse(['name' => 'hello', 'value' => 'world']);
    }

    public function updateTechnicianSale($saleId, Request $request)
    {
        $updatedSale = $this->technicianSale->updateTechnicianSale( $saleId, $request->all());

        return $this->sendResponse(['name' => 'update technician sale', 'value' =>$updatedSale]);
    }

    public function deleteTechnicianSale($saleId)
    {
        $deletedSale = $this->technicianSale->deleteTechnicianSale($saleId);

        return $this->sendResponse(['name' => 'delete technician sale', 'value' => true]);
    }

}
