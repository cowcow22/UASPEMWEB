<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Detail</title>
</head>

<body>
    <h1>{{ $product->productName }}</h1>
    @auth
        <a href="/home">Back to Product List</a><br>
    @else
        <a href="/">Back to Product List</a><br>
    @endauth
    Nama: {{ $product->productName }} <br>
    Description: {{ $product->description }} <br>
    Photo Product: <img src="{{ asset($photos) }}" style="width: 200px; height: 200px; "><br>
    Photo Progress:
    <div style=" display:flex; flex-direction:row; justify-content: space-evenly">
        @foreach ($photoProgress as $progress)
            <img src="{{ asset($progress) }}" style="width: 200px; height: 200px;"><br>
        @endforeach
    </div>
</body>

</html>
