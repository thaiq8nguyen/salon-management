<?php

namespace App\Salon\Technicians;
use App\Role;
use App\User;


class TechnicianRepository implements TechnicianInterface {

    public function getTechnicians()
    {
        $technicians = User::has('roles')->where('name','technician')->get();

        return $technicians;

    }

    public function addTechnician()
    {

    }

    public function editTechnician($technicianId)
    {

    }

    public function deleteTechnician($technicianId)
    {

    }






}
