@extends('admin.layouts.layout')

@section('content')

<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>60</h3>
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
      <a href="#" class="small-box-footer">{{ __('admin_dashboard.dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
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
      <a href="#" class="small-box-footer">{{ __('admin_dashboard.dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
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
      <a href="#" class="small-box-footer">{{ __('admin_dashboard.dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
 
</div>
<div class="row">

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
      <a href="#" class="small-box-footer">{{ __('admin_dashboard.dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
 
</div>

@endsection