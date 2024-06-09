@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <style>
        a {
            cursor: pointer;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                columns: [{
                        title: "Id"
                    },
                    {
                        title: "Code"
                    },
                    {
                        title: "Name"
                    },
                    {
                        title: "Categories"
                    },
                    {
                        title: "Images"
                    },
                    {
                        title: "Tariffs"
                    },
                    {
                        title: "Options",
                    }
                ]
            });
        });
    </script>
@endpush
@section('content')
    <h2 style="text-align:center;margin-bottom:30px;">View products</h2>
    <div class="container">
        <div class="container" style="text-align: center;">
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-6 offset-md-3">
                    {{-- Crear un producto --}}
                    <a class="btn btn-primary btn-lg" href="{{ route('products.create') }}">Create product</a>
                </div>
            </div>
            <div>
                {{-- Exportar un xls de los productos --}}
                <a class="btn btn-primary btn-sm" href="{{ route('export') }}">Export to XLS</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table id="table" class="table table-striped table-bordered text-center">
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                {{-- Categorías del producto en cuestión --}}
                                @foreach ($product->categories as $categoria)
                                    <span
                                        style="list-style: none;text-align:center;">{{ $categoria->name }}({{ $categoria->id }})
                                    </span><br>
                                @endforeach
                            </td>
                            <td>
                                {{-- Imagenes del producto en cuestión --}}
                                @foreach ($product->images as $image)
                                    <img style="width:50px;height:50px;" src="{{ asset('storage/' . $image->image_path) }}"
                                        alt="Imagen del producto">
                                @endforeach
                            </td>
                            <td>
                                {{-- Tarifas del producto en cuestión --}}
                                @foreach ($product->tariffs as $tariff)
                                    <div>
                                        <strong>Start date:</strong> {{ $tariff->start_date }}<br>
                                        <strong>End date:</strong> {{ $tariff->end_date }}<br>
                                        <strong>Price:</strong> {{ $tariff->price }}
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        ...
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        {{-- Exportar PDF del producto en cuestión --}}
                                        <a class="dropdown-item edit-btn"
                                            href="{{ route('products.show', $product->id) }}">Download PDF</a>
                                        {{-- Editar producto en cuestión --}}
                                        <a class="dropdown-item edit-btn"
                                            href="{{ route('products.edit', $product->id) }}">Edit</a>
                                        {{-- Eliminar producto en cuestión --}}
                                        <a class="dropdown-item delete-btn"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $product->id }}').submit();">Delete</a>
                                        <form id="delete-form-{{ $product->id }}"
                                            action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
