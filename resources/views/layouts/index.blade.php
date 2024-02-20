<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>iSurff</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        section {
            flex: 1;
        }
    </style>

</head>

<body>
    <section>
        @include('front.navbar')
        {{-- @yield('navbar') --}}
    </section>
    <!-- Section-->
    <section>
        {{-- @include('front.content') --}}
        @yield('content')
    </section>
    <!-- Footer-->
    <footer style="background-color: #474F7A" class="py-5">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>