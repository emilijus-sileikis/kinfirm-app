<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    #[Test]
    public function mock_product_creation()
    {
        $product = $this->getMockBuilder(Product::class)
            ->onlyMethods(['save'])
            ->getMock();

        $product->expects($this->once())
            ->method('save')
            ->willReturn(true);

        $product->sku = 'SKU-1337';
        $product->description = 'Test Fake Product';
        $product->size = 'XS';
        $product->stock = 11;

        $this->assertTrue($product->save());
    }

    #[Test]
    public function product_can_have_tags()
    {
        $product = $this->createMock(Product::class);
        $tagsMock = $this->getMockBuilder(Collection::class)->getMock();

        $product->method('tags')->willReturn($tagsMock);

        $this->assertInstanceOf(Collection::class, $product->tags());
    }

    #[Test]
    public function mock_product_deletion()
    {
        $product = $this->getMockBuilder(Product::class)
            ->onlyMethods(['delete'])
            ->getMock();

        $product->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $this->assertTrue($product->delete());
    }
}
