@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($product) ? 'Edit' : 'Create' }} Product</h1>
    <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $product->title ?? '') }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ old('description', $product->description ?? '') }}</textarea>
        </div>
        <div class="form-group">
            <label for="main_image">Main Image</label>
            <input type="file" name="main_image" class="form-control-file">
            @if(isset($product) && $product->main_image)
                <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->title }}" width="100">
            @endif
        </div>
        <div class="form-group">
            <label for="variants">Variants</label>
            <button type="button" class="btn btn-secondary mb-2" id="add-variant">Add Variant</button>
            <div id="variant-container">
                @if(isset($product) && $product->variants)
                    @foreach ($product->variants as $variant)
                        <div class="variant-item">
                            <input type="text" name="variants[{{ $loop->index }}][size]" value="{{ $variant->size }}" placeholder="Size" required>
                            <input type="text" name="variants[{{ $loop->index }}][color]" value="{{ $variant->color }}" placeholder="Color" required>
                            <button type="button" class="btn btn-danger remove-variant">Remove</button>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Create' }}</button>
    </form>
</div>

<script>
    document.getElementById('add-variant').addEventListener('click', function () {
        let index = document.querySelectorAll('.variant-item').length;
        let variantContainer = document.getElementById('variant-container');
        let variantItem = document.createElement('div');
        variantItem.className = 'variant-item';
        variantItem.innerHTML = `
            <input type="text" name="variants[${index}][size]" placeholder="Size" required>
            <input type="text" name="variants[${index}][color]" placeholder="Color" required>
            <button type="button" class="btn btn-danger remove-variant">Remove</button>
        `;
        variantContainer.appendChild(variantItem);
        variantItem.querySelector('.remove-variant').addEventListener('click', function () {
            variantItem.remove();
        });
    });

    document.querySelectorAll('.remove-variant').forEach(button => {
        button.addEventListener('click', function () {
            button.parentElement.remove();
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('form').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                window.location.href = '{{ route("products.index") }}';
            },
            error: function(response) {
                alert('An error occurred. Please try again.');
            }
        });
    });
</script>

@endsection
