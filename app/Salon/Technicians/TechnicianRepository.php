<?php

namespace App\Salon\Technicians;

use App\Role;
use Illuminate\Database\Eloquent\Builder;

use App\Technician;


class TechnicianRepository implements TechnicianInterface
{

    public function getTechnicians()
    {
        $technicians = Technician::active()->get();

        return $technicians->makeVisible(['firstName','lastName','fullName'])->toArray();

    }

    public function addTechnician($technician)
    {
        $technician = Technician::create([
            'first_name' => $technician['first_name'],
            'last_name' => $technician['last_name'],
            'email' => $technician['email']
        ]);


        return $technician;


    }

    public function updateTechnician($technicianId, $data)
    {
        $technician = Technician::find($technicianId);

        $technician->update($data);

        return Technician::find($technicianId);

    }

    public function deleteTechnician($technicianId)
    {
        $technician = Technician::find($technicianId);

        $row = $technician->delete();

        return $row;
    }


}
