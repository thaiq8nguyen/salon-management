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

    public function addTechnicianSale(Request $request)
    {
        $technicianSale = $this->technicianSale->addTechnicianSale($request->all());

        return $this->sendResponse(['name' => 'technician sale', 'value' => $technicianSale]);
        //return $this->sendResponse(['name' => 'hello', 'value' => 'world']);
    }
}
