@extends('layouts.app')

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function addQuantity(productId) {
            var checkbox = document.getElementById(productId);
            var container = document.getElementById('addQuantity-' + productId);

            if (checkbox.checked) {
                var input = document.createElement('input');
                input.type = 'number';
                input.id = 'quantity';
                input.name = 'quantity[]';
                input.value = '1';
                input.min = '1';
                container.appendChild(input);
            } else {
                container.innerHTML = '';
            }
        }
    </script>
@endpush

@section('content')
    <div class="container">
        <h1>Create order at {{ $date->format('d/m/y') }}</h1>
        <form action="{{ route('calendar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Productos que ya se encuentran en el pedido en cuestión --}}
            @foreach ($productsWithOrders as $product)
                <div class="form-group">
                    <input id="{{ $product->id }}" name="products[]" value="{{ $product->id }}" checked type="checkbox"
                        onchange="addQuantity({{ $product->id }})">
                    <label for="{{ $product->id }}">{{ $product->name }}</label>
                    <div id="addQuantity-{{ $product->id }}">
                        @foreach($calendars as $calendar)
                        @if($calendar->product_id === $product->id)
                        <input type="number" name="quantity[]" value="{{ $calendar->quantity }}" />
                        @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
            {{-- Productos que no se encuentran en el pedido en cuestión pero tienen tarifa en esa fecha --}}
            @foreach ($products as $product)
                @if (!$productsWithOrders->contains('id', $product->id))
                    <div class="form-group">
                        <input id="{{ $product->id }}" name="products[]" value="{{ $product->id }}" type="checkbox"
                            onchange="addQuantity({{ $product->id }})">
                        <label for="{{ $product->id }}">{{ $product->name }}</label>
                        <div id="addQuantity-{{ $product->id }}"></div>
                    </div>
                @endif
            @endforeach
            <input type="hidden" name="date" value="{{ $date }}">
            @if($productsWithOrders->count() > 0)
                <button type="submit" class="btn btn-primary">Edit</button>
            @else
                <button type="submit" class="btn btn-primary">Create</button>
            @endif
        </form>
    </div>
@endsection
