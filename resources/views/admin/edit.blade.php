<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Edit Product</h1>
    @if ($errors)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="/admin/{{ $product->id }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        Category:
        <input type="text" name="category" value="{{ $product->category }}"><br>
        Product Name:
        <input type="text" name="productName" value="{{ $product->productName }}"><br>
        Keterangan:
        <textarea name="description" id="" cols="30" rows="10">{{ $product->description }}</textarea><br>
        Price:
        <input type="text" name="price" value="{{ $product->price }}"><br>
        Photo:
        <input type="file" name="photo"><br>
        Photo Preview:
        <input type="file" name="photoPreview[]" multiple><br>
        Photo Progress:
        <input type="file" name="photoProgress[]" multiple><br>
        <button type="submit">Submit</button>
    </form>
</body>

</html>
