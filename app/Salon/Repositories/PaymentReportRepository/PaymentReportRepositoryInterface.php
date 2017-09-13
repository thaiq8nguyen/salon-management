<?php
namespace Salon\Repositories\PaymentReportRepository;

interface PaymentReportRepositoryInterface{

    public function all();

    public function create($technicianId, $payPeriodId);

    public function store($file);

    public function update($technicianId, $payPeriodId);

    public function url($technicianId, $payPeriodId);

    public function listReports($technicianId);

    public function delete($file);

    public function preview($technicianId, $payPeriodId);






}