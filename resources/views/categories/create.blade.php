@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Create category</h1>


        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            @if($errors->any())
                <div class="alert alert-danger">
                    <p>ERROR: The category has not been created</p>
                </div>
            @endif
            <div class="form-group">
                <label for="code">Code:</label>
                <input type="text" class="form-control" id="code" name="code" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="parent_id">Parent category:</label>
                <select class="form-control" id="parent_id" name="parent_id">
                    <option value="">None</option>
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
