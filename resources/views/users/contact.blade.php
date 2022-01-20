<div class="col-xs-12 col-sm-4 col-md-3">
    <div class="form-group">
        <label>Teléfono 1:</label> <span class="text-danger">*</span>
        {!! Form::text('phone1', null, array('class' => 'form-control btn-light f_user')) !!}
        @if ($errors->has('phone1'))
        <small class="text-danger">{{ $errors->first('phone1') }}</small>
        @endif
    </div>
</div>
<div class="col-xs-12 col-sm-4 col-md-3">
    <div class="form-group">
        <label>Teléfono 2:</label>
        {!! Form::text('phone2', null, array('class' => 'form-control btn-light f_user')) !!}
        @if ($errors->has('phone2'))
        <small class="text-danger">{{ $errors->first('phone2') }}</small>
        @endif
    </div>
</div>
<div class="col-xs-12 col-sm-4 col-md-3">
    <div class="form-group">
        <label>País:</label> <span class="text-danger">*</span>
        <select class="form-control selectpicker f_user" name="country_id" id="country" title="Seleccione un País"
            data-live-search="true">
            <option value=""></option>
            @foreach ($countries as $country)
            <option
                value="{{$country->id}}" @if(isset($user->id)){{ $user->country['id'] === $country->id ? "selected='selected'" : ''}}@endif >
                {{$country->name}}
            </option>
            @endforeach
        </select>
        @if ($errors->has('country_id'))
        <small class="text-danger">{{ $errors->first('country_id') }}</small>
        @endif
    </div>
</div>
<div class="col-xs-12 col-sm-4 col-md-3">
    <div class="form-group">
        <label>Departamento:</label> <span class="text-danger">*</span>
        <select class="form-control btn-light f_user" name="state_id" id="state">
            @if(isset($user))
            @foreach ($states as $state)
            <option
                value="{{$state->id}}" {{ $user->state['id'] === $state->id ? "selected='selected'" : ''}} >
                {{ str_replace('Department','',$state->name)}}
            </option>
            @endforeach
            @endif
        </select>
        @if ($errors->has('state_id'))
        <small class="text-danger">{{ $errors->first('state_id') }}</small>
        @endif
    </div>
</div>
<div class="col-xs-12 col-sm-4 col-md-3">
    <div class="form-group">
        <label>Ciudad:</label> <span class="text-danger">*</span>
        <select class="form-control btn-light f_user" name="city_id" id="city">
            @if(isset($user))
            @foreach ($cities as $city)
            <option
                value="{{$city->id}}" {{ $user->city['id'] === $city->id ? "selected='selected'" : ''}} >
                {{$city->name}}
            </option>
            @endforeach
            @endif
        </select>
        @if ($errors->has('city_id'))
        <small class="text-danger">{{ $errors->first('city_id') }}</small>
        @endif
    </div>
</div>
<div class="col-xs-12 col-sm-6 col-md-9">
    <div class="form-group">
        <label>Dirección:</label> <span class="text-danger">*</span>
        {!! Form::textarea('address', null, array('class' => 'form-control btn-light f_user','rows'=>'1')) !!}
        @if ($errors->has('address'))
        <small class="text-danger">{{ $errors->first('address') }}</small>
        @endif
    </div>
</div>
