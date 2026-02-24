@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Home page') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                        </div>
                    @endif
                    <a href="{{ route('products.index') }}" class="btn btn-primary mb-4">
                        {{ __('View Products') }}
                    </a>

                    @if($orders->isNotEmpty())
                        <div class="mt-4">
                            <h5 class="mb-3">{{ __('Recent Orders') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Unique items') }}</th>
                                            <th class="text-end">{{ __('Total') }}</th>
                                            <th>{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                                <td>{{ $order->items->count() }}</td>
                                                <td class="text-end">{{ number_format($order->total, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'completed' ? 'success' : 'secondary') }}">
                                                        {{ __($order->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="mt-4">
                            <p class="text-muted">{{ __('No orders yet.') }}</p>
                        </div>
                    @endif
                    <div class="mt-5 d-flex justify-content-end">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
