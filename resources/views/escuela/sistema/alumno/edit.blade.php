@extends('adminlte::page')
@section('content_header')
    <h2>Alumno</h2>
    @if(Session::has('warning'))
      <div class="alert alert-warning alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-exclamation-triangle"></i> ¡Advertencia!</h5>
          {{Session::get('warning')}}
      </div>
    @elseif(Session::has('danger'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> ¡Error!</h5>
        {{Session::get('danger')}}
      </div>
    @endif
    
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
    @endif    
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Editar registro</h3>
        </div>
        
        <div class="card-body">           
            <form method="POST" action="{{ route('alumno.update', $values->id) }}"  role="form">
              {{ csrf_field() }}
              <input name="_method" type="hidden" value="PATCH">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-2">
                  <div class="form-group">
                    <label for="codigo">Codigo del Alumno</label>
                    <input type="text" name="codigo" id="codigo" class="form-control form-control-alternative{{ $errors->has('codigo') ? ' is-invalid' : '' }} input-sm" placeholder="Escribir el código del alumno" value="{{ old('codigo') }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                  <div class="form-group">
                    <label for="nombre">Nombres del Alumno</label>
                    <input type="text" name="nombre" id="nombre" class="form-control form-control-alternative{{ $errors->has('nombre') ? ' is-invalid' : '' }} input-sm" placeholder="Escribir los nombres o nombre del alumno" value="{{ old('nombre') }}">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                  <div class="form-group">
                    <label for="apellido">Apellidos del Alumno</label>
                    <input type="text" name="apellido" id="apellido" class="form-control form-control-alternative{{ $errors->has('apellido') ? ' is-invalid' : '' }} input-sm" placeholder="Escribir los apellidos o apellido del alumno" value="{{ old('apellido') }}">
                  </div>
                </div>
              </div> 
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4">
                  <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="text" name="email" id="email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }} input-sm" placeholder="Escribir correo electrónico del alumno" value="{{ old('email') }}">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                  <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento del Alumno</label>
                    <input type="text" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control form-control-alternative{{ $errors->has('fecha_nacimiento') ? ' is-invalid' : '' }} input-sm" placeholder="Escribir la fecha de nacimiento del alumno" value="{{ old('fecha_nacimiento') }}">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                  <div class="form-group">
                    <label for="telefono">Teléfono del Alumno</label>
                    <input type="text" name="telefono" id="telefono" class="form-control form-control-alternative{{ $errors->has('telefono') ? ' is-invalid' : '' }} input-sm" placeholder="Escribir el número de teléfono del alumno" value="{{ old('telefono') }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <label for="municipio_id">Departamentos y Municipios</label>
                    <br>
                    <select name="municipio_id" id="input-municipio_id" class="js-example-basic-single form-control-alternative{{ $errors->has('municipio_id') ? ' is-invalid' : '' }}">
                        <option style="color: black;" value="">Seleccionar uno por favor</option>
                        @foreach ($municipios as $municipio)
                            <option style="color: black;"
                            value="{{ $municipio->id }}"
                            {{ ($municipio->id == old('municipio_id')) ? 'selected' : '' }}>{{ $municipio->nombre_completo}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <label for="domicilio">Dirección</label>
                    <input type="text" name="domicilio" id="domicilio" class="form-control form-control-alternative{{ $errors->has('domicilio') ? ' is-invalid' : '' }} input-sm" placeholder="Escribir la dirección del alumno" value="{{ old('domicilio') }}">
                  </div>
                </div>
              </div>
              <div class="row justify-content-between">
                <a href="{{ route('alumno.index') }}" class="btn btn-default" >Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
            </form> 
        </div>
      </div>
    </div>
  </div>
@endsection
