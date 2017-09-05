<?php
namespace Salon\Repositories\PaymentReportRepository;

interface PaymentReportRepositoryInterface{

    public function all();

    public function create($technicianId, $payPeriodId);

    public function store();

    public function update();

    public function show($technicianId, $payPeriodId);

    public function delete();






}