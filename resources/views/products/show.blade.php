@extends('layouts.app')

@section('content')
    <div class="container mt-5 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="mb-4 text-2xl font-bold">Product: {{ $product->sku }}</h1>

        <a href="{{ route('products.index') }}" class="btn btn-secondary mb-4">Back to Products</a>

        <div class="mt-16 grid p-4 content-center justify-center">

            <div class="mx-auto mt-11 w-80 transform overflow-hidden rounded-lg bg-white">
                <img src="{{ $product->photo }}" class="h-48 w-full object-cover object-center" alt="{{ $product->description }}">
                <div class="p-4">
                    <h5 class="mb-2 text-lg font-medium text-gray-900">{{ $product->description }}</h5>
                    <p class="mb-2 text-base text-gray-700">Size: {{ $product->size }}</p>
                    <p class="mb-2 text-base text-gray-700">SKU: {{ $product->sku }}</p>

                    @if($product->tags->isNotEmpty())
                        <p class="card-text">Tags:
                            @foreach($product->tags as $index => $tag)
                                <span class="badge bg-primary">{{ $tag->title }}@if(!$loop->last), @endif</span>
                            @endforeach
                        </p>
                    @endif

                    <div class="flex items-center">
                        <p class="ml-auto text-base font-medium {{ $stock > 0 ? 'text-green-500' : 'text-red-500' }}">
                            Stock: {{ $stock }}
                        </p>
                    </div>
                </div>
            </div>

            @if($relatedProducts->isNotEmpty())
                <div class="mt-16">
                    <h2 class="text-xl font-semibold mb-4">Related Products</h2>
                    <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 p-4">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                                <div class="relative w-full h-48">
                                    <img src="{{ $relatedProduct->photo }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $relatedProduct->description }}">
                                </div>

                                <div class="p-4">
                                    <h5 class="text-lg font-semibold">{{ $relatedProduct->description }}</h5>
                                    <p class="text-sm text-gray-600">Size: {{ $relatedProduct->size }}</p>
                                    <a href="{{ route('products.show', $relatedProduct->id) }}" class="btn btn-primary mt-2">View Details</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
