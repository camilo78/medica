<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="form-group">
            <label class="font-weight-medium">Primer Nombre:</label>
            {!! Form::text('name1', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            @if ($errors->has('name1'))
            <small class="text-danger">{{ $errors->first('name1') }}</small>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="form-group">
            <label class="font-weight-medium">Segundo Nombre:</label>
            {!! Form::text('name2', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            @if ($errors->has('name2'))
            <small class="text-danger">{{ $errors->first('name2') }}</small>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="form-group">
            <label class="font-weight-medium">Primer Apellido:</label>
            {!! Form::text('surname1', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            @if ($errors->has('surname1'))
            <small class="text-danger">{{ $errors->first('surname1') }}</small>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="form-group">
            <label class="font-weight-medium">Segundo Apellido:</label>
            {!! Form::text('surname2', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            @if ($errors->has('surname2'))
            <small class="text-danger">{{ $errors->first('surname2') }}</small>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="form-group">
            <label class="font-weight-medium">Teléfono:</label>
            {!! Form::text('phone1', null, array('placeholder' => 'Teléfono','class' => 'form-control')) !!}
            @if ($errors->has('phone1'))
            <small class="text-danger">{{ $errors->first('phone1') }}</small>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="form-group">
            <label class="font-weight-medium">Email:</label>
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
            @if ($errors->has('email'))
            <small class="text-danger">{{ $errors->first('email') }}</small>
            @endif
        </div>
    </div>
    @php isset($user->id) ? $id = $user->id : $id = 0 @endphp
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="form-group">
            <label class="font-weight-medium">Role:</label>
            @if(auth()->id() != $id  )
            {!! Form::select('roles[]', $roles, isset($userRole) ? $userRole : '', array('class' => 'form-control selectpicker')) !!}
            @else
            <select class="form-control" name="roles" id="state" data-toggle="tooltip" data-placement="top"
                title="No tienes autorización para editar tu propio Rol">
                <option value="{{Auth::user()->roles->first()['id']}}">{{ $user->getRoleNames()->first() }}</option>
            </select>
            @endif
            @if ($errors->has('roles'))
            <small class="text-danger">{{ $errors->first('roles') }}</small>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="form-group">
            <label class="font-weight-medium">País:</label>
            <select class="form-control selectpicker" name="country_id" id="country" title="Seleccione un País"
                data-live-search="true">
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
            <label class="font-weight-medium">Departamento:</label>
            <select class="form-control" name="state_id" id="state">
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
            <label class="font-weight-medium">Ciudad:</label>
            <select class="form-control" name="city_id" id="city">
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
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="form-group">
            <label class="font-weight-medium">Clave:</label>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
            @if ($errors->has('password'))
            <small class="text-danger">{{ $errors->first('password') }}</small>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="form-group">
            <label class="font-weight-medium">Confirme Clave:</label>
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
            @if ($errors->has('confirm-password'))
            <small class="text-danger">{{ $errors->first('confirm-password') }}</small>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-6">
        <div class="form-group">
            <label class="font-weight-medium">Dirección:</label>
            {!! Form::textarea('address', null, array('placeholder' => 'Direccón','class' => 'form-control','rows'=>'2')) !!}
            @if ($errors->has('address'))
            <small class="text-danger">{{ $errors->first('address') }}</small>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary  align-self-end">Guardar</button>
    </div>
</div>
<section class="signup-step-container">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>Generales</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">2</span> <i>Step 2</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab">3</span> <i>Step 3</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab">4</span> <i>Step 4</i></a>
                            </li>
                        </ul>
                    </div>
                    <form role="form" action="index.html" class="login-box">
                        <div class="tab-content" id="main_form">
                            <div class="tab-pane active" role="tabpanel" id="step1">
                                <h4 class="text-center">Generales</h4>
                                <div class="row">

                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn next-step">Continue to next step</button></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step2">
                                <h4 class="text-center">Step 2</h4>
                                <div class="row">

                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <li><button type="button" class="default-btn next-step skip-btn">Skip</button></li>
                                    <li><button type="button" class="default-btn next-step">Continue</button></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step3">
                                <h4 class="text-center">Step 3</h4>
                                <div class="row">

                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <li><button type="button" class="default-btn next-step skip-btn">Skip</button></li>
                                    <li><button type="button" class="default-btn next-step">Continue</button></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step4">
                                <h4 class="text-center">Step 4</h4>
                                <div class="row">

                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <li><button type="button" class="default-btn next-step">Finish</button></li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
