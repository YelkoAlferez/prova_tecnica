@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>

    <body>
            <h1 style="text-align:center;margin-top:200px;font-size:60px;">Hola {{ Auth::user()->name }}, benvingut al menú de gestió!</h1>
    </body>

    </html>
@endsection

