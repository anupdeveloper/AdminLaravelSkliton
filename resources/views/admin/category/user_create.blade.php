
@extends('admin.layouts.layout')

@section('content')
<div class="container">


    <h1>{{ __('api.admin.User.pages.add.labels.create_a_user') }}</h1>

    <!-- if there are creation errors, they will show here -->
    <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
        {{@csrf_field()}}
        <div class="row">

                
<div class="col-lg-12">
    <div class="form-group">
        <label for="account_type_id">{{ __('api.admin.User.labels.account_type_id') }}</label>
        <input type="text" class="form-control" name="account_type_id" id="account_type_id" value="{{Request::old('account_type_id')}}">
        @error('account_type_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="username">{{ __('api.admin.User.labels.username') }}</label>
        <input type="text" class="form-control" name="username" id="username" value="{{Request::old('username')}}">
        @error('username')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="dob">{{ __('api.admin.User.labels.dob') }}</label>
        <input type="text" class="form-control" name="dob" id="dob" value="{{Request::old('dob')}}">
        @error('dob')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="gender">{{ __('api.admin.User.labels.gender') }}</label>
        <select class="form-control" name="gender" id="gender">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('gender'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('gender')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="email">{{ __('api.admin.User.labels.email') }}</label>
        <input type="text" class="form-control" name="email" id="email" value="{{Request::old('email')}}">
        @error('email')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="mobile">{{ __('api.admin.User.labels.mobile') }}</label>
        <input type="text" class="form-control" name="mobile" id="mobile" value="{{Request::old('mobile')}}">
        @error('mobile')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="nationality_id">{{ __('api.admin.User.labels.nationality_id') }}</label>
        <select class="form-control" name="nationality_id" id="nationality_id">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('nationality_id'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('nationality_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="resident_country_id">{{ __('api.admin.User.labels.resident_country_id') }}</label>
        <select class="form-control" name="resident_country_id" id="resident_country_id">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('resident_country_id'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('resident_country_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="region_id">{{ __('api.admin.User.labels.region_id') }}</label>
        <select class="form-control" name="region_id" id="region_id">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('region_id'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('region_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="city_id">{{ __('api.admin.User.labels.city_id') }}</label>
        <select class="form-control" name="city_id" id="city_id">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('city_id'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('city_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="family_origin_id">{{ __('api.admin.User.labels.family_origin_id') }}</label>
        <select class="form-control" name="family_origin_id" id="family_origin_id">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('family_origin_id'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('family_origin_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="married_previously">{{ __('api.admin.User.labels.married_previously') }}</label>
        <select class="form-control" name="married_previously" id="married_previously">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('married_previously'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('married_previously')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="currently_married">{{ __('api.admin.User.labels.currently_married') }}</label>
        <select class="form-control" name="currently_married" id="currently_married">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('currently_married'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('currently_married')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="children_id">{{ __('api.admin.User.labels.children_id') }}</label>
        <select class="form-control" name="children_id" id="children_id">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('children_id'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('children_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="height">{{ __('api.admin.User.labels.height') }}</label>
        <input type="text" class="form-control" name="height" id="height" value="{{Request::old('height')}}">
        @error('height')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="skin_color_id">{{ __('api.admin.User.labels.skin_color_id') }}</label>
        <select class="form-control" name="skin_color_id" id="skin_color_id">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('skin_color_id'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('skin_color_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="education_id">{{ __('api.admin.User.labels.education_id') }}</label>
        <select class="form-control" name="education_id" id="education_id">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('education_id'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('education_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="work_id">{{ __('api.admin.User.labels.work_id') }}</label>
        <select class="form-control" name="work_id" id="work_id">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('work_id'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('work_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="smoking">{{ __('api.admin.User.labels.smoking') }}</label>
        <input type="text" class="form-control" name="smoking" id="smoking" value="{{Request::old('smoking')}}">
        @error('smoking')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="is_your_family_tribal">{{ __('api.admin.User.labels.is_your_family_tribal') }}</label>
        <select class="form-control" name="is_your_family_tribal" id="is_your_family_tribal">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('is_your_family_tribal'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('is_your_family_tribal')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="tribe_id">{{ __('api.admin.User.labels.tribe_id') }}</label>
        <select class="form-control" name="tribe_id" id="tribe_id">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('tribe_id'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('tribe_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="do_you_care_about_tribalism">{{ __('api.admin.User.labels.do_you_care_about_tribalism') }}</label>
        <select class="form-control" name="do_you_care_about_tribalism" id="do_you_care_about_tribalism">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('do_you_care_about_tribalism'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('do_you_care_about_tribalism')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="do_you_have_flexibility_to_marry_a_married_man">{{ __('api.admin.User.labels.do_you_have_flexibility_to_marry_a_married_man') }}</label>
        <select class="form-control" name="do_you_have_flexibility_to_marry_a_married_man" id="do_you_have_flexibility_to_marry_a_married_man">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('do_you_have_flexibility_to_marry_a_married_man'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('do_you_have_flexibility_to_marry_a_married_man')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="hijab_type_id">{{ __('api.admin.User.labels.hijab_type_id') }}</label>
        <select class="form-control" name="hijab_type_id" id="hijab_type_id">
            <option value="">--SELECT--</option>
             @if(isset($select) && $select)
            @foreach($select as $row)
            <option value="{{$row->id}}" {{($row->id==Request::old('hijab_type_id'))?'selected':''}}>{{$row->name}}</option>
            @endforeach 
            @endif 
        </select>
        @error('hijab_type_id')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

            
            <div class="col-lg-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
            </div>

        </div>
    </form>

</div>

@endsection

<script>
    // CKEDITOR.replace('description1')
</script>

