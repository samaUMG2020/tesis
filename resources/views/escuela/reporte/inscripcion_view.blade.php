@extends('adminlte::page')
@section('content_header')
    <h2>
      Inscripciones     
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
          <h3 class="card-title">Reporte de Inscripciones del Año {{ $anio }}</h3>

          <div class="card-tools">
            <form action="{{ route('reporte.inscripcion_view') }}" method="get" role="search">
              {{ csrf_field() }}
              <div class="input-group input-group-sm" style="width: 450px;">
                <input type="text" name="anio" class="form-control float-right" value="{{ old('anio', $anio) }}" placeholder="Buscar por año">
  
                <div class="input-group-append">
                  <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
              </div>
                @if ($anio && count($errors) == 0)
                    <a class="btn btn-outline-success" href="{{ route('reporte.inscripcion_report', $anio) }}" ><small>Imprimir</small></a>
                @endif
            </form>
          </div>
        </div>
        
        <div class="card-body table-responsive p-0">
          <table class="table table-head-fixed">
            <thead>
              <tr>
                <th>Año</th>
                <th>Alumno</th>
                <th>Grado y Sección</th>
                <th>Monto</th>
                <th>Fecha de Pago</th>
              </tr>
            </thead>
            <tbody>
              @if($data->count())  
                @foreach($data as $value)  
                <tr>
                  <td class="text-center">{{$value->anio}}</td>
                  <td class="text-left">{{$value->alumno}}</td>
                  <td class="text-left">{{$value->nombre}}</td>
                  <td class="text-right">{{$value->monto}}</td>
                  <td class="text-center">{{$value->fecha}}</td>           
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
              {{ $data->links() }}
          </nav>                        
        </div>
      </div>
      
    </div>
  </div>
@endsection