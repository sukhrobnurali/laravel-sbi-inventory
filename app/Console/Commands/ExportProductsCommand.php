<?php

namespace App\Console\Commands;

use App\Services\ProductService;
use Illuminate\Console\Command;

class ExportProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'products:export';

    /**
     * The console command description.
     */
    protected $description = 'Dispatch queued Excel export of all products';

    private ProductService $service;

    public function __construct(ProductService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle(): int
    {
        $this->info('Dispatching export job...');
        $this->service->exportToExcel();
        $this->info('Export job dispatched.');
        return 0;
    }
}
