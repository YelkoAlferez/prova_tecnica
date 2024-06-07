<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        td{
            text-align: center;
        }
        th {
            background-color: lightgrey;
        }
    </style>
</head>

<body>

    <table id="table">
        <tr>
            <th>Id</th>
            <th>Code</th>
            <th>Name</th>
            <th>Description</th>
            <th>Categories</th>
            <th>Images</th>
            <th>Tariffs</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->code }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>
                    @foreach ($product->categories as $categoria)
                        <span style="list-style: none;text-align:center;">{{ $categoria->name }}({{ $categoria->id }})
                        </span><br>
                    @endforeach
                </td>
                <td>
                    @foreach ($product->images as $image)
                        <span>PATH: </span>{{ asset('storage/public/' . $image->image_path) }}
                    @endforeach
                </td>
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
        @endforeach
    </table>
</body>

</html>
