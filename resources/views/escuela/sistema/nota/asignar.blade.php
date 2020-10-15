@extends('adminlte::page')
@section('content_header')
    <h2>
      Agregar nota       
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
          <h3 class="card-title">Nota para el curso: <strong>{{ $curso->nombre }}</strong></h3>
        </div>
        
        <form method="POST" action="{{ route('nota.store') }}"  role="form">
        {{ csrf_field() }}
          <div class="card-body table-responsive p-0">
            <div class="card-body pb-0">
              <div class="row">
                  <div class="col-md-12 col-xs-12">
                      <h1 class="text-center">Alumnos</h1>
                      <div class="row d-flex align-items-stretch">
                          <div class="col-md-12 col-xs-12">
                              <input name="curso_id" type="hidden" value="{{ old('curso_id', $curso->id) }}">
                              <input name="grado_seccion_id" type="hidden" value="{{ old('grado_seccion_id', $grado_seccion->id) }}">
                              <div class="card-body table-responsive p-0">
                                  <table class="table table-head-fixed">
                                      <thead class="text-center" >
                                          <tr>
                                              <th rowspan="2">Código</th>
                                              <th rowspan="2">Nombre</th>
                                              <th colspan="{{ count($bimestres) }}">Notas</th>
                                              <th rowspan="2">Promedio</th>
                                          </tr>
                                          <tr>
                                              @foreach ($bimestres as $bimestre)
                                                <th>{{ $bimestre->nombre }}</th>
                                              @endforeach
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @if($alumnos->count())  
                                              @foreach($alumnos as $value)  
                                              <tr class="text-center">
                                                  <td>
                                                    {{$value->codigo}}
                                                    <input name="alumno_grado_id[]" type="hidden" value="{{ old('alumno_grado_id[]', $value->id) }}">
                                                  </td>
                                                  <td>{{$value->alumno}}</td>
                                                  @foreach ($bimestres as $key => $bimestre)
                                                  <td>
                                                    @switch($key)
                                                        @case(0)
                                                            <div class="form-group">
                                                              <input type="text" name="{{ "nota".$key."[]" }}" id="nota" class="form-control input-sm" placeholder="{{ mb_strtolower($bimestre->nombre." ".$value->codigo) }}" value="{{ old("nota".$key."[]", $value->nota0 ? $value->nota0 : 0) }}">
                                                            </div>
                                                            @break
                                                        @case(1)
                                                            <div class="form-group">
                                                              <input type="text" name="{{ "nota".$key."[]" }}" id="nota" class="form-control input-sm" placeholder="{{ mb_strtolower($bimestre->nombre." ".$value->codigo) }}" value="{{ old("nota".$key."[]", $value->nota1 ? $value->nota1 : 0) }}">
                                                            </div>                                                            
                                                            @break
                                                        @case(2)
                                                            <div class="form-group">
                                                              <input type="text" name="{{ "nota".$key."[]" }}" id="nota" class="form-control input-sm" placeholder="{{ mb_strtolower($bimestre->nombre." ".$value->codigo) }}" value="{{ old("nota".$key."[]", $value->nota2 ? $value->nota2 : 0) }}">
                                                            </div>                                                            
                                                            @break
                                                        @case(3)
                                                            <div class="form-group">
                                                              <input type="text" name="{{ "nota".$key."[]" }}" id="nota" class="form-control input-sm" placeholder="{{ mb_strtolower($bimestre->nombre." ".$value->codigo) }}" value="{{ old("nota".$key."[]", $value->nota3 ? $value->nota3 : 0) }}">
                                                            </div>                                                            
                                                            @break
                                                    @endswitch
                                                  </td>
                                                  @endforeach   
                                                  <td>{{$value->promedio}}</td>       
                                              </tr>
                                              @endforeach
                                          @endif
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
                       
                  <div class="col-md-12 col-xs-12">
                    <hr>
                    <div class="row justify-content-between">
                      <a href="{{ route('cursoGS.show', $grado_seccion->id) }}" class="btn btn-danger btn-lg">Cancelar</a>
                      <button type="submit" class="btn btn-success btn-lg">Guardar</button>
                    </div>
                  </div>
              </div>
            </div>
            <br>
          </div> 
        </form>
      </div>
    </div>
  </div>
@endsection