<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Product</title>
</head>

<body>
    <h1>Create New Product</h1>
    @if ($errors)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="/admin" method="POST" enctype="multipart/form-data">
        @csrf
        Category:
        <input type="text" name="category"><br>
        Product Name:
        <input type="text" name="productName"><br>
        Keterangan:
        <textarea name="description" id="" cols="30" rows="10"></textarea><br>
        Price:
        <input type="text" name="price"><br>
        Photo Product:
        <input type="file" name="photo"><br>
        Photo Preview:
        <input type="file" name="photoPreview[]" multiple><br>
        Photo Progress:
        <input type="file" name="photoProgress[]" multiple><br>
        <button type="submit">Submit</button>
    </form>
</body>

</html>
