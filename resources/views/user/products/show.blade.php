@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">{{ $product->name }}</h1>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">{{ __('Back to products') }}</a>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4 mb-md-0">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 260px;">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 320px; object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center text-white w-100" style="height: 260px;">
                            <span class="fs-4">{{ __('No image') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="mb-3 text-muted">
                        @if($product->category)
                            {{ __('Category') }}: <span class="fw-semibold">{{ $product->category->name }}</span>
                        @else
                            <span class="text-muted">{{ __('No category') }}</span>
                        @endif
                    </div>

                    @if($product->description)
                        <p class="mb-4">{{ $product->description }}</p>
                    @else
                        <p class="mb-4 text-muted">{{ __('No description provided for this product.') }}</p>
                    @endif

                    <div class="mt-auto d-flex flex-column flex-sm-row align-items-sm-center justify-content-between">
                        <div class="mb-3 mb-sm-0">
                            <div class="text-muted small">{{ __('Price') }}</div>
                            <div class="h3 mb-0">{{ number_format($product->price, 2) }}</div>
                        </div>

                        <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            <label for="quantity" class="me-2 mb-0">{{ __('Quantity') }}</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control me-3" style="width: 90px;">
                            <button type="submit" class="btn btn-success">
                                {{ __('Add to cart') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

