@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Create category</h1>


        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="code">Code:</label>
                <input type="text" class="form-control" id="code" name="code" required>
                @if ($errors->has('code'))
                    <div class="alert alert-danger">
                        <p>Code field is required and must be unique</p>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
                @if ($errors->has('name'))
                    <div class="alert alert-danger">
                        <p>Name field is required</p>
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
