@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Categories</h1>
        @can('admin')
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Add category</a>
        @endcan
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($categories->isEmpty())
        <div class="card">
            <div class="card-body text-center text-muted py-5">
                <p class="mb-0">No categories yet.</p>
                @can('admin')
                    <a href="{{ route('categories.create') }}" class="btn btn-outline-primary mt-3">Create first category</a>
                @endcan
            </div>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-end">Products</th>
                        <th style="width: 120px;" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>
                                <a href="{{ route('categories.show', $category) }}" class="text-decoration-none fw-medium">{{ $category->name }}</a>
                            </td>
                            <td>
                                @if($category->description)
                                    <span class="text-muted text-truncate d-inline-block" style="max-width: 320px;">{{ $category->description }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-end">{{ $category->products_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('categories.show', $category) }}" class="btn btn-outline-secondary btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
