<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    table,
    th,
    td {
        border: 1px solid;
    }
</style>

<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('ADMIN Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1>Daftar Product</h1>
                        <a href="admin/create">Create new Product</a>
                        <table>
                            <tr>
                                <th>Category</th>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Photo</th>
                                <th>Tindakan</th>
                                <th>Create Date</th>
                                <th>Update Date</th>
                                {{-- <th>Telepon</th> --}}
                            </tr>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->category }}</td>
                                    <td>{{ $product->productName }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->photo }}</td>
                                    <td>
                                        <a href="/admin/{{ $product->id }}">SHOW</a> |
                                        <a href="/admin/{{ $product->id }}/edit">EDIT</a> |
                                        <form action="/admin/{{ $product->id }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit">DELETE</button>
                                        </form>
                                    </td>
                                    <td>{{ $product->created_at }}</td>
                                    <td>{{ $product->updated_at }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

</body>

</html>
