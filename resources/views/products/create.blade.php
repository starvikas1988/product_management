@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Product</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="main_image">Main Image</label>
            <input type="file" name="main_image" class="form-control-file" required>
        </div>
        <div class="form-group">
            <label for="variants">Variants</label>
            <button type="button" class="btn btn-secondary mb-2" id="add-variant">Add Variant</button>
            <div id="variant-container"></div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#add-variant').on('click', function () {
        let index = $('.variant-item').length;
        let variantHtml = `
            <div class="variant-item mb-2">
                <input type="text" name="variants[${index}][size]" placeholder="Size" class="form-control d-inline-block" style="width: 30%;" required>
                <input type="text" name="variants[${index}][color]" placeholder="Color" class="form-control d-inline-block" style="width: 30%;" required>
                <button type="button" class="btn btn-danger remove-variant">Remove</button>
            </div>
        `;
        $('#variant-container').append(variantHtml);
    });

    $(document).on('click', '.remove-variant', function () {
        $(this).closest('.variant-item').remove();
    });
</script>
@endsection
