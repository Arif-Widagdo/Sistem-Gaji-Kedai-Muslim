<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700|Nunito:300,300i,400,400i,600,600i,700,700i,900|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i|Kalam:wght@700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <style>
        body{
            background-color: red !important;  
        }
    </style>
</head>

<body>
    {{-- <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-end">
                        <img src="{{ $isi_email->embed('dist/img/logos/purpleLogo.png') }}" alt="" width="80" class="mr-2">
                        <h3 class="page-header"
                            style="font-family: 'Kalam', cursive; font-weight: 700 !important; line-height:25px; ">
                            Kedai Muslim <br>
                            Collection
                        </h3>
                    </div>
                </div>
            </div>

        </section>
    </div> --}}
    {{ $slot }}
</body>

</html>
