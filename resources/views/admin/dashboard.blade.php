@extends('admin.layouts.layout')

@section('content')

<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $total_accounts }}</h3>
        <p> {{ __('admin_dashboard.dashboard.total_accounts') }} </p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="{{ route('admin.user.index') }}" class="small-box-footer">{{ __('admin_dashboard.dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ isset($total_family_accounts)?$total_family_accounts:'' }}</h3>

        <p>{{ __('admin_dashboard.dashboard.total_family_accounts') }}</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="{{ route('admin.user.index') }}" class="small-box-footer">{{ __('admin_dashboard.dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ isset($total_individual_accounts)?$total_individual_accounts:'' }}</h3>

        <p>
          {{ __('admin_dashboard.dashboard.total_individual_accounts') }}
        </p>
        
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="{{ route('admin.user.index') }}" class="small-box-footer">{{ __('admin_dashboard.dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
 
</div>
<div class="row">
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ isset($total_active_connections)?$total_active_connections:'' }}</h3>

        <p>
          {{ __('admin_dashboard.dashboard.total_active_connections') }}
        </p>
      </div>
      <div class="icon">
        <i class="fas fa-handshake"></i>
      </div>
      <a href="{{ route('admin.user_connections.index','approved') }}" class="small-box-footer">{{ __('admin_dashboard.dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ isset($total_pending_connections)?:'' }}</h3>

        <p>
          {{ __('admin_dashboard.dashboard.total_pending_connections') }}
        </p>
      </div>
      <div class="icon">
        <i class="fas fa-handshake"></i>
      </div>
      <a href="{{ route('admin.user_connections.index','pending') }}" class="small-box-footer">{{ __('admin_dashboard.dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ isset($total_pending_connections)?:'' }}</h3>

        <p>
          {{ __('admin_dashboard.dashboard.total_cancel_connections') }}
        </p>
      </div>
      <div class="icon">
        <i class="fas fa-handshake"></i>
      </div>
      <a href="{{ route('admin.user_connections.index','rejected') }}" class="small-box-footer">{{ __('admin_dashboard.dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
 
</div>
<div class="row">
  {{-- <div class="col-lg-4 col-6">
   
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $total_subscriptions }}</h3>

        <p>
          {{ __('admin_dashboard.dashboard.total_subscriptions') }}
        </p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="#" class="small-box-footer">{{ __('admin_dashboard.dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div> --}}
  <!-- ./col -->
  {{-- <div class="col-lg-4 col-6">
    
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ $total_active_subscriptions }}</h3>

        <p>
          {{ __('admin_dashboard.dashboard.total_active_subscriptions') }}
        </p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="#" class="small-box-footer">{{ __('admin_dashboard.dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div> --}}
  <!-- ./col -->
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ isset($total_pending_connections)?:'' }}</h3>

        <p>
          {{ __('admin_dashboard.dashboard.total_education_contents') }}
        </p>
      </div>
      <div class="icon">
        <i class="fas fa-book-open"></i>
      </div>
      <a href="{{ route('admin.educational-content.index') }}" class="small-box-footer">{{ __('admin_dashboard.dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
 
</div>
<!-- /.row -->
<!-- Main row -->
{{-- <div class="row">
 
  <!-- /.Left col -->
  <!-- right col (We are only adding the ID to make the widgets sortable)-->
  <section class="col-lg-12 connectedSortable">

    <!-- Map card -->
    <div class="card bg-gradient-primary">
      <div class="card-header border-0">
        <h3 class="card-title">
          <i class="fas fa-map-marker-alt mr-1"></i>
          Visitors
        </h3>
        <!-- card tools -->
        <div class="card-tools">
          <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
            <i class="far fa-calendar-alt"></i>
          </button>
          <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
        <!-- /.card-tools -->
      </div>
      <div class="card-body">
        <div id="world-map" style="height: 250px; width: 100%;"></div>
      </div>
      <!-- /.card-body-->
      <div class="card-footer bg-transparent">
        <div class="row">
          <div class="col-4 text-center">
            <div id="sparkline-1"></div>
            <div class="text-white">Visitors</div>
          </div>
          <!-- ./col -->
          <div class="col-4 text-center">
            <div id="sparkline-2"></div>
            <div class="text-white">Online</div>
          </div>
          <!-- ./col -->
          <div class="col-4 text-center">
            <div id="sparkline-3"></div>
            <div class="text-white">Sales</div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div>
    </div>
    <!-- /.card -->

   
    <!-- /.card -->
  </section>
  <!-- right col -->
</div> --}}
<!-- /.row (main row) -->


@endsection