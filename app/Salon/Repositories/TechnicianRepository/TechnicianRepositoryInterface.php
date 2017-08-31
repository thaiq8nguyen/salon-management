<?php
namespace Salon\Repositories\TechnicianRepository;

interface TechnicianRepositoryInterface{

    public function getAll();

    public function getTechnicianById($id);

    public function getTechnicianByFirstName($firstName);

    public function getTechnicianByCategoryLimited($category);


}