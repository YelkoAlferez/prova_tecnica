@extends('layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            var tariffCounter = 1;
            $('#add-tariff-btn').click(function() {
                var newTariffHtml = `
                    <div class="tariff-input-group">
                        <label for="tariffs[${tariffCounter}][start_date]">Start date:</label>
                        <input type="date" class="form-control" name="tariffs[${tariffCounter}][start_date]" required>
                        <label for="tariffs[${tariffCounter}][end_date]">End date:</label>
                        <input type="date" class="form-control" name="tariffs[${tariffCounter}][end_date]" required>
                        <label for="tariffs[${tariffCounter}][price]">Price:</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="tariffs[${tariffCounter}][price]" required>
                        <button type="button" class="btn btn-danger remove-tariff-btn">Delete</button>
                    </div>
                `;
                $('#tariffs-container').append(newTariffHtml);
                tariffCounter++;
            });

            $(document).on('click', '.remove-tariff-btn', function() {
                $(this).parent('.tariff-input-group').remove();
            });
        });
    </script>
@endpush

@section('content')
    <div class="container">
        <h1>Create product</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="code">Code:</label>
                <input type="text" class="form-control" id="code" name="code" required>
                @if ($errors->has('code'))
                    <div class="alert alert-danger">
                        <p>Wrong format at code field or not unique code</p>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
                @if ($errors->has('name'))
                    <div class="alert alert-danger">
                        <p>Wrong format at name field</p>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
                @if ($errors->has('description'))
                    <div class="alert alert-danger">
                        <p>Description field is required</p>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="tariffs">Tariffs:</label>
                <div id="tariffs-container">
                    <div class="tariff-input-group">
                        <label for="tariffs[0][start_date]">Start date:</label>
                        <input type="date" class="form-control" name="tariffs[0][start_date]" required>
                        <label for="tariffs[0][end_date]">End date:</label>
                        <input type="date" class="form-control" name="tariffs[0][end_date]" required>
                        <label for="tariffs[0][price]">Price:</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="tariffs[0][price]"
                            required>
                    </div>
                </div>
                <button type="button" id="add-tariff-btn" class="btn btn-success">Add Tariff</button>
                @if ($errors->has('tariffs.*.end_date'))
                    <div class="alert alert-danger">
                        <p>End date must be after start date.</p>
                    </div>
                @elseif($errors->has('tariffs'))
                    <div class="alert alert-danger">
                        <p>Product must have at least one tariff.</p>
                    </div>
                @elseif($errors->has('tariffs.*'))
                    <div class="alert alert-danger">
                        <p>Tariffs fields are required</p>
                    </div>
                @endif
            </div>
            <div class="select-container">
                <label for="multiple-select-input">
                    Categories
                </label>
                <select class="js-example-basic-multiple" required style="width:100%;" name="categories[]"
                    multiple="multiple">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('categories.*'))
                    <div class="alert alert-danger">
                        <p>Wrong format at categories fields</p>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="photos">Photos (jpeg/gif/jpg/png):</label>
                <input class="btn btn-default" id="input-file" required type="file" name="photos[]" multiple
                    accept="application/jpeg,image/gif,image/jpg,image/png,application" />
                @if ($errors->has('photos.*'))
                    <div class="alert alert-danger">
                        <p>Wrong format at photos fields. Accepted files: jpeg/gif/jpg/png.</p>
                    </div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
