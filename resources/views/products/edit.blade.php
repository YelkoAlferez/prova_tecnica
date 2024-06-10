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
            var tariffCounter = {{ count($product->tariffs) }};

            $('#add-tariff-btn').click(function() {
                var newTariffHtml = `
                    <div class="tariff-input-group">
                        <input type="date" class="form-control" name="tariffs[${tariffCounter}][start_date]" required>
                        <input type="date" class="form-control" name="tariffs[${tariffCounter}][end_date]" required>
                        <input type="number" step="0.01" class="form-control" name="tariffs[${tariffCounter}][price]" required>
                        <button type="button" class="btn btn-danger remove-tariff-btn">Delete</button>
                    </div>
                `;
                $('#tariffs-container').append(newTariffHtml);
                tariffCounter++;
            });

            $(document).on('click', '.remove-tariff-btn', function() {
                $(this).parent('.tariff-input-group').remove();
                tariffCounter--;
            });
        });
    </script>
@endpush

@section('content')
    <div class="container">
        <h1>Edit {{ $product->name }}</h1>
        <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if($errors->any())
                <div class="alert alert-danger">
                    <p>ERROR: The product has not been updated</p>
                </div>
            @endif
            @method('PUT')
            <div class="form-group">
                <label for="code">Code:</label>
                <input value="{{ $product->code }}" type="text" class="form-control" id="code" name="code"
                    required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input value="{{ $product->name }}" type="text" class="form-control" id="name" name="name"
                    required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required>{{ $product->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="tariffs">Tariffs:</label>
                <div id="tariffs-container">
                    @php $index = 0; @endphp
                    {{-- Tarifas del producto en cuestión --}}
                    @foreach ($product->tariffs as $tariff)
                        <div class="tariff-input-group">
                            <input type="date" value="{{ $tariff->start_date }}" class="form-control"
                                name="tariffs[{{ $index }}][start_date]" required>
                            <input type="date" value="{{ $tariff->end_date }}" class="form-control"
                                name="tariffs[{{ $index }}][end_date]" required>
                            <input type="number" step="0.01" value="{{ $tariff->price }}" class="form-control"
                                name="tariffs[{{ $index }}][price]" required>
                                @php if($index > 0){
                            echo "<button type='button' class='btn btn-danger remove-tariff-btn'>Delete</button>";
                        } @endphp
                        </div>
                        @php $index++; @endphp
                    @endforeach
                </div>
            </div>
            <button type="button" id="add-tariff-btn" class="btn btn-success">Add Tariff</button>
            <div class="select-container">
                <label for="multiple-select-input">
                    Categories
                </label>
                <select class="js-example-basic-multiple" style="width:100%;" name="categories[]" multiple="multiple">
                    @foreach ($categories as $category)
                        @if ($selectedCategories->contains('id', $category->id))
                            {{-- Categorías del producto en cuestión --}}
                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="photos">Photos:</label>
                <input class="btn btn-default" id="input-file" required type="file" name="photos[]" multiple
                    accept="application/jpeg,image/gif,image/jpg,image/png,application" />
            </div>
            <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>
@endsection
