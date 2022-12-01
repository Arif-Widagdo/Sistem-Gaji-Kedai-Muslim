 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="border-bottom:2px solid #6F42C1 !important;">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
         <!-- Navbar Search -->
         <li class="nav-item">
             <a class="nav-link" data-widget="navbar-search" href="{{ route('profile.edit') }}" role="button">
                 <i class="fas fa-search"></i>
             </a>
             <div class="navbar-search-block">
                 <form class="form-inline">
                     <div class="input-group input-group-sm">
                         <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                         <div class="input-group-append">
                             <button class="btn btn-navbar" type="submit">
                                 <i class="fas fa-search"></i>
                             </button>
                             <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                 <i class="fas fa-times"></i>
                             </button>
                         </div>
                     </div>
                 </form>
             </div>
         </li>

         <!-- Languange Dropdown Menu -->
         <li class="nav-item dropdown">
             <a class="nav-link" data-toggle="dropdown" href="#">
                 <i class="fas fa-globe"></i>
             </a>
             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                 <span class=" dropdown-header text-left">{{ __('Language') }}</span>
                 <div class="dropdown-divider"></div>
                 <a href="{{ url('locale/id') }}" class="dropdown-item">
                     <i class="fas fa-globe mr-2"></i> {{ __('Indonesian') }}
                     @if(app()->getLocale()=='id')
                     <span class="float-right text-sm badge badge-danger">{{ __('Active') }}</span>
                     @endif
                 </a>
                 <div class="dropdown-divider"></div>
                 <a href="{{ url('locale/en') }}" class="dropdown-item">
                     <i class="fas fa-globe mr-2"></i> {{ __('English') }}
                     @if(app()->getLocale()=='en')
                     <span class="float-right text-sm badge badge-danger">{{ __('Active') }}</span>
                     @endif
                 </a>
             </div>
         </li>
         <!-- Auth Dropdown Menu -->
         <li class="nav-item dropdown">
             <a class="nav-link" data-toggle="dropdown" href="#">
                 <i class="far fa-user"></i>
             </a>
             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                 <a href="{{ route('profile.edit') }}" class="dropdown-item dropdown-header text-left d-flex align-items-center">
                     <img src="{{ Auth::user()->picture }}" alt="" width="50"
                         class="img-circle elevation-2 user_picture">
                     <ul style="list-style-type: none; margin-left:-25px;">
                         <li class="name_user">
                             <p>{{ Auth::user()->name }}</p>
                         </li>
                         <li>
                             <p>{{ Auth::user()->email }}</p>
                         </li>
                     </ul>
                 </a>
                 <div class="dropdown-divider"></div>
                 <a href="#" class="dropdown-item">
                     <i class="fas fa-cogs mr-2" style="width: 20px; height:20px"></i> {{ __('Settings Accout') }}
                 </a>
                 <div class="dropdown-divider"></div>
                 <form action="{{ route('logout') }}" method="POST">
                     @csrf
                     <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer text-left"
                         onclick="event.preventDefault(); this.closest('form').submit();">
                         <i class="fas fa-sign-out-alt mr-2" style="width: 20px; height:20px"></i> {{ __('Logout') }}
                     </a>
                 </form>
             </div>
         </li>
         <li class="nav-item">
             <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                 <i class="fas fa-expand-arrows-alt"></i>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                 <i class="fas fa-th-large"></i>
             </a>
         </li>
     </ul>
 </nav>
 <!-- /.navbar -->