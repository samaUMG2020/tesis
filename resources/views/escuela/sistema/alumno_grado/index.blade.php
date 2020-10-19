@extends('adminlte::page')
@section('content_header')
    <h2>
      Grados y Secciones del año {{ date('Y') }}      
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
          <h3 class="card-title">Información registrada</h3>
        </div>
        
        <div class="card-body table-responsive p-0">
          <div class="card-body pb-0">
            <div class="row d-flex align-items-stretch">
                @foreach ($values as $value)
                  <div class="col-md-3 col-xs-12">
                    <div class="small-box bg-info">
                      <div class="inner">
                        <h3>Alumnos: {{ $value->cantidad }}</h3>
                        <p>{{ $value->nombre }}</p>
                      </div>
                      <a href="{{ route('cursoGS.show', $value->id) }}" class="small-box-footer">Administrar calificaciones <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                @endforeach
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
@endsection