@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ __('Products') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">{{ $product->name }}</h1>
        <div class="btn-group">
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary">{{ __('Edit') }}</a>
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Delete this product?') }}');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">{{ __('Delete') }}</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 col-lg-4 mb-4">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm">
            @else
                <div class="bg-secondary rounded d-flex align-items-center justify-content-center text-white fs-1" style="aspect-ratio: 1;">{{ __('No image') }}</div>
            @endif
        </div>
        <div class="col-md-7 col-lg-8">
            <p class="text-muted mb-2">
                @if($product->category)
                    {{ __('Category') }}: {{ $product->category->name }}
                @else
                    {{ __('Category') }}: —
                @endif
            </p>
            <p class="h4 text-primary mb-3">{{ number_format($product->price, 2) }}</p>
            @if($product->description)
                <div class="border-top pt-3">
                    <h5 class="h6 text-muted text-uppercase mb-2">{{ __('Description') }}</h5>
                    <p class="mb-0">{{ $product->description }}</p>
                </div>
            @endif
            <div class="mt-4">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">{{ __('Back to list') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
