
@php
    $products = \App\Models\Product::withAvg('reviews', 'rating')->withCount('reviews')
        ->with(['variants', 'category', 'productImageGalleries'])->get();

    $productsInRowsOfFour = $products->chunk(4);
@endphp
@foreach ($productsInRowsOfFour as $group)
<div class="container">
    <div class="row">
        <div class="content-section" style="display: flex;">
            @foreach ($group as $product)
            <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</div>
@endforeach