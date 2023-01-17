<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- SEO Meta Tags -->
    {{-- <meta name="description" content="" /> --}}
    <meta name="author" content="Arif Widagdo | arifwidagdo24@gmail.com" />
      
    <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
    {{-- <meta property="og:site_name" content="Sistem Gaji Kedai Muslim" /> <!-- website name -->
    <meta property="og:site" content="" /> <!-- website link -->
    <meta property="og:title" content="Elearning for X-Ray" /> <!-- title shown in the actual shared post -->
    <meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
    <meta property="og:image" content="{{ asset('dist/img/logo.jpg') }}" /> <!-- image link, make sure it's jpg -->
    <meta property="og:url" content="" /> <!-- where do you want your post to link to -->
    <meta name="twitter:card" content="summary_large_image" /> <!-- to have large image post format in Twitter --> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">
        
    <base href="{{{ URL::to('/') }}}">

    <title>
        @if($title)
            {{ $title }}
        @else
            Sistem Gaji Kedai Muslim
        @endif
    </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700|Nunito:300,300i,400,400i,600,600i,700,700i,900|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i|Kalam:wght@700&display=fallback">




    <link rel="icon" href="{{ asset('dist/img/logos/purpleLogo.png') }}">
{{-- 
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900|Nunito:wght@400;600;700&display=swap|family=Ubuntu:wght@700&display=swap" rel="stylesheet">
 --}}


    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset("plugins/fontawesome-free/css/all.min.css") }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset("plugins/overlayScrollbars/css/OverlayScrollbars.min.css") }}">
    <!-- Ijabo Crop Tool -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/ijabo-crop-tool/ijaboCropTool.min.css') }}"> --}}
    @yield('links')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <!-- Toaster -->
    <link rel="stylesheet" href="{{ asset('dist/css/animate.min.css') }}">
    <!-- SweetAlert 2 | Display Message -->
    <link rel="stylesheet" href={{ asset('plugins/sweetalert2/sweetalert2.css') }}>
    <!-- Toaster -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">

    <style>
        .page-item.active .page-link {
            color: #fff !important;
            background-color: #6F42C1 !important;
            border-color: #6F42C1 !important; 
        }
    </style>
</head>

<body class="hold-transition sidebar-mini {{ (request()->is('**/profile')) 
|| (request()->is('owner/sallaries/**')) || (request()->is('owner/recap-sallary/**')) 
? 'sidebar-collapse' : '' }}">
    <!-- Site wrapper -->
    <div class="wrapper">

        <!-- Navbar -->
        @include('components.dashboard.navbar')
        <!-- /Navbar -->

        <!-- Main Sidebar Container -->
        @include('components.dashboard.sidebar')
        <!-- /Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        @if (isset($header))
                        <div class="col-lg-7">
                            <h3 class="m-0 font-weight-bold" style="font-family: 'Nunito';">{{ $header }}</h3>
                        </div><!-- /.col -->
                        @endif
                        @if (isset($links))
                        <div class="col-lg-5">
                            {{ $links }}
                        </div><!-- /.col -->
                        @endif
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @if(session()->has('success'))
                    <div class="successToast"></div>
                    @elseif(session()->has('error'))
                    <div class="errorToast"></div>
                    @elseif(session()->has('info'))
                    <div class="infoToast"></div>
                    @endif
                    
                    <div class="" id="successToast"></div>
                    <div class="" id="errorToast"></div>
                    <div class="" id="infoToast"></div>

                    <audio id="notifSucccess" src="{{ asset('dist/sound/notifSuccess.mp3') }}" preload="auto"></audio>
                    <audio id="notifFail" src="{{ asset('dist/sound/confirmation.wav') }}" preload="auto"></audio>
                    {{ $slot }}
                </div>
                <!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

       @include('components.dashboard.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset("plugins/jquery/jquery.min.js") }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script src="{{ asset("plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset("dist/js/adminlte.js") }}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ asset('dist/js/demo.js') }}"></script> --}}
    <!-- SweetAlert 2 | Display Message -->
    <script src="{{ asset('dist/js/sweetalert2.all.min.js') }}"></script>
    <!-- Toaster -->
    <script src="{{ asset('dist/js/toastr.min.js') }}"></script>
    <!-- Ring Notif -->
    <script src="{{ asset('dist/js/mk-notifications.js') }}"></script>
    <!-- Input Mask -->
    <script src="{{ asset('dist/js/jquery.inputmask.bundle.min.js') }}"></script>


    @yield('scripts')
    <script>
        // -- Custom JS Code --
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function format(element) {
            $(element).inputmask("numeric", {
                radixPoint: ",",
                groupSeparator: ".",
                digits: 2,
                autoGroup: true,
                prefix: ' ',
                rightAlign: false,
                nullable: false,
                clearMaskOnLostFocus: true
            });
        }
        
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    
        $('.successToast').each(function () {
            document.getElementById('notifSucccess').play();
            Toast.fire({
                icon: 'success',
                title: '{{ Session::get("success") }}'
            })
        });

        $('.infoToast').each(function () {
            document.getElementById('notifFail').play();
            Toast.fire({
                icon: 'info',
                title: '{{ Session::get("info") }}'
            })
        });
                
        $('.errorToast').each(function () {
            document.getElementById('notifFail').play();
            Toast.fire({
                icon: 'error',
                title: '{{ Session::get("error") }}'
            })
        });
        
        function alertToastInfo(msg) {
            $('#infoToast').addClass("infoToast");
            document.getElementById('notifFail').play();
            return $('.infoToast').each(function () {
                Toast.fire({
                    icon: 'info',
                    title: msg
                })
            });
        }
        function alertToastSuccess(msg) {
            $('#successToast').addClass("successToast");
            document.getElementById('notifSucccess').play();
            return $('.successToast').each(function () {
                Toast.fire({
                    icon: 'success',
                    title: msg
                })
            });
            
        }
        function alertToastError(msg) {
            $('#errorToast').addClass("errorToast");
            document.getElementById('notifFail').play();
            return $('.errorToast').each(function () {
                Toast.fire({
                    icon: 'error',
                    title: msg
                })
            });
        }
    </script>
</body>
</html>
