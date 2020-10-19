@extends('adminlte::page')
@section('content_header')
    <h2>
      Promedio    
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
          <table class="table table-head-fixed">
            <thead>
              <tr>
                <th>Año</th>
                <th>Alumno</th>
                <th>Grado</th>
                <th>Curso</th>
                <th>Promedio</th>
              </tr>
            </thead>
            <tbody>
              @if($values->count())  
                @foreach($values as $value)  
                <tr>
                  <td>{{$value->anio}}</td>   
                  <td>{{$value->alumno_grado->alumno->nombre_completo}}</td>
                  <td>{{$value->alumno_grado->grado_seccion->nombre_completo}}</td>
                  <td>{{$value->curso->nombre}}</td>
                  <td>{{$value->promedio}}</td>                 
               </tr>
               @endforeach 
               @else
               <tr>
                <td colspan="5">
                  <div class="callout callout-danger"><h5>Mensaje</h5><p>¡No hay información para mostrar!</p></div>
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
        <div class="card-footer py-4">
          <nav class="d-flex justify-content-end" aria-label="...">
              {{ $values->links() }}
          </nav>                        
        </div>
      </div>
      
    </div>
  </div>
@endsection