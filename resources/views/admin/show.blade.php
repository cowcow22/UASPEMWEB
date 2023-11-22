<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>{{$product->productName}}</h1>
    <a href="/home">Back to Product List</a><br>
    Category: {{$product->category}} <br>
    Nama: {{$product->productName}} <br>
    Description: {{$product->description}} <br>
    Price: {{$product->price}}<br>
    Photo: <img src="{{asset($photos)}}">
</body>
</html>