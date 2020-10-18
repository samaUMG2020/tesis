@extends('adminlte::page')
@section('content_header')
    <h2>
      Usuarios
      <a href="{{ route('usuario.create') }}" class="btn btn-info">Nuevo</a>       
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

          <div class="card-tools">
            <form action="{{ route('usuario.index') }}" method="get" role="search">
              {{ csrf_field() }}
              <div class="input-group input-group-sm" style="width: 450px;">
                <input type="text" name="buscar" class="form-control float-right" placeholder="Buscar">
  
                <div class="input-group-append">
                  <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
        
        <div class="card-body table-responsive p-0">
          <div class="card-body pb-0">
            <div class="row d-flex align-items-stretch">
              @foreach ($values as $value)
              <div class="col-12 col-sm-12 col-md-4 d-flex align-items-stretch">
                <div class="card bg-light">
                  <div class="card-header text-muted border-bottom-0"></div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead"><b>{{ $value->nombre_completo }}</b></h2>
                        <p class="text-muted text-sm"><b>Email: </b> {{ $value->email }} </p>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                          <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Dirección: {{ "{$value->persona->municipio->nombre_completo}, {$value->persona->direccion}" }}</li>
                          <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Teléfono #: {{ $value->persona->telefono }}</li>
                          <li class="small"><span class="fa-li"><i class="fas fa-birthday-cake"></i></span> Fecha de Nacimiento: {{ $value->persona->fechaPersona() }}</li>
                          <li class="small"><span class="fa-li"><i class="fas fa-praying-hands"></i></span> Edad: {{ $value->persona->edadPersona() }}</li>
                        </ul>
                      </div>
                      <div class="col-5 text-center">
                        <img src="{{ asset('img/user.png') }}" alt="" class="img-circle img-fluid">
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">
                      <form action="{{ route('usuario.destroy', $value) }}" method="post">
                        <a class="btn btn-sm {{ $value->activo ? 'btn-info' : 'btn-success' }}" href="{{ route('usuario.show', $value) }}" >{{ $value->activo ? 'DESACTIVAR' : 'ACTIVAR' }}</a>
                        <a class="btn btn-sm btn-warning" href="{{ route('usuario.edit', $value) }}" ><i class="fas fa-pencil-alt"></i> Editar</a>
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-sm btn-danger" type="submit"><i class="fas fa-trash-alt"></i> Eliminar</button>
                        <a class="btn btn-sm btn-dark" href="#" >Rol asignado <span class="badge badge-danger">{{ $value->rol->nombre }}</span></a>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
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