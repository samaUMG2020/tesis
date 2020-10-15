@extends('adminlte::page')
@section('content_header')
    <h2>
      Cursos de 
      <a href="{{ route('alumnoGrado.index') }}" class="btn btn-info">{{ $values[0]->nombre_grado_seccion }}</a>         
    </h2>

    @if(Session::has('success'))
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
        <h5><i class="icon fas fa-exclamation-triangle"></i> ¡Error!</h5>
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
      <div class="card">
        <div class="card-header py-4">
          <h3 class="card-title">Cantidad de alumnos inscritos en el grado y sección: <strong>{{ $values[0]->cantidad }}</strong></h3>
        </div>
        
        <div class="card-body table-responsive p-0">
          <div class="card-body pb-0">
            <div class="row">
                <div class="col-md-8 col-xs-12 text-center">
                    <h1>Cursos</h1>
                    <div class="row d-flex align-items-stretch bg-info">
                        <div class="col-md-12 col-xs-12"><br></div>
                        @foreach ($values as $value)
                        <div class="col-md-6 col-xs-12">
                            <div class="small-box bg-success">
                            <div class="inner text-center">
                                <h1>{{ $value->nombre }}</h1>
                            </div>
                            <a href="{{ route('nota.asignar', ['grado_seccion_id' => $value->grado_seccion_id, 'curso_id' => $value->id]) }}" class="small-box-footer">Agregar notas <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <h1 class="text-center">Alumnos</h1>
                    <div class="row d-flex align-items-stretch">
                        <div class="col-md-12 col-xs-12"><br></div>
                        @foreach ($alumnos as $value)
                        <div class="col-md-12 col-xs-12">
                            <strong>Código: {{ $value->codigo }} | {{ $value->alumno }}</strong>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
          </div>
          <br>
        </div>
      </div>
    </div>
  </div>
@endsection