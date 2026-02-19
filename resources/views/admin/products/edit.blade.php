@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ __('Products') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.show', $product) }}">{{ $product->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit product') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }} <span class="text-danger">*</span></label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">{{ __('Price') }} <span class="text-danger">*</span></label>
                            <input id="price" type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                            <select id="category_id" class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
                                <option value="">{{ __('Select category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('Image') }}</label>
                            @if($product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="" class="rounded" style="max-height: 80px;">
                                    <span class="text-muted small ms-2">{{ __('Current image') }}</span>
                                </div>
                            @endif
                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml">
                            <div class="form-text">{{ __('Leave empty to keep current image. JPEG, PNG, JPG, GIF or SVG. Max 2 MB.') }}</div>
                            @error('image')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">{{ __('Update product') }}</button>
                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
