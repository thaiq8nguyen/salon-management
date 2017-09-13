<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class TechnicianPayPeriodReporter extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testReport()
    {
        $this->withoutMiddleware();

        $response = $this->json('get','/api/technician-pay-period/search',['technicianId' => 86, 'payPeriodId' => 8]);

        //$response->assertStatus(200);

        print($response->getContent());
    }
}
