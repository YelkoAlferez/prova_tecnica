@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Edit {{ $categoria->name }}</h1>


        <form action="{{ route('categories.update', $categoria->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="code">Code:</label>
                <input value="{{ $categoria->code }}" type="text" class="form-control" id="code" name="code" required>
                @if ($errors->has('code'))
                    <div class="alert alert-danger">
                        <p>Code field is required and must be unique</p>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input value="{{ $categoria->name }}" type="text" class="form-control" id="name" name="name"
                    required>
                @if ($errors->has('name'))
                    <div class="alert alert-danger">
                        <p>Name field is required</p>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required>{{ $categoria->description }}</textarea>
                @if ($errors->has('description'))
                    <div class="alert alert-danger">
                        <p>Description field is required</p>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="parent_id">Parent category:</label>
                <select class="form-control" id="parent_id" name="parent_id">
                    @if ($categories->contains('parent_id', $categoria->id))
                        <option value="">None</option>
                    @else
                        @if ($categoria->parent_id !== null)
                            <option value="{{ $categoria->parent->id }}">{{ $categoria->parent->name }}</option>
                            <option value="">None</option>
                        @else
                            <option value="">None</option>
                        @endif
                        @foreach ($categories as $category)
                            @if ($category->parent_id === null && $category->id !== $categoria->id && $categoria->parent_id !== $category->id)
                                <option value="{{ $category->id }}">{{ $category->name }} ({{ $category->id }})</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>
@endsection
