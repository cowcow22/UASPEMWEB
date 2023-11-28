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
        <a href="/home/shop">Back to Product List</a><br>
    @else
        <a href="/shop">Back to Product List</a><br>
    @endauth
    Category: {{ $product->category }} <br>
    Nama: {{ $product->productName }} <br>
    Description: {{ $product->description }} <br>
    Price: {{ $product->price }}<br>
    Photo Preview:
    <div style=" display:flex; flex-direction:row; justify-content: space-evenly">
        @foreach ($photoPreview as $preview)
            <img src="{{ asset($preview) }}" style="width: 200px; height: 200px;"><br>
        @endforeach
    </div>
    {{-- Photo Progress: --}}
    {{-- <div style=" display:flex; flex-direction:row; justify-content: space-evenly">
        @foreach ($photoProgress as $progress)
            <img src="{{ asset($progress) }}" style="width: 200px; height: 200px;"><br>
        @endforeach
    </div> --}}
    @auth
        <form action="/home/shopping-cart" method="POST">
            @csrf
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity[]" value="1" min="1">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" name="buttonBeli" value="{{ $product->id }}" class="btn btn-primary">Beli</button>
        </form>
    @endauth
</body>

</html>
