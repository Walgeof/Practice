@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-lg-8 text-center">
            <h1 class="display-5 fw-bold mb-3">{{ config('app.name', 'Laravel') }}</h1>
            <p class="lead text-muted mb-4">
                Welcome. Browse products and categories or sign in to get started.
            </p>

            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4">
                    Products
                </a>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                    Categories
                </a>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-4">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-success btn-lg px-4">
                            Register
                        </a>
                    @endif
                @else
                    <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg px-4">
                        Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection
