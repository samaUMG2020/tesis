@extends('adminlte::page')
@section('content_header')
    <h2>
      Fondos  
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

    <div class="col-6">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Registrar nuevo fondo para el año {{ date('Y') }}</h3>
        </div>
        
        <div class="card-body">
          <form method="POST" action="{{ route('fondo.store') }}"  role="form">
            {{ csrf_field() }}
            <input name="fondo" type="hidden" value="actual">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <label for="tipo_fondo_id">Tipo de Fondo</label>
                  <br>
                  <select name="tipo_fondo_id" id="input-tipo_fondo_id" class="js-example-basic-single form-control form-control-alternative{{ $errors->has('tipo_fondo_id') ? ' is-invalid' : '' }}">
                      <option style="color: black;" value="">Seleccionar uno por favor</option>
                      @foreach ($tipo_fondos as $tipo_fondo)
                          <option style="color: black;"
                          value="{{ $tipo_fondo->id }}"
                          {{ ($tipo_fondo->id == old('tipo_fondo_id')) ? 'selected' : '' }}>{{ $tipo_fondo->nombre }}</option>
                      @endforeach
                  </select>
                </div>
              </div>                
              <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                  <label for="cantidad">Monto Q.</label>
                  <input type="text" name="cantidad" id="cantidad" class="form-control form-control-alternative{{ $errors->has('cantidad') ? ' is-invalid' : '' }} input-sm" placeholder="Monto del fondo" value="{{ old('cantidad') }}">
                </div>
              </div>
            </div>
            <div class="row justify-content-between">
                <a href="{{ route('fondo.index') }}" class="btn btn-danger" >Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form> 
        </div>
      </div>
    </div>

    <div class="col-6">
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">Registrar nuevo fondo para el año {{ date("Y", strtotime(date('Y-m-d') . "+ 1 year")) }}</h3>
        </div>
        
        <div class="card-body">
          <form method="POST" action="{{ route('fondo.store') }}"  role="form">
            {{ csrf_field() }}
            <input name="fondo" type="hidden" value="siguiente">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <label for="tipo_fondo_id">Tipo de Fondo</label>
                  <br>
                  <select name="tipo_fondo_id" id="input-tipo_fondo_id" class="js-example-basic-single form-control form-control-alternative{{ $errors->has('tipo_fondo_id') ? ' is-invalid' : '' }}">
                      <option style="color: black;" value="">Seleccionar uno por favor</option>
                      @foreach ($tipo_fondos as $tipo_fondo)
                          <option style="color: black;"
                          value="{{ $tipo_fondo->id }}"
                          {{ ($tipo_fondo->id == old('tipo_fondo_id')) ? 'selected' : '' }}>{{ $tipo_fondo->nombre }}</option>
                      @endforeach
                  </select>
                </div>
              </div>                
              <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                  <label for="cantidad">Monto Q.</label>
                  <input type="text" name="cantidad" id="cantidad" class="form-control form-control-alternative{{ $errors->has('cantidad') ? ' is-invalid' : '' }} input-sm" placeholder="Monto del fondo" value="{{ old('cantidad') }}">
                </div>
              </div>
            </div>
            <div class="row justify-content-between">
                <a href="{{ route('fondo.index') }}" class="btn btn-danger" >Cancelar</a>
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
                <th>Año</th>
                <th>Tipo de Fondo</th>
                <th>Monto</th>
                <th>Fecha de ingreso</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @if($values->count())  
                @foreach($values as $value)  
                <tr>
                  <td>{{$value->anio}}</td>
                  <td>{{$value->tipo_fondo->nombre}}</td>
                  <td>{{"Q ".number_format($value->cantidad,2,'.',',')}}</td> 
                  <td>{{$value->created_at}}</td> 
                  <td>
                    <form action="{{ route('fondo.destroy', $value) }}" method="post">
                      {{csrf_field()}}
                      <input name="_method" type="hidden" value="DELETE">
                      <button class="btn btn-outline-danger" type="submit"><span class="fa fa-trash-alt"></span></button>
                    </form>
                  </td>          
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