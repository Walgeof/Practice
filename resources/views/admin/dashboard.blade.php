@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('Admin Dashboard') }}</h1>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Products') }}</h5>
                    <h2 class="mb-0">{{ $stats['products_count'] }}</h2>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary mt-2">{{ __('Manage') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Categories') }}</h5>
                    <h2 class="mb-0">{{ $stats['categories_count'] }}</h2>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-primary mt-2">{{ __('Manage') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body d-flex flex-column align-items-start">
                    <h5 class="card-title">{{ __('Pending orders') }}</h5>
                    <h2 class="mb-0">{{ $stats['pending_orders_count'] }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Pending orders') }}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['pending_orders'] as $idx => $order)
                                    <tr>
                                        <td>{{ $idx + 1 }}</td>
                                        <td>{{ $order->user?->name ?? __('Guest') }}</td>
                                        <td>{{ $order->created_at?->format('d.m.Y') }}</td>
                                        <td>{{ number_format($order->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($stats['pending_orders']->isEmpty())
                            <p class="mb-0 text-muted">{{ __('No pending orders.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
