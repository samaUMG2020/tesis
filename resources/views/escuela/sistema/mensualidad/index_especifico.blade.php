@extends('adminlte::page')
@section('content_header')
    <h2>
      Mensualidades de la Inscripción #{{ $inscripcion->id }}     
    </h2>

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
    @elseif(Session::has('success'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
        {{Session::get('success')}}
      </div>
    @elseif(Session::has('warning'))
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> ¡Advertencia!</h5>
        {{Session::get('warning')}}
      </div>
    @elseif(Session::has('danger'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> ¡Advertencia!</h5>
        {{Session::get('danger')}}
      </div>
    @elseif(Session::has('info'))
      <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> ¡Información!</h5>
        {{Session::get('info')}}
      </div>
    @endif    
@endsection

@section('content')
  <div class="row">

    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Registrar nuevo pago de mensualidad</h3>
        </div>
        
        <div class="card-body">
          <form method="POST" action="{{ route('mensualidad.store') }}"  role="form">
            {{ csrf_field() }}
            <input name="inscripcion_id" type="hidden" value="{{ $inscripcion->id }}">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <label for="alumno_id">Alumno</label>
                  <br>
                  <p>{{ $alumno_grado->alumno->nombre_completo }}</p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <label for="grado_seccion_id">Grados y Sección</label>
                  <br>
                  <p>{{ $alumno_grado->grado_seccion->nombre_completo }}</p>
                </div>
              </div>
            </div>
            <div class="row">

              <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                  <label for="anio">Año</label>
                  <br>
                  <p>{{ $inscripcion->anio }}</p>
                </div>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                  <label for="mes_id">Mes</label>
                  <br>
                  <select name="mes_id" id="input-mes_id" class="js-example-basic-single form-control form-control-alternative{{ $errors->has('mes_id') ? ' is-invalid' : '' }}">
                      <option style="color: black;" value="">Seleccionar uno por favor</option>
                      @foreach ($meses as $mes)
                          <option style="color: black;"
                          value="{{ $mes->id }}"
                          {{ ($mes->id == old('mes_id')) ? 'selected' : '' }}>{{ $mes->nombre }}</option>
                      @endforeach
                  </select>
                </div>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                  <label for="monto">Monto Q.</label>
                  <input type="text" name="monto" id="monto" class="form-control form-control-alternative{{ $errors->has('monto') ? ' is-invalid' : '' }} input-sm" placeholder="Monto de inscripción" value="{{ old('monto', $monto) }}">
                </div>
              </div>

            </div>
            <div class="row justify-content-between">
                <a href="{{ route('inscripcion.index') }}" class="btn btn-success" >Regresar a las inscripciones</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form> 
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-header py-4">
          <h3 class="card-title">Información registrada</h3>
        </div>
        
        <div class="card-body table-responsive p-0">
          <table class="table table-head-fixed">
            <thead>
              <tr>
                <th>#</th>
                <th>Mes</th>
                <th>Monto</th>
                <th>Fecha de ingreso</th>
              </tr>
            </thead>
            <tbody>
              @if($mensualidades->count())  
                @foreach($mensualidades as $value)  
                <tr>
                  <td>{{$value->id}}</td>
                  <td>{{$value->mes}}</td>
                  <td>{{"Q ".number_format($value->monto,2,'.',',')}}</td>
                  <td>{{$value->created_at}}</td>           
               </tr>
               @endforeach 
               @else
               <tr>
                <td colspan="4">
                  <div class="callout callout-danger"><h5>Mensaje</h5><p>¡No hay información para mostrar!</p></div>
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
      
    </div>
  </div>
@endsection