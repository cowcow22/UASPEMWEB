<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.index', ['product' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ext = $request->file('photo')->extension();
        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
            return redirect()->back()->withInput()->withErrors(['photo' => 'The photo must be a jpg, jpeg, or png file.']);
        }
        $path = $request->file('photo')->storePublicly('photos', 'public');

        $product = new Product();
        $product->category = $request->category;
        $product->productName = $request->productName;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->photo = $path;
        $product->save();
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        $photos = Storage::url($product->photo);
        return view('admin.show', ['product' => $product, 'photos' => $photos]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product =  Product::findOrFail($id);
        return view('admin.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::where('id', $request->id)
            ->where('id', '!=', $id)
            ->get();
        if ($product->count() > 0) {
            return redirect()->back()->withInput()->withErrors(['id' => 'The id is already taken.']);
        }

        $product = Product::findOrFail($id);
        if ($request->file('photo') == null) {
            $product->category = $request->category;
            $product->productName = $request->productName;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->created_at = $request->created_at;                // Kalo ga keitung jumlah kolom, ntar di komen aja
            $product->updated_at = $request->updated_at;                // Kalo ga keitung jumlah kolom, ntar di komen aja
            $product->save();
        } else {
            $ext = $request->file('photo')->extension();
            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                return redirect()->back()->withInput()->withErrors(['photo' => 'The photo must be a jpg, jpeg, or png file.']);
            }

            $path = $request->file('photo')->storePublicly('photos', 'public');
            $product->category = $request->category;
            $product->productName = $request->productName;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->photo = $path;
            $product->created_at = $request->created_at;                // Kalo ga keitung jumlah kolom, ntar di komen aja
            $product->updated_at = $request->updated_at;                // Kalo ga keitung jumlah kolom, ntar di komen aja
            $product->save();
        }
        // return 'Berhasil Menyimpan data product dengan id= ' . $product->id;
        return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect('/home');
    }
}
