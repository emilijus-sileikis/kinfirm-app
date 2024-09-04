@extends('layouts.app')

@section('content')
    <div class="container mt-5 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="mb-4 text-2xl font-bold">Products</h1>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Most Popular Tags Section -->
            <div class="order-1 lg:order-2 self-start bg-gray-100 p-4 rounded-lg shadow-lg flex flex-col items-center">
                <h2 class="text-xl font-bold mb-4">Top 10 Tags</h2>
                <ul>
                    @foreach($popularTags as $tag)
                        <li class="mb-2">
                            <a href="#" class="text-blue-500 hover:text-blue-700">
                                #{{ $tag->title }} ({{ $tag->product_count }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Products Section -->
            <div class="order-2 lg:order-1 lg:col-span-3">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 p-4">
                    @foreach($products as $product)
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">

                            <div class="relative w-full h-48">
                                <img src="{{ $product->photo }}"
                                     class="absolute inset-0 w-full h-full object-cover"
                                     alt="{{ $product->description }}">
                            </div>

                            <div class="p-4">
                                <h5 class="text-lg font-semibold">{{ $product->description }}</h5>
                                <p class="text-sm text-gray-600">Size: {{ $product->size }}</p>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary mt-2">View Details</a>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
