<nav class="mt-2 right-dir">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      
      <li class="nav-item">
        <a href="{{ route('admin.user.index')}}" class="nav-link @if(request()->routeIs('admin.user.*')) active @endif">
           <i class="nav-icon red fas fa-users"></i>
          <p>
            {{ __('admin_dashboard.sidebar_menu.user_management') }}
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.category.index')}}" class="nav-link @if(request()->routeIs('admin.category.*')) active @endif">
           <i class="nav-icon white fas fa-list"></i>
          <p>
            Category Management
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.page.index')}}" class="nav-link @if(request()->routeIs('admin.page.*')) active @endif">
           <i class="nav-icon white fas fa-list"></i>
          <p>
            Pages Management
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.product.index')}}" class="nav-link  @if(request()->routeIs('admin.product.*')) active @endif">
           <i class="nav-icon pink fas fa-table"></i>
          <p>
            Product Management
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.order.index')}}" class="nav-link @if(request()->routeIs('admin.order.*')) active @endif">
           <i class="nav-icon red fas fa-list-ol"></i>
          <p>
            Order Management<span class="noti badge badge-danger">{{ App\Helper\Helper::get_new_orders() }}</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.lead.index')}}" class="nav-link @if(request()->routeIs('admin.lead.*')) active @endif">
           <i class="nav-icon green fas fa-list"></i>
          <p>
            Lead Management
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.workorder.index')}}" class="nav-link @if(request()->routeIs('admin.workorder.*')) active @endif">
           <i class="nav-icon yellow fas fa-th"></i>
          <p>
            Workorder Mgt
          </p>
          <i class="fas fa-angle-left right"></i>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a id="ac" href="{{ route('admin.workorder.index')}}" class="nav-link">
              <i class="nav-icon yellow fas fa-th"></i>
              <p>
                List
              </p>
              
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.workorder.index','not-resolved')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Not Resolved WO</p>
            </a>
          </li>
          
        </ul>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.ticket.index')}}" class="nav-link @if(request()->routeIs('admin.ticket.*')) active @endif">
           <i class="nav-icon yellow fas fa-th"></i>
           
          <p class="menu-has-noti">
            Ticket/Complaint Mgt
            <span class="noti badge badge-danger">{{ App\Helper\Helper::get_new_tickets() }}</span>
          </p>
          
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.setting.index')}}" class="nav-link @if(request()->routeIs('admin.setting.*')) active @endif">
           <i class="nav-icon yellow fas fa-th"></i>
           
          <p class="menu-has-noti">
            Slot Setting
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
          <i class="nav-icon pink fas fa-user-times"></i>
          <p>
            {{ __('admin_dashboard.sidebar_menu.logout') }}
            
          </p>
        </a>
      </li>
      
      
     
      
    </ul>
  </nav>


