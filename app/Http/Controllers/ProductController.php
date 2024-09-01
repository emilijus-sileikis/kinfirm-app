<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('tags')->paginate(9);

        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        // Retrieve product details from cache
        $product = Cache::remember("product_details_{$id}", now()->addMinutes(10), function() use ($id) {
            return Product::with('tags')->where('id', $id)->firstOrFail();
        });

        // Real time stock value
        $stock = Product::where('id', $id)->value('stock');

        // Get the tags
        $tags = $product->tags->pluck('id');

        // Retrieve related products with the same tags and exclude the current product
        $relatedProducts = Cache::remember("related_products_{$id}", now()->addMinutes(10), function() use ($tags, $id) {
            return Product::whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('id', $tags);
            })->where('id', '!=', $id)->with('tags')->get();
        });

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'stock' => $stock,
        ]);
    }

    public function export()
    {
        $products = Product::with('tags')->get();

        return response()->json($products);
    }
}
