<?php
namespace App\Salon\Technicians;

interface TechnicianInterface{

    public function getTechnicians();

    public function addTechnician($technician);

    public function editTechnician($technicianId, $technician);

    public function deleteTechnician($technicianId);

}
