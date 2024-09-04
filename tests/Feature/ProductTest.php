<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Tag;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductTest extends TestCase
{
    #[Test]
    public function view_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product->id));

        $response->assertStatus(200);
        $response->assertSee($product->description);
        $response->assertSee($product->sku);
        $response->assertSee($product->size);
    }

    #[Test]
    public function show_related_products_based_on_tags()
    {
        $product = Product::factory()->create();
        $relatedProducts = Product::factory()->count(3)->create();

        $tag = Tag::factory()->create();
        $product->tags()->attach($tag->id);
        foreach ($relatedProducts as $relatedProduct) {
            $relatedProduct->tags()->attach($tag->id);
        }

        $response = $this->get(route('products.show', $product->id));

        foreach ($relatedProducts as $relatedProduct) {
            $response->assertSee($relatedProduct->description);
        }
    }
}
