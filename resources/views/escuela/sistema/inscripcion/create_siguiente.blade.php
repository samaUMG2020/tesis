@extends('adminlte::page')
@section('content_header')
    <h2>Inscripción del año {{ date("Y", strtotime(date('Y-m-d') . "+ 1 year")) }}</h2>
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
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Nuevo registro</h3>
        </div>
        
        <div class="card-body">
            <form method="POST" action="{{ route('inscripcion.store_siguiente') }}"  role="form">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <label for="alumno_id">Alumno</label>
                    <br>
                    <select name="alumno_id" id="input-alumno_id" class="js-example-basic-single form-control form-control-alternative{{ $errors->has('alumno_id') ? ' is-invalid' : '' }}">
                        <option style="color: black;" value="">Seleccionar uno por favor</option>
                        @foreach ($alumnos as $alumno)
                            <option style="color: black;"
                            value="{{ $alumno->id }}"
                            {{ ($alumno->id == old('alumno_id')) ? 'selected' : '' }}>{{ $alumno->nombre_completo}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <label for="grado_seccion_id">Grados y Sección</label>
                    <br>
                    <select name="grado_seccion_id" id="input-grado_seccion_id" class="js-example-basic-single form-control form-control-alternative{{ $errors->has('grado_seccion_id') ? ' is-invalid' : '' }}">
                        <option style="color: black;" value="">Seleccionar uno por favor</option>
                        @foreach ($grados_secciones as $grado_seccion)
                            <option style="color: black;"
                            value="{{ $grado_seccion->id }}"
                            {{ ($grado_seccion->id == old('grado_seccion_id')) ? 'selected' : '' }}>{{ $grado_seccion->nombre }}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-2">
                  <div class="form-group">
                    <label for="monto">Monto Q.</label>
                    <input type="text" name="monto" id="monto" class="form-control form-control-alternative{{ $errors->has('monto') ? ' is-invalid' : '' }} input-sm" placeholder="Monto de inscripción" value="{{ old('monto', $monto) }}">
                  </div>
                </div>
              </div>
              <div class="row justify-content-between">
                <a href="{{ route('inscripcion.index') }}" class="btn btn-default" >Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
            </form> 
        </div>
      </div>
    </div>
  </div>
@endsection