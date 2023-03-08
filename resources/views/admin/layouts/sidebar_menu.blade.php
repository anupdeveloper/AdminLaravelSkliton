<nav class="mt-2 right-dir">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      
      <li class="nav-item">
        <a href="{{ route('admin.user.index')}}" class="nav-link">
           <i class="nav-icon fas fa-th"></i>
          <p>
            {{ __('admin_dashboard.sidebar_menu.user_management') }}
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.category.index')}}" class="nav-link">
           <i class="nav-icon fas fa-th"></i>
          <p>
            Category Management
          </p>
        </a>
      </li>
      
      {{-- <li class="nav-item">
        <a href="#" class="nav-link ">
          <i class="nav-icon fas fa-handshake"></i>
          <p>
            {{ __('admin_dashboard.sidebar_menu.user_connection') }}
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a id="ac" href="{{ route('admin.user_connections.index','approved') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>{{ __('admin_dashboard.sidebar_menu.active_connections') }}</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.user_connections.index','pending') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>{{ __('admin_dashboard.sidebar_menu.request_connections') }}</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.user_connections.index','rejected') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>{{ __('admin_dashboard.sidebar_menu.cancel_connections') }}</p>
            </a>
          </li>
        </ul>
      </li> --}}
      

      <li class="nav-item">
        <a href="{{ route('logout') }}" class="nav-link">
          <i class="nav-icon fas fa-th"></i>
          <p>
            {{ __('admin_dashboard.sidebar_menu.logout') }}
            
          </p>
        </a>
      </li>
      
      
     
      
    </ul>
  </nav>


