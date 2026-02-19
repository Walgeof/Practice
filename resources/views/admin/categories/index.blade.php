@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">{{ __('Categories Management') }}</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">{{ __('Add category') }}</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
        </div>
    @endif

    @if($categories->isEmpty())
        <div class="card">
            <div class="card-body text-center text-muted py-5">
                <p class="mb-0">{{ __('No categories yet.') }}</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary mt-3">{{ __('Create first category') }}</a>
            </div>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th class="text-end">{{ __('Products') }}</th>
                        <th style="width: 200px;" class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>
                                <a href="{{ route('admin.categories.show', $category) }}" class="text-decoration-none fw-medium">{{ $category->name }}</a>
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
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline-secondary">{{ __('View') }}</a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary">{{ __('Edit') }}</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Delete this category?') }}');">
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
