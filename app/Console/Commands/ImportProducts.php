<?php

namespace App\Console\Commands;

use App\Jobs\ImportProductsJob;
use Illuminate\Console\Command;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from JSON';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Dispatch import job to the queue
        ImportProductsJob::dispatch();

        $this->info('Product import job successfully dispatched.');
    }
}
