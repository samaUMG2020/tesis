@extends('adminlte::page')
@section('content_header')
    <h2>
      Registrar pago del mes {{ $mes->nombre }}      
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
          <h3 class="card-title">Pagos para el mes de <strong>{{ $mes->nombre }}</strong></h3>
        </div>
        
        <form method="POST" action="{{ route('pagoCatedratico.store') }}"  role="form">
        {{ csrf_field() }}
          <div class="card-body table-responsive p-0">
            <div class="card-body pb-0">
              <div class="row">
                  <div class="col-md-12 col-xs-12">
                      <h1 class="text-center">Catedráticos</h1>
                      <div class="row d-flex align-items-stretch">
                          <div class="col-md-12 col-xs-12">
                              <input name="mes_id" type="hidden" value="{{ old('mes_id', $mes->id) }}">
                              <div class="card-body table-responsive p-0">
                                  <table class="table table-head-fixed">
                                      <thead class="text-center" >
                                          <tr>
                                              <th>Catedrático</th>
                                              <th>Monto Q</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @if($pagos->count())  
                                              @foreach($pagos as $value)  
                                              <tr class="text-center">
                                                  <td>
                                                    {{$value->nombre_completo}}
                                                    <input name="catedratico_id[]" type="hidden" value="{{ old('catedratico_id[]', $value->catedratico_id) }}">
                                                  </td>
                                                  <td>
                                                    <div class="form-group">
                                                        <input type="text" name="{{ "monto[]" }}" id="monto" class="form-control input-sm" placeholder="Ingresar el monto de pago" value="{{ old("monto[]", $value->monto ? $value->monto : 0) }}">
                                                    </div>
                                                  </td>   
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
                      <a href="{{ route('pagoCatedratico.index') }}" class="btn btn-danger btn-lg">Cancelar</a>
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