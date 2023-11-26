<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link rel="stylesheet" type="text/css" media="screen" href="modify.css"> --}}
    @vite('resources/css/thankyou.css')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body>
    <nav>
        <div class="piccontainer">
            <img id="pics" src="{{ URL::asset('storage/asset/2.png') }}">
        </div>
        @auth
            <div class="navbar2">
                <a href="/home">Home</a>
                <a href="/home/commission">Commission</a>
                <a href="/home/shop">Shop</a>
                <a href="/home/about">About</a>
            </div>
        @endauth
        <div class="button-container">
            <button id="cart-button" onclick="redirectToCart()"><i class="fa-solid fa-cart-shopping"></i></button>
            <button id="profile-button" onclick="redirectToProfile()"><i class="fa-solid fa-user"></i></button>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" id="profile-button" role="button">Log Out</button>
            </form>
        </div>

    </nav>

    <img id="top-image" src="{{ URL::asset('storage/asset/2.png') }}">
    <h2>THANK YOU FOR YOUR PURCHASE !</h2>
    <h3>Please wait for our e-mail for your payment confirmation</h3>

    <div>
        <button id="button1" onclick="redirectToHome()">Home</button>
        <br>
        <button id="button2" onclick="redirectToShop()">Shop</button>
    </div>

    <script>
        function redirectToHome() {
            window.location.href = '/home';
        }

        function redirectToShop() {
            window.location.href = '/home/shop';
        }

        function redirectToCart() {
            window.location.href = '/home/shopping-cart';
        }

        function redirectToProfile() {
            window.location.href = '/home/profileuser';
        }
    </script>
</body>

</html>
