<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import stock from JSON';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch the stock data from URL
        $response = Http::get('https://kinfirm.com/app/uploads/laravel-task/stocks.json');

        if ($response->successful()) {
            $stocks = $response->json();

            // Parse stock data and update products
            foreach ($stocks as $stockData) {
                $product = Product::where('sku', $stockData['sku'])->first();
                if ($product) {
                    $product->stock = $stockData['stock'];
                    $product->save();
                }
            }

            $this->info('Stock data successfully imported');
        } else {
            $this->error('Failed to fetch the JSON file.');
        }
    }
}
