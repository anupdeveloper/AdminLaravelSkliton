
@extends('admin.layouts.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">{{ __('api.admin.User.pages.edit.labels.edit_a_user') }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        {{-- <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
        </ol> --}}
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">



    {{-- <h1>{{ __('api.admin.User.pages.edit.labels.edit_a_user') }}</h1> --}}

    <!-- if there are creation errors, they will show here -->
    <form action="{{  route('admin.user.update',['id'=>$user['id']]) }}" method="POST" enctype="multipart/form-data" >
        @method('PATCH')
        @csrf
        <div class="row">

          
            
<div class="col-lg-4">
    <div class="form-group">
        <label for="account_type_id">{{ __('api.admin.User.labels.account_type_id') }}</label>
        {{-- <input type="text" class="form-control" name="account_type_id" id="account_type_id" value="{{$user->account_type_id??''}}"> --}}
        <select disabled class="form-control" name="account_type_id" id="account_type_id">
            <option value="">--SELECT--</option>
            @if(isset($account_types) && $account_types)
            @foreach($account_types as $row)
            <option value="{{$row->id}}" {{ ($user->account_type && $user->account_type->id==$row->id)?'selected':'' }}>{{$row->name}}</option>
            @endforeach 
            @endif
        </select>

        @error('account_type_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="username">{{ __('api.admin.User.labels.username') }}</label>
        <input readonly type="text" class="form-control" name="username" id="username" value="{{$user->username??''}}">
        @error('username')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>


@if( isset($user->account_type) && $user->account_type->id == 2 )
<div class="col-lg-4">
    <div class="form-group">
        <label for="gender">{{ __('api.admin.User.labels.gender') }}</label>
        <select class="form-control" name="gender" id="gender">
            <option value="">--SELECT--</option>
            
                <option {{ $user->members[0]->gender=='male'?'selected':'' }} value="male">Male</option> 
                <option {{ $user->members[0]->gender=='female'?'selected':'' }} value="female">Female</option> 

        </select>
        @error('gender')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="dob">{{ __('api.admin.User.labels.dob') }}</label>
        <input type="date" class="form-control" name="dob" id="dob" value="{{$user->members[0]->dob??''}}">
        @error('dob')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>


<div class="col-lg-4">
    <div class="form-group">
        <label for="married_previously">{{ __('api.admin.User.labels.married_previously') }}</label>
        <select class="form-control" name="married_previously" id="married_previously">
            <option value="">--SELECT--</option>
            <option {{ $user->members[0]->married_previously=='yes'?'selected':'' }} value="yes">YES</option>
            <option {{ $user->members[0]->married_previously=='no'?'selected':'' }} value="no">NO</option>
        </select>
        @error('married_previously')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="currently_married">{{ __('api.admin.User.labels.currently_married') }}</label>
        <select class="form-control" name="currently_married" id="currently_married">
            <option value="">--SELECT--</option>
            <option {{ $user->members[0]->currently_married=='yes'?'selected':'' }} value="yes">YES</option>
            <option {{ $user->members[0]->currently_married=='no'?'selected':'' }} value="no">NO</option>
        </select>
        @error('currently_married')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="children_id">{{ __('api.admin.User.labels.children_id') }}</label>
        <select class="form-control" name="children_id" id="children_id">
            <option value="">--SELECT--</option>
            @if(isset($childrens) && $childrens)
            @foreach($childrens as $row)
            <option value="{{$row->id}}" {{($row->id==$user->members[0]->children_id)?'selected':''}}>{{session('locale')=='ar'?$row->children_number_ar:$row->children_number_en}}</option>
            @endforeach 
            @endif
        </select>
        @error('children_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="height">{{ __('api.admin.User.labels.height') }}</label>
        <input type="text" name="height" value="{{ $user->members[0]->height }}" class="form-control">
        @error('height')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="skin_color_id">{{ __('api.admin.User.labels.skin_color_id') }}</label>
        <select class="form-control" name="skin_color_id" id="skin_color_id">
            <option value="">--SELECT--</option>
            @if(isset($skin_colors) && $skin_colors)
            @foreach($skin_colors as $row)
            <option value="{{$row->id}}" {{($row->id==$user->members[0]->skin_color_id)?'selected':''}}>{{session('locale')=='ar'?$row->name_ar:$row->name_en}}</option>
            @endforeach 
            @endif
        </select>
        @error('skin_color_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="education_id">{{ __('api.admin.User.labels.education_id') }}</label>
        <select class="form-control" name="education_id" id="education_id">
            <option value="">--SELECT--</option>
            @if(isset($educations) && $educations)
            @foreach($educations as $row)
            <option value="{{$row->id}}" {{($row->id==$user->members[0]->education_id)?'selected':''}}>{{(session('locale')=='ar')?$row->name_ar:$row->name_en}}</option>
            @endforeach 
            @endif
        </select>
        @error('education_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="work_id">{{ __('api.admin.User.labels.work_id') }}</label>
        <select class="form-control" name="work_id" id="work_id">
            <option value="">--SELECT--</option>
            @if(isset($works) && $works)
            @foreach($works as $row)
            <option value="{{$row->id}}" {{($row->id==$user->members[0]->work_id)?'selected':''}}>{{session('locale')=='ar'?$row->name_ar:$row->name_en}}</option>
            @endforeach 
            @endif
        </select>
        @error('work_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="smoking">{{ __('api.admin.User.labels.smoking') }}</label>
       
        <select class="form-control" name="smoking" id="smoking">
            <option value="">--SELECT--</option>
            <option {{ $user->members[0]->smoking=='yes'?'selected':'' }} value="yes">{{ __('admin_dashboard.common.yes') }}</option>
            <option {{ $user->members[0]->smoking=='no'?'selected':'' }} value="no">{{ __('admin_dashboard.common.no') }}</option>
        </select>
        @error('smoking')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="hijab_type_id">{{ __('api.admin.User.labels.hijab_type_id') }}</label>
        <select class="form-control" name="hijab_type_id" id="hijab_type_id">
            <option value="">--SELECT--</option>
            @if(isset($hijab_types) && $hijab_types)
            @foreach($hijab_types as $row)
            <option value="{{$row->id}}" {{($row->id==$user->members[0]->hijab_type_id)?'selected':''}}>{{session('locale')=='ar'?$row->name_ar:$row->name_en}}</option>
            @endforeach 
            @endif
        </select>
        @error('hijab_type_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

@endif
<div class="col-lg-4">
    <div class="form-group">
        <label for="email">{{ __('api.admin.User.labels.email') }}</label>
        <input readonly type="text" class="form-control" name="email" id="email" value="{{$user->email??''}}">
        @error('email')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="mobile">{{ __('api.admin.User.labels.mobile') }}</label>
        <input type="text" class="form-control" name="mobile" id="mobile" value="{{$user->mobile??''}}">
        @error('mobile')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="nationality_id">{{ __('api.admin.User.labels.nationality_id') }}</label>
        <select class="form-control" name="nationality_id" id="nationality_id">
            <option value="">--SELECT--</option>
            @if(isset($countries) && $countries)
            @foreach($countries as $row)
            <option value="{{$row->id}}" {{($row->id==$user->nationality_id)?'selected':''}}>
                {{$row->name}}
            </option>
            @endforeach 
            @endif
        </select>
        @error('nationality_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="resident_country_id">{{ __('api.admin.User.labels.resident_country_id') }}</label>
        <select class="form-control" name="resident_country_id" id="resident_country_id">
            <option value="">--SELECT--</option>
            @if(isset($countries) && $countries)
            @foreach($countries as $row)
            <option value="{{$row->id}}" {{($row->id==$user->nationality_id)?'selected':''}}>
                {{$row->name}}
            </option>
            @endforeach 
            @endif
        </select>
        @error('resident_country_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="region_id">{{ __('api.admin.User.labels.region_id') }}</label>
        <select class="form-control" name="region_id" id="region_id">
            <option value="">--SELECT--</option>
            @if(isset($regions) && $regions)
            @foreach($regions as $row)
            <option value="{{$row->id}}" {{($row->id==$user->region_id)?'selected':''}}>
                {{$row->name}}
            </option>
            @endforeach 
            @endif
        </select>
        @error('region_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="city_id">{{ __('api.admin.User.labels.city_id') }}</label>
        <select class="form-control" name="city_id" id="city_id">
            <option value="">--SELECT--</option>
            @if(isset($cities) && $cities)
            @foreach($cities as $row)
            <option value="{{$row->id}}" {{($row->id==$user->city_id)?'selected':''}}>{{session('locale')=='ar'?$row->name_ar:$row->name}}</option>
            @endforeach 
            @endif
        </select>
        @error('city_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="family_origin_id">{{ __('api.admin.User.labels.family_origin_id') }}</label>
        <select class="form-control" name="family_origin_id" id="family_origin_id">
            <option value="">--SELECT--</option>
            @if(isset($family_origins) && $family_origins)
            @foreach($family_origins as $row)
            <option value="{{$row->id}}" {{($row->id==$user->family_origin_id)?'selected':''}}>{{session('locale')=='ar'?$row->name_ar:$row->name_en}}</option>
            @endforeach 
            @endif
        </select>
        @error('family_origin_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>



<div class="col-lg-4">
    <div class="form-group">
        <label for="is_your_family_tribal">{{ __('api.admin.User.labels.is_your_family_tribal') }}</label>
        <select class="form-control" name="is_your_family_tribal" id="is_your_family_tribal">
            <option value="">--SELECT--</option>
            <option {{ $user->is_your_family_tribal=='yes'?'selected':'' }} value="yes">{{ __('admin_dashboard.common.yes') }}</option>
            <option {{ $user->is_your_family_tribal=='no'?'selected':'' }} value="no">{{ __('admin_dashboard.common.no') }}</option>
        </select>
        @error('is_your_family_tribal')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="tribe_id">{{ __('api.admin.User.labels.tribe_id') }}</label>
        <select class="form-control" name="tribe_id" id="tribe_id">
            <option value="">--SELECT--</option>
            @if(isset($tribes) && $tribes)
            @foreach($tribes as $row)
            <option value="{{$row->id}}" {{($row->id==$user->tribe_id)?'selected':''}}>{{session('locale')=='ar'?$row->name_ar:$row->name_en}}</option>
            @endforeach 
            @endif
        </select>
        @error('tribe_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="do_you_care_about_tribalism">{{ __('api.admin.User.labels.do_you_care_about_tribalism') }}</label>
        <select class="form-control" name="do_you_care_about_tribalism" id="do_you_care_about_tribalism">
            <option value="">--SELECT--</option>
            <option {{ $user->do_you_care_about_tribalism=='yes'?'selected':'' }} value="yes">{{ __('admin_dashboard.common.yes') }}</option>
            <option {{ $user->do_you_care_about_tribalism=='no'?'selected':'' }} value="no">{{ __('admin_dashboard.common.no') }}</option>
        </select>
        @error('do_you_care_about_tribalism')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-4">
    <div class="form-group">
        <label for="do_you_allow_talking_before_marriage">{{ __('api.admin.User.labels.do_you_allow_talking_before_marriage') }}</label>
        <select class="form-control" name="do_you_allow_talking_before_marriage" id="do_you_allow_talking_before_marriage">
            <option value="">--SELECT--</option>
            <option {{ $user->do_you_allow_talking_before_marriage=='yes'?'selected':'' }} value="yes">{{ __('admin_dashboard.common.yes') }}</option>
            <option {{ $user->do_you_allow_talking_before_marriage=='no'?'selected':'' }} value="no">{{ __('admin_dashboard.common.no') }}</option>
        </select>
        @error('do_you_have_flexibility_to_marry_a_married_man')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>
@if( isset($user->account_type) && $user->account_type->id == 1 )
<div class="col-lg-4">
    <div class="form-group">
        <label for="about_family">{{ __('api.admin.User.labels.about_family') }}</label>
        <textarea class="form-control" name="about_family" id="about_family"> {{ $user->about_family }}</textarea>
        @error('about_family')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>
@else
<div class="col-lg-4">
    <div class="form-group">
        <label for="about_me">{{ __('api.admin.User.labels.about_me') }}</label>
        <textarea class="form-control" name="bio" id="bio"> {{$user->members[0]->bio }}</textarea>
        @error('about_me')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

@endif

            <div class="col-lg-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('api.admin.User.pages.edit.button.update') }}</button>
                </div>
            </div>

        </div>
    </form>

</div>

@endsection

<script>
    //CKEDITOR.replace('description1')
</script>

