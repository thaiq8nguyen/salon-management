<?php

namespace Salon\Repositories\TechnicianRepository;

use App\Technician;

class TechnicianRepository implements TechnicianRepositoryInterface {

    public function getAll(){

        return Technician::all()->orderBy('last_name')->get();
    }

    public function getTechnicianById($id)
    {

        return Technician::find($id)->get();
    }


    public function getTechnicianByFirstName($firstName)
    {
        return Technician::where('first_name','=',$firstName)->get();
    }

    /**
     * Return technician collection filtering by position
     * @param $category
     * @return mixed
     */
    public function getTechnicianByCategoryLimited($category)
    {
        $technicians = Technician::where('technician_category','=',$category)->get();

        $filtered = [];

        foreach($technicians as $technician){
            array_push($filtered,['id' => $technician->id, 'first_name' => $technician->first_name, 'full_name' => $technician->full_name]);
        }

        return $filtered;
    }


}