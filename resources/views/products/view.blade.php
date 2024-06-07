<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$product->name}}</title>
    <style>
        h1{
            text-align: center;
        }
        table{
            border:1px solid black;
            border-collapse: collapse;
            margin:auto;
            width:80%;
        }
        tr, th, td{
            border:1px solid black;
            padding:20px 5px;
        }
        th{
            text-align: left;
            background-color: lightgrey;
        }
        td{
            background-color: rgb(241, 238, 234);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{$product->name}}</h1>
        <table>
            <tr>
                <th>Id</th>
                <td>{{ $product->id }}</td>
            </tr>
            <tr>
                <th>Code</th>
                <td>{{ $product->code }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $product->description }}</td>
            </tr>
            <tr>
                <th>Images</th>
                <td>
                    @foreach ($product->images as $image)
                        <img style="width:50px;height:50px;" src="{{ asset('storage/' . $image->image_path) }}" alt="Imagen del producto">
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>Tariffs</th>
                <td>
                    @foreach ($product->tariffs as $tariff)
                        <div>
                            <strong>Start date:</strong> {{ $tariff->start_date }}<br>
                            <strong>End date:</strong> {{ $tariff->end_date }}<br>
                            <strong>Price:</strong> {{ $tariff->price }}
                        </div>
                    @endforeach
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
