@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">{{ __('Categories') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-2">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-muted mb-0">{{ $category->description }}</p>
            @endif
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary">{{ __('Edit') }}</a>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Delete this category?') }}');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">{{ __('Delete') }}</button>
            </form>
        </div>
    </div>

    <h2 class="h5 mb-3">{{ __('Products in this category') }}</h2>

    @if($category->products->isEmpty())
        <div class="card">
            <div class="card-body text-center text-muted py-5">
                <p class="mb-0">{{ __('No products in this category.') }}</p>
            </div>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">{{ __('Image') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th class="text-end">{{ __('Price') }}</th>
                        <th style="width: 180px;" class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category->products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="" class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px;">—</div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.show', $product) }}" class="text-decoration-none fw-medium">{{ $product->name }}</a>
                                @if($product->description)
                                    <div class="small text-muted text-truncate" style="max-width: 280px;">{{ $product->description }}</div>
                                @endif
                            </td>
                            <td class="text-end">{{ number_format($product->price, 2) }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-secondary">{{ __('View') }}</a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary">{{ __('Edit') }}</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
