@extends('adminlte::page')
@section('content_header')
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
    <div class="col-sm-12 col-md-6">
      <div class="box box-default">
        <div class="box-body">
          <div class="callout callout-info">
            <h4 class="text-center">Gráfica de Alumnos Inscritos Actualmente</h4>
              {!! $grafica_inscritos->container() !!}  
              {!! $grafica_inscritos->script() !!}
          </div>
        </div>
      </div>
    </div>
    <div class="col-ms-12 col-md-6">
      <div class="box box-default">
        <div class="box-body">
          <div class="callout callout-info">
            <h4 class="text-center">Gráfica Pagos Mensuales de los Alumnos</h4>
              {!! $grafica_pagos_mes->container() !!}  
              {!! $grafica_pagos_mes->script() !!}
          </div>
        </div>
      </div>
    </div>
    <div class="col-ms-12 col-md-12">
      <div class="box box-default">
        <div class="box-body">
          <div class="callout callout-info">
            <h4 class="text-center">Gráfica de Cantidad de Cursos Asignados</h4>
              {!! $grafica_cursos_catedraticos->container() !!}  
              {!! $grafica_cursos_catedraticos->script() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection