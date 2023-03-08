@extends('admin.layouts.layout')

@section('content')
    <div class="container">


        <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0">User Detail</h1>
                </div><!-- /.col -->
               
            </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>



        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h2>{{ __('api.admin.User.pages.view.labels.view_user') }}</h2>
                        </div>
                        <table class="table table-sm">
                            <tr>
                                <th>{{ __('api.admin.User.labels.account_type_id') }}</th>

                                <td>{{ $user->account_type_id ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.username') }}</th>

                                <td>{{ $user->username ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.dob') }}</th>

                                <td>{{ $user->user_default_info->dob ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.gender') }}</th>

                                <td>{{ $user->user_default_info->gender ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.email') }}</th>

                                <td>{{ $user->email ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.mobile') }}</th>

                                <td>{{ $user->mobile ?? '' }}</td>

                            </tr>
                            {{-- <tr>
                                <th>{{ __('api.admin.User.labels.nationality_id') }}</th>

                                <td>{{ $user->user_default_info->nationality_detail->name ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.resident_country_id') }}</th>

                                <td>{{ $user->user_default_info->nationality_current_detail->name ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.region_id') }}</th>

                                <td>{{ $user->user_default_info->region_detail->name ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.city_id') }}</th>

                                <td>{{ $user->user_default_info->city_detail->name ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.family_origin_id') }}</th>

                                <td>{{ $user->family_origin_detail->name_en ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.married_previously') }}</th>

                                <td>{{ $user->user_default_info->married_previously ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.currently_married') }}</th>

                                <td>{{ $user->user_default_info->currently_married ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.children_id') }}</th>

                                <td>{{ $user->user_default_info->children_detail->children_number_en ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.height') }}</th>

                                <td>{{ $user->user_default_info->height ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.skin_color_id') }}</th>

                                <td>{{ $user->user_default_info->skin_detail->name_en ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.education_id') }}</th>

                                <td>{{ $user->user_default_info->education_detail->name_en ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.work_id') }}</th>

                                <td>{{ $user->user_default_info->work_detail->name_en ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.smoking') }}</th>

                                <td>{{ $user->user_default_info->smoking ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.is_your_family_tribal') }}</th>

                                <td>{{ $user->is_your_family_tribal ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.tribe_id') }}</th>

                                <td>{{ $user->tribe_detail->name_en ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.do_you_care_about_tribalism') }}</th>

                                <td>{{ $user->do_you_care_about_tribalism ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.do_you_have_flexibility_to_marry_a_married_man') }}</th>

                                <td>{{ $user->do_you_have_flexibility_to_marry_a_married_man ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>{{ __('api.admin.User.labels.hijab_type_id') }}</th>

                                <td>{{ $user->hijab_detail->name_en ?? '' }}</td>

                            </tr> --}}

                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="jumbotron text-center">

            <p>

            </p>
        </div>

    </div>
@endsection
