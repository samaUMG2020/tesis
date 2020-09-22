@extends('adminlte::page')
@section('content_header')
    <h2>Grado Sección</h2>
    @if (count($errors) > 0)
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> ¡Error!</h5>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div> 
    @elseif(Session::has('danger'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> ¡Error!</h5>
        {{Session::get('danger')}}
      </div>
    @endif           
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Nuevo registro</h3>
        </div>
        
        <div class="card-body">
            <form method="POST" action="{{ route('gradoSeccion.store') }}"  role="form">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <label for="grado_id">Grado</label>
                    <select name="grado_id" id="input-grado_id" class="js-example-basic-single form-control form-control-alternative{{ $errors->has('grado_id') ? ' is-invalid' : '' }}">
                        <option style="color: black;" value="">Seleccionar uno por favor</option>
                        @foreach ($grados as $grado)
                            <option style="color: black;"
                            value="{{ $grado->id }}"
                            {{ ($grado->id == old('grado_id')) ? 'selected' : '' }}>{{ $grado->nombre_completo }}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <label for="seccion_id">Sección</label>
                    <select name="seccion_id" id="input-seccion_id" class="js-example-basic-single form-control form-control-alternative{{ $errors->has('seccion_id') ? ' is-invalid' : '' }}">
                        <option style="color: black;" value="">Seleccionar uno por favor</option>
                        @foreach ($secciones as $seccion)
                            <option style="color: black;"
                            value="{{ $seccion->id }}"
                            {{ ($seccion->id == old('seccion_id')) ? 'selected' : '' }}>{{ $seccion->nombre }}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row justify-content-between">
                <a href="{{ route('gradoSeccion.index') }}" class="btn btn-default" >Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
            </form> 
        </div>
      </div>
    </div>
  </div>
@endsection