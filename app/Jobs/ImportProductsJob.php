<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $url = 'https://kinfirm.com/app/uploads/laravel-task/products.json';
        $response = Http::get($url);

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

            Log::info('Products successfully imported.');
        } else {
            Log::info('Failed to fetch products from the provided URL.');
        }
    }
}
