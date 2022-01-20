<div class="col-xs-12 col-sm-4 col-md-3">
    <div class="form-group">
        <input type="hidden" value="{{ $now->format('Y-m-d') }}" name="now">
        {{ form::label('birth', 'Fecha de Nacimiento') }}
        {{ Form::date('birth', null, ['class' => 'form-control btn-light f_user','id'=>'birth'],'Y-m-d') }}
        @if ($errors->has('birth'))
            <small class="text-danger">{{ $errors->first('birth') }}</small>
        @endif
    </div>
</div>
<div class="col-xs-12 col-sm-4 col-md-3">
    <div class="form-group">
        {{ form::label('age', 'Edad') }}
        {{ form::text('age', null, ['class' => 'form-control btn-light f_user','id'=>'age', "readonly"]) }}
        @if ($errors->has('age'))
            <small class="text-danger">{{ $errors->first('age') }}</small>
        @endif
    </div>
</div>
@if(Route::currentRouteName() == 'users.create')
<input type="hidden" id="id" value="{{ $ido }}">
@endif
<div class="col-xs-12 col-sm-4 col-md-3">
    <div class="form-group">
        {{ form::label('patient_code', 'Expediente N.') }}
        {{ form::text('patient_code', null, ['class' => 'form-control btn-light f_user',"id"=>"patient_code", "readonly"]) }}
        @if ($errors->has('patient_code'))
            <small class="text-danger">{{ $errors->first('patient_code') }}</small>
        @endif
    </div>
</div>
<div class="col-xs-12 col-sm-4 col-md-3 h-medico">
    <div class="form-group">
        {{ form::label('document_type', 'Tipo de Documento') }}
        {!! Form::select('document_type',['No document'=>__('Sin documento'),'ID number' => __('ID number'),'Passport'=>__('Passport')],null, ['class'=>'form-control selectpicker f_user' ]) !!}
        @if ($errors->has('document_type'))
            <small class="text-danger">{{ $errors->first('document_type') }}</small>
        @endif
    </div>
</div>
<div class="col-xs-12 col-sm-4 col-md-3 h-medico">
    <div class="form-group">
        {{ form::label('document', 'No. de Documento') }}
        {{ form::text('document', null, ['class' => 'form-control btn-light f_user' ,'id'=>'document']) }}
        @if ($errors->has('document'))
            <small class="text-danger">{{ $errors->first('document') }}</small>
        @endif
    </div>
</div>
<div class="col-xs-12 col-sm-6 col-md-6 h-medico">
    <div class="form-group">
        {{ form::label('name_relation', 'Nombre de padre, madre o encargado') }}
        {{ form::text('name_relation', null, ['class' => 'form-control btn-light f_user','id'=>'name_relation']) }}
        @if ($errors->has('name_relation'))
            <small class="text-danger">{{ $errors->first('name_relation') }}</small>
        @endif
    </div>
</div>
<div class="col-xs-12 col-sm-4 col-md-3 h-medico">
    <div class="form-group">
        {{ form::label('kinship', 'Parentezco ') }}
        {!! Form::select('kinship',[
        'No responsible'=>__('Sin responsable'),
        'Spouse'=>__('Spouse'),
        'Mother'=>__('Mother'),
        'Father' => __('Father'),
        'Partner'=>__('Partner'),
        'Son or Daughter'=>__('Son or Daughter'),
        'Aunt or Uncle'=>__('Aunt or Uncle'),
        'Cousin'=>__('Cousin'),
        'Other'=>__('Other')],null, ['class'=>'form-control selectpicker','id'=>'kinship']) !!}
        @if ($errors->has('kinship'))
            <small class="text-danger">{{ $errors->first('kinship') }}</small>
        @endif
    </div>
</div>
