<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('tags')->paginate(9);

        // Retireve the 10 most popular tag ids
        $popularTags = DB::table('tags')
            ->join('product_tag', 'tags.id', '=', 'product_tag.tag_id')
            ->select('tags.title', DB::raw('count(product_tag.tag_id) as product_count'))
            ->groupBy('tags.id', 'tags.title')
            ->orderByDesc('product_count')
            ->limit(10)
            ->get();

        return view('products.index', compact('products', 'popularTags'));
    }

    public function show($id)
    {
        // Retrieve product details from cache
        $product = Cache::remember("product_details_{$id}", now()->addMinutes(30), function() use ($id) {
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
