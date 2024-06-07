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
                        <input type="date" class="form-control" name="tariffs[${tariffCounter}][start_date]" required>
                        <input type="date" class="form-control" name="tariffs[${tariffCounter}][end_date]" required>
                        <input type="number" min="0" class="form-control" name="tariffs[${tariffCounter}][price]" required>
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
        <h1>Crear producte</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="code">Code:</label>
                <input type="text" class="form-control" id="code" name="code" required>
            </div>
            @if ($errors->has('code'))
                <div class="alert alert-danger">
                    <p>This code already exists</p>
                </div>
            @endif
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="tariffs">Tariffs:</label>
                <div id="tariffs-container">
                    <div class="tariff-input-group">
                        <input type="date" class="form-control" name="tariffs[0][start_date]" required>
                        <input type="date" class="form-control" name="tariffs[0][end_date]" required>
                        <input type="number" min="0" class="form-control" name="tariffs[0][price]" required>
                    </div>
                </div>
                <button type="button" id="add-tariff-btn" class="btn btn-success">Add Tariff</button>
            </div>
            <div class="select-container">
                <label for="multiple-select-input">
                    Categories
                </label>
                <select class="js-example-basic-multiple" style="width:100%;" name="categories[]" multiple="multiple">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="photos">Photos:</label>
                <input class="btn btn-default" id="input-file" type="file" name="photos[]" multiple
                accept="application/jpeg,image/gif,image/jpg,image/png,application" />
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
