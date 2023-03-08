<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      
      <li class="nav-item">
        <a href="{{ route('admin.user.index')}}" class="nav-link {{ (request()->is('admin/user')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-th"></i>
          <p>
            {{ __('admin_dashboard.sidebar_menu.user_management') }}
            
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.transaction.index')}}" class="nav-link {{ (request()->is('admin/user-transactionuser_subscription')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-credit-card"></i>
          <p>
            {{ __('admin_dashboard.sidebar_menu.user_transaction') }}
            
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.user-subscription.index')}}" class="nav-link {{ (request()->is('admin/user-subscription')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-tag"></i>
          <p>
            {{ __('admin_dashboard.sidebar_menu.user_subscription') }}
            
          </p>
        </a>
      </li>
      <li class="nav-item nav-item {{ (request()->is('admin/user-connections/*')) ? 'menu-is-opening menu-open' : '' }}">
        <a href="#" class="nav-link {{ (request()->is('admin/user-connections/*')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-handshake"></i>
          <p>
            Connections
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.user_connections.index','approved') }}" class="nav-link {{ (request()->is('admin/user-connections/approved')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Active Connections</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.user_connections.index','pending') }}" class="nav-link {{ (request()->is('admin/user-connections/pending')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Request Connections</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.user_connections.index','rejected') }}" class="nav-link {{ (request()->is('admin/user-connections/rejected')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Cancel Connections</p>
            </a>
          </li>
        </ul>
      </li>
      {{-- <li class="nav-item">
        <a href="{{ route('admin.user_subscription.index')}}" class="nav-link ">
          <i class="nav-icon fas fa-bell"></i>
          <p>
            Notifications
            
          </p>
        </a>
      </li> --}}
      <li class="nav-item">
        <a href="{{ route('admin.user-suggestion.index')}}" class="nav-link">
          <i class="nav-icon fas fa-bell"></i>
          <p>
            Requested Suggestion 
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog"></i>
          <p>
            Settings
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.education.index') }}" class="nav-link ">
              <i class="far fa-circle nav-icon"></i>
              <p>Education</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.skin-color.index') }}" class="nav-link {{ (request()->is('admin/user-transaction')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Skin color</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.personality-dimension.index') }}" class="nav-link {{ (request()->is('admin/user-transaction')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Personality dimenstions</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.on-boarding.index') }}" class="nav-link {{ (request()->is('admin/user-transaction')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>OnBoarding</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.subscription.index') }}" class="nav-link {{ (request()->is('admin/user-transaction')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Subscription</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.status.index') }}" class="nav-link {{ (request()->is('admin/user-transaction')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Status</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.educational-content.index') }}" class="nav-link {{ (request()->is('admin/user-transaction')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Educational Contetnt</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.hijab-type.index') }}" class="nav-link {{ (request()->is('admin/user-transaction')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Hijab Type</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.master-work.index') }}" class="nav-link {{ (request()->is('admin/user-transaction')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Master Work</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.family-origin.index') }}" class="nav-link {{ (request()->is('admin/user-transaction')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Family Origin</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.master-children.index') }}" class="nav-link {{ (request()->is('admin/user-transaction')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Master Children</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.master-popup-message.index') }}" class="nav-link {{ (request()->is('admin/user-transaction')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Master POPUp message</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.master-sect.index') }}" class="nav-link {{ (request()->is('admin/user-transaction')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Master Sect</p>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a href="{{ route('admin.master-height.index') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Master Height</p>
            </a>
          </li> --}}
          {{-- <li class="nav-item">
            <a href="{{ route('admin.master-religion.index') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Master Religion</p>
            </a>
          </li> --}}

        </ul>
      </li>

      {{-- <li class="nav-item">
        <a href="{{asset('assets_admin/pages/widgets.html')}}" class="nav-link">
          <i class="nav-icon fas fa-th"></i>
          <p>
            {{ __('admin_dashboard.sidebar_menu.user_management') }}
            
          </p>
        </a>
      </li> --}}
      
      
     
      
    </ul>
  </nav>


