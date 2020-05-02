<?php

namespace App\Salon\Technicians;

use App\Role;
use Illuminate\Database\Eloquent\Builder;

use App\User;


class TechnicianRepository implements TechnicianInterface
{

    public function getTechnicians()
    {
        $technicians = User::whereHas('roles', function (Builder $query) {
            $query->where('name', 'technician');
        })->get();

        return $technicians;

    }

    public function addTechnician($technician)
    {
        $technician = User::create([
            'first_name' => $technician['first_name'],
            'last_name' => $technician['last_name'],
            'email' => $technician['email'],
            'password' => bcrypt($technician['password'])
        ]);

        $role = Role::where('name', 'technician')->first();

        $technician->roles()->attach($role->id);


        return $technician;


    }

    public function updateTechnician($technicianId, $data)
    {
        $technician = User::find($technicianId);

        $technician->update($data);

        return User::find($technicianId);

    }

    public function deleteTechnician($technicianId)
    {
        $technician = User::find($technicianId);

        $row = $technician->delete();

        return $row;
    }


}
