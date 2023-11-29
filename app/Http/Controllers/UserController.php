<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\User;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            $userID = Auth::id();
            $shoppingCart = ShoppingCart::where('idUser', $userID)->where('deleted_at', null)->get();

            $idProducts = $shoppingCart->pluck('idProduct')->toArray();

            // Use 'whereIn' to retrieve all products in a single query
            $items = Product::whereIn('id', $idProducts)->get();

            $cartData = [];
            foreach ($items as $item) {
                // Find the corresponding ShoppingCart record
                $cartRecord = $shoppingCart->firstWhere('idProduct', $item->id);

                // Get the quantity from the ShoppingCart record
                $qty = $cartRecord ? $cartRecord->qty : 0;
                // Build an array with product and quantity information
                $cartData[] = [
                    'idProduct' => $item->id,
                    'product' => $item,
                    'qty' => $qty,
                    'photoUrl' => Storage::url($item->photo),
                    'description' => $item->description,
                    'category' => $item->category,
                    'price' => $item->price,
                ];
            }
            // 'products' => $items, 'photos' => $photos]
            return view('user.shopping-cart', ['cartData' => $cartData]);
        }

        // $products = Product::all();
        // $photos = Storage::url($products->photo);
        // return view('dashboard', ['products' => $products, 'photos' => $photos]);
    }

    public function shop()
    {
        if (Auth::id()) {
            $products = Product::all();
            // $photos = Storage::url($products->photo);
            $photos = [];
            foreach ($products as $product) {
                // Assuming 'photo' is the attribute containing the photo's filename
                $photoUrl = Storage::url($product->photo);
                // Add the URL to the $photos array
                $photos[] = $photoUrl;
            }
            return view('user.shop', ['products' => $products, 'photos' => $photos]);
        } else {
            $products = Product::all();
            // $photos = Storage::url($products->photo);
            $photos = [];
            foreach ($products as $product) {
                // Assuming 'photo' is the attribute containing the photo's filename
                $photoUrl = Storage::url($product->photo);
                // Add the URL to the $photos array
                $photos[] = $photoUrl;
            }
            return view('user.shop', ['products' => $products, 'photos' => $photos]);
        }
    }

    public function shopping_cart(Request $request)
    {
        $idProduct = $request->buttonBeli;
        $product = Product::findOrFail($idProduct);
        $photos = Storage::url($product->photo);
        return view('user.shopping-cart', ['product' => $product, 'photos' => $photos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        echo 'create';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::id()) {
            $idUser = Auth::id();
            $idProduct = $request->buttonBeli;
            $product = Product::findOrFail($idProduct);
            if (ShoppingCart::where('idUser', $idUser)->where('idProduct', $idProduct)->count() > 0) {
                $shoppingCart = ShoppingCart::where('idUser', $idUser)->where('idProduct', $idProduct)->get();
                foreach ($shoppingCart as $shoppingCart) {
                    if (isset($request->qty)) {
                        $quantity = $request->qty;
                    } else {
                        $quantity = 1;
                    }
                    $shoppingCart->qty = $shoppingCart->qty + $quantity;
                    $shoppingCart->totalPrice += $product->price;
                }
            } else {
                if (isset($request->qty)) {
                    $quantity = $request->qty;
                } else {
                    $quantity = 1;
                }
                $totalPrice = $product->price;

                $shoppingCart = new ShoppingCart();
                $shoppingCart->idUser     = $idUser;
                $shoppingCart->idProduct  = $idProduct;
                $shoppingCart->qty        = $quantity;
                $shoppingCart->totalPrice = $totalPrice;
            }
            $shoppingCart->save();
            return redirect('/home/shop');
        }
    }

    public function profileuser()
    {
        $userID = Auth::id();
        $userProfile = User::findOrFail($userID);
        return view('user.profile', ['user' => $userProfile]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'socialMedia' => 'required',
            'address' => 'required',
            'country' => 'required', // Adjust the max file size as needed
            'postalCode' => 'required',
            'phoneNumber' => 'required',
        ]);

        $newProfile = $request;
        $userID = Auth::id();
        $userProfile = User::findOrFail($userID);

        $userProfile->name = $newProfile->name;
        $userProfile->email = $newProfile->email;
        $userProfile->socialMedia = $newProfile->socialMedia;
        $userProfile->address = $newProfile->address;
        $userProfile->country = $newProfile->country;
        $userProfile->postalCode = $newProfile->postalCode;
        $userProfile->phoneNumber = $newProfile->phoneNumber;
        $userProfile->save();

        return view('user.profile', ['user' => $userProfile]);
    }

    public function commission()
    {
        return view('user.commission');
    }

    public function about()
    {
        return view('user.about');
    }

    public function homeproductDetail($id)
    {
        $product = Product::findOrFail($id);

        // Generate URLs for the main photo and store them in an array
        $photos = Storage::url($product->photo);

        // Generate URLs for each photo progress and store them in an array
        $photoProgress = [];
        foreach ($product->photoProgress as $progress) {
            $photoProgress[] = Storage::url($progress);
        }

        return view('user.homeproductdetail', [
            'product' => $product,
            'photos' => $photos,
            'photoProgress' => $photoProgress
        ]);
    }

    public function shopproductDetail($id)
    {
        $product = Product::findOrFail($id);
        // Generate URLs for the main photo and store them in an array
        $photoPreview = [];
        foreach ($product->photoPreview as $preview) {
            $photoPreview[] = Storage::url($preview);
        }
        return view('user.shopproductdetail', [
            'product' => $product,
            'photoPreview' => $photoPreview,
            // 'photoProgress' => $photoProgress
        ]);
    }

    public function thanks()
    {
        Mail::to('stevfirman22@gmail.com')->send(new SendEmail());
        $userID = Auth::id();
        ShoppingCart::where('idUser', $userID)->delete();

        return view('user.thankyou');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (Auth::id()) {
            $idUser = Auth::id();
            $productID = $request->btnProductID;

            $product = Product::findOrFail($productID);


            $shoppingCart = ShoppingCart::where('idUser', $idUser)->where("idProduct", $productID)->get();

            foreach ($shoppingCart as $shoppingCart) {
                $shoppingCart->qty = $shoppingCart->qty + 1;
                $shoppingCart->totalPrice += $product->price;
            }

            $shoppingCart->save();
        }
        return redirect('/home/shopping-cart');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if (Auth::id()) {
            $idUser = Auth::id();
            $productID = $request->btnProductID;

            $product = Product::findOrFail($productID);


            $shoppingCart = ShoppingCart::where('idUser', $idUser)->where("idProduct", $productID)->get();
            foreach ($shoppingCart as $shoppingCart) {
                if ($shoppingCart->qty > 1) {
                    $shoppingCart->qty = $shoppingCart->qty - 1;
                    $shoppingCart->totalPrice -= $product->price;
                    $shoppingCart->save();
                } else {
                    $shoppingCart->delete();
                }
            }
        }
        return redirect('/home/shopping-cart');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $product = Product::findOrFail($id);

        // return view('dashboard', ['product' => $product, 'photos' => $photos]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
}
