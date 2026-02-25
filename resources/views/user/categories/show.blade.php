@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">{{ __('Categories') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="mb-4">
        <h1 class="h2 mb-2">{{ $category->name }}</h1>
        @if($category->description)
            <p class="text-muted mb-0">{{ $category->description }}</p>
        @endif
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm mt-2">{{ __('Back to list') }}</a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">{{ __('Products in this category') }}</h2>
        <div class="d-flex gap-2 align-items-center flex-wrap justify-content-end">
            <input id="product-search" type="search" class="form-control form-control-sm" placeholder="{{ __('Search by name…') }}" style="width: 200px;" autocomplete="off">
            <span class="text-muted small">{{ __('Sort by:') }}</span>
            @foreach(['name' => __('Name'), 'price' => __('Price')] as $col => $label)
                @php
                    $isActive = $sort === $col;
                    $newDir = ($isActive && $direction === 'asc') ? 'desc' : 'asc';
                @endphp
                <a href="{{ route('categories.show', [$category, 'sort' => $col, 'direction' => $newDir]) }}"
                   class="btn btn-sm {{ $isActive ? 'btn-secondary' : 'btn-outline-secondary' }}">
                    {{ $label }}
                    @if($isActive)
                        {{ $direction === 'asc' ? '↑' : '↓' }}
                    @endif
                </a>
            @endforeach
        </div>
    </div>

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
                                <a href="{{ route('products.show', $product) }}" class="text-decoration-none fw-medium">{{ $product->name }}</a>
                                @if($product->description)
                                    <div class="small text-muted text-truncate" style="max-width: 280px;">{{ $product->description }}</div>
                                @endif
                            </td>
                            <td class="text-end">{{ number_format($product->price, 2) }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary">{{ __('View') }}</a>
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-outline-success">{{ __('Add to cart') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr id="products-no-results" style="display:none;">
                        <td colspan="4" class="text-center text-muted py-4">{{ __('No products match your search.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const input = document.getElementById('product-search');
        if (!input) return;
        const tbody = document.querySelector('table tbody');
        const noResults = document.getElementById('products-no-results');

        input.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            let visible = 0;
            tbody.querySelectorAll('tr:not(#products-no-results)').forEach(function (row) {
                const name = (row.cells[1] ? row.cells[1].textContent : '').toLowerCase();
                const match = name.includes(query);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            noResults.style.display = visible === 0 ? '' : 'none';
        });
    })();
</script>
@endpush
