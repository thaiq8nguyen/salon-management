<?php
namespace Salon\Repositories\PayPeriodRepository;

interface PayPeriodRepositoryInterface{


    public function getCurrentPayPeriodId();

    public function getPreviousPayPeriodId();



}