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
                        <tr data-price="{{ $item['price'] }}" data-update-url="{{ route('cart.update', $productId) }}">
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
                                <input type="number"
                                       name="quantity"
                                       min="1"
                                       value="{{ $item['quantity'] }}"
                                       class="qty-input form-control form-control-sm d-inline-block text-end"
                                       style="width:80px;">
                            </td>
                            <td class="text-end item-subtotal">
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
                        <th class="text-end" id="cart-total">{{ number_format($total, 2) }}</th>
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

@push('scripts')
<script>
    document.querySelectorAll('.qty-input').forEach(function (input) {
    input.addEventListener('input', function () {
        const row = this.closest('tr');
        const price = parseFloat(row.dataset.price);
        const quantity = Math.max(1, parseInt(this.value) || 1);

        row.querySelector('.item-subtotal').textContent = (price * quantity).toFixed(2);

        let total = 0;
        document.querySelectorAll('.item-subtotal').forEach(function (cell) {
            total += parseFloat(cell.textContent);
        });
        document.getElementById('cart-total').textContent = total.toFixed(2);
    });

    input.addEventListener('change', function () {
        const row = this.closest('tr');
        const quantity = Math.max(1, parseInt(this.value) || 1);
        this.value = quantity;

        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        formData.append('_method', 'PATCH');
        formData.append('quantity', quantity);

        fetch(row.dataset.updateUrl, { method: 'POST', body: formData });
    });
});
</script>
@endpush
@endsection

