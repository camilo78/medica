<div id="ERROR_COPY" style="display:none">
        @foreach ($errors->all() as $error)
            <p style="text-align:left;"><i class="fas fa-arrow-right fa-fw text-danger"></i> {{ $error }}</p>
        @endforeach
</div>
<div class="col-lg-10">
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="form-group">
                {{ form::label('name1', 'Primer Nombre') }} <span class="text-danger">*</span>
                {{ form::text('name1', null, ['class' => 'form-control','id'=>'name1']) }}
                @if ($errors->has('name1'))
                    <small class="text-danger">{{ $errors->first('name1') }}</small>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="form-group">
                {{ form::label('name2', 'Segundo Nombre') }}
                {{ form::text('name2', null, ['class' => 'form-control']) }}
                @if ($errors->has('name2'))
                    <small class="text-danger">{{ $errors->first('name2') }}</small>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="form-group">
                {{ form::label('surname1', 'Primer Apellído') }} <span class="text-danger">*</span>
                {{ form::text('surname1', null, ['class' => 'form-control','id'=>'surname1']) }}
                @if ($errors->has('surname1'))
                    <small class="text-danger">{{ $errors->first('surname1') }}</small>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="form-group">
                {{ form::label('surname2', 'Segundo Apellído') }}
                {{ form::text('surname2', null, ['class' => 'form-control']) }}
                @if ($errors->has('name2'))
                    <small class="text-danger">{{ $errors->first('surname2') }}</small>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="form-group">
                {{ form::label('gender', 'Sexo') }} <span class="text-danger">*</span>
                {!! Form::select('gender',['M' => 'Hombre','F'=>'Mujer'],null, ['class'=>'form-control selectpicker','placeholder'=>'Seleccione el sexo', "id"=>"gender"]) !!}
                @if ($errors->has('gender'))
                    <small class="text-danger">{{ $errors->first('gender') }}</small>
                @endif
            </div>
        </div>
        <div class="col-sm-3 s_up">
            <div class="form-group">
                {{ form::label('civil', 'Estado Civil' ) }}
                {!! Form::select('civil',['Single' => __('Single'),'Married'=>__('Married')],null, ['class'=>'form-control selectpicker','placeholder'=>'Seleccione estado',"id"=>"civil"]) !!}
                @if ($errors->has('civil'))
                    <small class="text-danger">{{ $errors->first('civil') }}</small>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-3 d-none" id="married">
            <div class="form-group">
                {{ form::label('married_name', 'Apellído de Casada') }}
                {{ form::text('married_name', null, ['class' => 'form-control']) }}
                @if ($errors->has('married_name'))
                    <small class="text-danger">{{ $errors->first('married_name') }}</small>
                @endif
            </div>
        </div>
        @php isset($user->id) ? $id = $user->id : $id = 0 @endphp
        <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="form-group">
                <label>Role:</label>
                @if(auth()->id() != $id  )
                    {!! Form::select('roles', $roles, isset($userRole) ? $userRole : '', array('class' => 'form-control selectpicker', 'id'=>'role')) !!}
                @else
                    <select class="form-control" name="roles" id="role" data-toggle="tooltip" data-placement="top"
                            title="No tienes autorización para editar tu propio Rol">
                        <option
                            value="{{Auth::user()->roles->first()['id']}}">{{ $user->getRoleNames()->first() }}</option>
                    </select>
                @endif
                @if ($errors->has('roles'))
                    <small class="text-danger">{{ $errors->first('roles') }}</small>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4" >
            <div class="form-group">
                <label>Email:</label> <span class="text-danger">*</span>
                {!! Form::text('email', null, array('class' => 'form-control')) !!}
                @if ($errors->has('email'))
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4" style="border: dashed 1px #AED6F1" >
            <div class="form-group">
                <label>Clave:</label>
                @if(Route::current()->getName() == 'users.create')
                    <span class="text-danger">*</span>
                @endif
                {!! Form::password('password', array('class' => 'form-control')) !!}
                @if ($errors->has('password'))
                    <small class="text-danger">{{ $errors->first('password') }}</small>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4" style="border: dashed 1px #AED6F1">
            <div class="form-group">
                <label>Confirme Clave:</label>
                @if(Route::current()->getName() == 'users.create')
                    <span class="text-danger">*</span>
                @endif
                {!! Form::password('confirm-password', array('class' => 'form-control')) !!}
                @if ($errors->has('confirm-password'))
                    <small class="text-danger">{{ $errors->first('confirm-password') }}</small>
                @endif
            </div>
        </div>
        <div class="col-lg-12 mb-2">
            @if( Route::currentRouteName() == route('users.create'))
                <small class="text-primary d-flex justify-content-end">* Utiliza estos campos solo si quieres crear una contraseña.</small>
            @else
                <small class="text-primary d-flex justify-content-end">* Utiliza estos campos solo si quieres editar la contraseña.</small>
            @endif
        </div>
    </div>
</div>
</div>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: none">
        {{-- <a class="nav-link nav-link-user active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
           aria-controls="nav-home" aria-selected="true">Datos Complementarios</a> --}}
        {{-- <a class="nav-link nav-link-user" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab"
           aria-controls="nav-contact" aria-selected="false">Datos de Contacto</a> --}}
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="col-lg-12 p-4">
            <div class="row">
                @include('users.general')
                @include('users.contact')
            </div>
        </div>
    </div>
    {{-- <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
        <div class="col-lg-12 p-4">
            <div class="row">

            </div>
        </div>
    </div> --}}
</div>
<div class="row mt-4">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <span class="text-danger small">Los campos marcados con asterisco (*), son obligatorios.</span>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary  align-self-end">Guardar</button>
    </div>
</div>
</div>
