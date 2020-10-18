@extends('adminlte::page')
@section('content_header')
    <h2>
      Cursos del Catedrático {{ $catedratico->nombre_completo }}  
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
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Asignar nuevo curso</h3>
        </div>
        
        <div class="card-body">
          <form method="POST" action="{{ route('catedraticoCurso.store') }}"  role="form">
            {{ csrf_field() }}
            <input name="pantalla" type="hidden" value="{{ $pantalla }}">
            <input name="catedratico_id" type="hidden" value="{{ $catedratico->id }}">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <label for="curso_g_s_id">Curso</label>
                  <br>
                  <select name="curso_g_s_id" id="input-curso_g_s_id" class="js-example-basic-single form-control form-control-alternative{{ $errors->has('curso_g_s_id') ? ' is-invalid' : '' }}">
                      <option style="color: black;" value="">Seleccionar uno por favor</option>
                      @foreach ($cursos as $curso)
                          <option style="color: black;"
                          value="{{ $curso->id }}"
                          {{ ($curso->id == old('curso_g_s_id')) ? 'selected' : '' }}>{{ $curso->nombre_completo }}</option>
                      @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row justify-content-between">
                <a href="{{ route('catedratico.index') }}" class="btn btn-success" >Regresar al listado de catedráticos</a>
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
                <th>Curso</th>
                <th>Estado</th>
                <th>Fecha de ingreso</th>
              </tr>
            </thead>
            <tbody>
              @if($values->count())  
                @foreach($values as $value)  
                <tr>
                  <td>{{$value->curso_g_s->nombre_completo}}</td>
                  <td>{{$value->activo ? 'ACTIVO' : 'INACTIVO'}}</td>
                  <td>{{$value->created_at}}</td>           
               </tr>
               @endforeach 
               @else
               <tr>
                <td colspan="3">
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