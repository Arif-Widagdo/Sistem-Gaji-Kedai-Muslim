<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ __('Internal Server Error') }}</title>
    <!-- Favicons -->
    <link href="#" rel="icon">
    <link href="#" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700|Nunito:300,300i,400,400i,600,600i,700,700i,900|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i&display=fallback">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Template Main CSS File -->
    <link href="{{ asset('dist/css/styleError.css') }}" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset("plugins/fontawesome-free/css/all.min.css") }}">
</head>

<body>
   
    <section id="error" class="error d-flex align-items-center">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 d-flex flex-column text-center justify-content-center typograph">
              <h1>Oops!</h1>
              <h2>{{ __('500 - Internal Server Error.') }}</h2>
              <p class=" mx-auto">{{ __('Wait a few moments to try again') }}</p>
              <button class="shadow-sm bg-transparent  rounded-pill w-auto mx-auto" onclick="history.back()">
                <i class="fas fa-arrow-circle-left"></i>
                {{ __('Back') }}
              </button>
            </div>
          </div>
        </div>
      </section>
      <!-- End error -->
</body>

</html>
