<?php
namespace App\Salon\Technicians;

interface TechnicianInterface{

    public function getTechnicians();

    public function addTechnician();

    public function editTechnician($technicianId);

    public function deleteTechnician($technicianId);

}
