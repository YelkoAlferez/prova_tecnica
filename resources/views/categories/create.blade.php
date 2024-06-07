@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Crear categoria</h1>


        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="code">Codi:</label>
                <input type="text" class="form-control" id="code" name="code" required>
            </div>
            @if ($errors->has('code'))
                <div class="alert alert-danger">
                    <p>El codi seleccionat ja existeix</p>
                </div>
            @endif
            <div class="form-group">
                <label for="name">Nom:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Descripció:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="parent_id">Categoria pare</label>
                <select class="form-control" id="parent_id" name="parent_id">
                    <option value="">Cap</option>
                    @foreach ($categories as $categoria)
                        @if($categoria->parent_id === null)
                            <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
