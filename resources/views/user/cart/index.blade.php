@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('Cart') }}</h1>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(empty($cart))
        <div class="card">
            <div class="card-body text-center text-muted py-5">
                <p class="mb-0">{{ __('Your cart is empty.') }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">{{ __('Go shopping') }}</a>
            </div>
        </div>
    @else
        <div class="table-responsive mb-3">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">{{ __('Image') }}</th>
                        <th>{{ __('Product') }}</th>
                        <th class="text-end" style="width:120px;">{{ __('Price') }}</th>
                        <th class="text-end" style="width:120px;">{{ __('Quantity') }}</th>
                        <th class="text-end" style="width:120px;">{{ __('Subtotal') }}</th>
                        <th class="text-end" style="width:100px;">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $productId => $item)
                        <tr>
                            <td>
                                @if(!empty($item['image']))
                                    <img src="{{ asset('storage/'.$item['image']) }}" alt="" class="rounded" style="width:48px;height:48px;object-fit:cover;">
                                @else
                                    <div class="bg-secondary rounded text-white d-flex align-items-center justify-content-center" style="width:48px;height:48px;">—</div>
                                @endif
                            </td>
                            <td>{{ $item['name'] }}</td>
                            <td class="text-end">{{ number_format($item['price'], 2) }}</td>
                            <td class="text-end">
                                <form action="{{ route('cart.update', $productId) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number"
                                           name="quantity"
                                           min="1"
                                           value="{{ $item['quantity'] }}"
                                           class="form-control form-control-sm d-inline-block text-end"
                                           style="width:80px;"
                                           onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="text-end">
                                {{ number_format($item['price'] * $item['quantity'], 2) }}
                            </td>
                            <td class="text-end">
                                <form action="{{ route('cart.remove', $productId) }}" method="POST" onsubmit="return confirm('{{ __('Remove this item?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Remove') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">{{ __('Total') }}:</th>
                        <th class="text-end">{{ number_format($total, 2) }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between">
            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('{{ __('Clear cart?') }}');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-secondary">{{ __('Clear cart') }}</button>
            </form>

            <form action="{{ route('orders.storeOffline') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    {{ __('Place order (offline payment)') }}
                </button>
            </form>
        </div>
    @endif
</div>
@endsection

