<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

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
        // Fetch the products from URL
        $url = 'https://kinfirm.com/app/uploads/laravel-task/products.json';
        $response = Http::get($url);

        // Ensure successful request
        if ($response->successful()) {
            $products = $response->json();

            // Store products in the database table
            foreach ($products as $productData) {
                $product = Product::updateOrCreate(
                    ['sku' => $productData['sku']],
                    [
                        'description' => $productData['description'],
                        'size' => $productData['size'],
                        'photo' => $productData['photo'],
                        'updated_at' => Carbon::parse($productData['updated_at']),
                    ]
                );

                // If product has tags add them
                if (!empty($productData['tags'])) {
                    $tagIds = [];
                    foreach ($productData['tags'] as $tagData) {
                        $tag = Tag::firstOrCreate(['title' => $tagData['title']]);
                        $tagIds[] = $tag->id;
                    }
                    $product->tags()->sync($tagIds);
                }
            }

            $this->info('Products successfully imported.');
        } else {
            $this->error('Failed to fetch products from the provided URL.');
        }
    }
}
