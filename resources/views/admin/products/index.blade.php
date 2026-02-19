@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">{{ __('Products Management') }}</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">{{ __('Add product') }}</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($products->isEmpty())
        <div class="card">
            <div class="card-body text-center text-muted py-5">
                <p class="mb-0">{{ __('No products yet.') }}</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary mt-3">{{ __('Create first product') }}</a>
            </div>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">{{ __('Image') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th class="text-end">{{ __('Price') }}</th>
                        <th style="width: 200px;" class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
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
                                    <div class="small text-muted text-truncate" style="max-width: 240px;">{{ $product->description }}</div>
                                @endif
                            </td>
                            <td>
                                @if($product->category)
                                    {{ $product->category->name }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-end">{{ number_format($product->price, 2) }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-secondary">{{ __('View') }}</a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary">{{ __('Edit') }}</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Delete this product?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">{{ __('Delete') }}</button>
                                    </form>
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
