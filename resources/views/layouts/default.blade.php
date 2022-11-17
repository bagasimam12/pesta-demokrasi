<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ ConfigVoting::getConfig()->title }} - {{ ConfigVoting::getConfig()->title_prefix }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,500;0,600;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/voting.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/static/logosmk.png') }}">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @stack('css')
    @yield('headscript')
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col">
    @yield('content')
    <style>
         body {
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
            background:linear-gradient(0deg, rgba(0, 0, 0, 0.25), rgba(7, 7, 7, 0.25)), url("{{ asset('images/static/bg-pilketos.png') }}");
      background-size:cover;
        }
    </style>
    </div>
</div>
</div>

    @yield('footscript')
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    @stack('js')
</body>
</html>