@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<style>
    a{
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
    $('#taula').DataTable({
        columns: [
            { title: "Id" },
            { title: "Code" },
            { title: "Name" },
            { title: "Parent category" },
            {title: "Options"}
        ]
    });

});
</script>
@endpush
@section('content')
    <h2 style="text-align:center;margin-bottom:30px;">View categories</h2>
    <div class="container">
        <div class="container" style="text-align: center;">
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-6 offset-md-3">
                    <a class="btn btn-primary btn-lg" href="{{ route('categories.create') }}">Create category</a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table id="taula" class="table table-striped table-bordered text-center">
                    @foreach ($categories as $category)
                        <tr>
                            {{-- Id de la categoría en cuestión --}}
                            <td>{{ $category->id }}</td>
                            {{-- Código de la categoría en cuestión --}}
                            <td>{{ $category->code }}</td>
                            {{-- Nombre de la categoría en cuestión --}}
                            <td>{{ $category->name }}</td>
                            {{-- Categoría padre de la categoría en cuestión --}}
                            @if ($category->parent_id === null)
                                <td>None</td>
                            @else
                                <td>{{ $category->parent->name}}({{$category->parent->id}})</td>
                            @endif
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ...
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    {{-- Editar la categoría en cuestión --}}
                                    <a class="dropdown-item edit-btn"  href="{{ route("categories.edit", $category->id) }}">Edit</a>
                                    {{-- Eliminar la categoría en cuestión --}}
                                    <a class="dropdown-item delete-btn" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $category->id }}').submit();">Delete</a>
                                    <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: none;">
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
