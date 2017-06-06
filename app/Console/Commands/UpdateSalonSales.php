<?php

namespace App\Console\Commands;
use Salon\Sales\Salon;
use Illuminate\Console\Command;

class UpdateSalonSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:salon-sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update salon-sales table with Square sale data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Salon::getSquareDailySaleMetrics();
    }
}
