<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salon\Technicians\TechnicianInterface;

class TechnicianController extends BaseController
{
    protected $technician;

    public function __construct(TechnicianInterface $technician)
    {
    }
}
