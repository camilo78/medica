<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            {{ form::label('name', 'Nombre') }}
            {{ form::text('name', null, ['class' => 'form-control','placeholder' => 'Nombre de la clínica']) }}
            @if ($errors->has('name'))
            <small class="text-danger">{{ $errors->first('name') }}</small>
            @endif
        </div>
    </div>
      <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            {{ form::label('phone', 'Teléfono') }}
            {{ form::text('phone', null, ['class' => 'form-control','placeholder' => 'Numero de telefónico']) }}
            @if ($errors->has('phone'))
            <small class="text-danger">{{ $errors->first('phone') }}</small>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            {{ form::label('web', 'Web') }}
            {{ form::text('web', null, ['class' => 'form-control','placeholder' => 'Sitio Web de la clínica']) }}
            @if ($errors->has('web'))
            <small class="text-danger">{{ $errors->first('web') }}</small>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
           {{ form::label('address', 'Dirección') }}
            {{ form::textarea('address', null, ['class' => 'form-control','placeholder' => 'Dirección de la clínica','rows' => 2]) }}
            @if ($errors->has('address'))
            <small class="text-danger">{{ $errors->first('address') }}</small>
            @endif
        </div>
    </div>
     <div class="col-xs-12 col-sm-12 col-md-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary  align-self-end">Guardar</button>
    </div>
</div>
