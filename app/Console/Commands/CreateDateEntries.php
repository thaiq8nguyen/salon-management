<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Salon\Date\DateInterface;

class CreateDateEntries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quarter:create-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create date rows to the dates table starting from now to the end of the quarter';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $date;
    public function __construct(DateInterface $date)
    {
        parent::__construct();

        $this->date = $date;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->date->create();
    }
}
