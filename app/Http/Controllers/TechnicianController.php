<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salon\Technicians\TechnicianInterface;

class TechnicianController extends BaseController
{
    protected $technician;

    public function __construct(TechnicianInterface $technician)
    {
        $this->technician = $technician;
    }

    public function get()
    {
        $technicians = $this->technician->getTechnicians();
        return $this->sendResponse(['name' => 'technicians', 'value' => $technicians]);

    }

    public function add(Request $request)
    {
        $technician = $this->technician->addTechnician($request);
        return $this->sendResponse(['name' => 'technician', 'value' => $technician]);
    }

    public function update($id,Request $request)
    {
        $technician = $this->technician->updateTechnician($id, $request->all());
        return $this->sendResponse(['name' => 'technician', 'value' => $technician]);


    }

    public function delete($id)
    {
        $technician = $this->technician->deleteTechnician($id);
        return $this->sendResponse(['name' => 'technician', 'value' => $technician]);
    }
}
