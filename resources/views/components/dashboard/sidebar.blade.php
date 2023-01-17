<aside class="main-sidebar sidebar-light-purple elevation-4" >
    <!-- Brand Logo -->
    <a href="/" class="brand-link" style="border-bottom:2px solid #6F42C1 !important;">
      <img src="{{ asset('dist/img/logos/purpleLogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" >
      <span class="brand-text font-weight-light text-purple" style="font-family: 'Kalam', cursive; font-weight: 700 !important; line-height:0;">Kedai Muslim</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ Auth::user()->picture }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('profile.update') }}" class="d-block name_user">{{ Auth::user()->name }} </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        @if(Auth::user()->userPosition->name === 'Owner')
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('owner/dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                {{ __('Dashboard') }}
              </p>
            </a>
          </li>
          <li class="nav-header">{{ __('User') }}</li>
          <li class="nav-item">
            <a href="{{ route('positions.index') }}" class="nav-link {{ request()->is('owner/positions') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
              {{ __('User Positions') }}
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('owner/users') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                {{ __('Users Management') }}
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->is('owner/categories') ? 'active' : '' }}">
              <i class="nav-icon fas fa-list-alt"></i>
                <p>{{ __('Product Categories') }}</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('services.index') }}" class="nav-link {{ request()->is('owner/services') ? 'active' : '' }}">
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>{{ __('Sallaries Management') }}</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('products.index') }}" class="nav-link {{ request()->is('owner/products') ? 'active' : '' }}">
              <i class="nav-icon fas fa-boxes"></i>
              <p>{{ __('Production') }}</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('owner/sallaries') || request()->is('owner/sallaries/**') || request()->is('owner/recap-sallary') || request()->is('owner/recap-sallary/**')  ? 'menu-open' : '' }}">
            <a class="nav-link {{ request()->is('owner/sallaries') || request()->is('owner/sallaries/**') || request()->is('owner/recap-sallary') || request()->is('owner/recap-sallary/**')  ? 'active' : '' }}" style="cursor: pointer">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>{{ __('Sallary') }} <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('owner.sallary.index') }}" class="nav-link {{ request()->is('owner/sallaries') ? 'active' : '' }}">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    {{ __('Sallary Employee') }}
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('recap.sallary.index') }}" class="nav-link {{ request()->is('owner/recap-sallary') || request()->is('owner/recap-sallary/**') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    {{ __('Sallary Recap') }}
                  </p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        @else
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('employee.dashboard') }}" class="nav-link {{ request()->is('employee/dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                {{ __('Dashboard') }}
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('employee.history') }}" class="nav-link {{ request()->is('employee/history') ? 'active' : '' }}">
              <i class="nav-icon fas fa-history"></i>
              <p>
                {{ __('History') }}
              </p>
            </a>
          </li>
        </ul>
        @endif
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>