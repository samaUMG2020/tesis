@extends('adminlte::page')
@section('content_header')
    <h2>
      Inscripciones
      <a href="{{ route('inscripcion.create') }}" class="btn btn-info">Inscribir un nuevo alumno en el ciclo {{ date('Y') }}</a>  
      <a href="{{ route('inscripcion.create_siguiente') }}" class="btn btn-info">Inscribir un nuevo alumno en el ciclo {{ date("Y",strtotime(date('Y-m-d'). "+ 1 year")) }}</a>           
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
        <h5><i class="icon fas fa-exclamation-triangle"></i> ¡Advertencia!</h5>
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
            <form action="{{ route('inscripcion.index') }}" method="get" role="search">
              {{ csrf_field() }}
              <div class="input-group input-group-sm" style="width: 450px;">
                <input type="text" name="buscar" class="form-control float-right" value="{{ old('buscar', $buscar) }}" placeholder="Buscar">
  
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
              <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="post small-box {{ $value->activo ? 'bg-success' : 'bg-danger' }}">
                  <br>
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('img/user.png') }}" alt="user image">
                    <br>
                    <br>
                    <span class="username">
                      <h6>{{ $value->alumno }}</h6>
                    </span>
                    <span class="description">{{ "{$value->tipo_pago_alumno} - Q ".number_format($value->monto,2,'.',',') }}</span>
                  </div>
                  <hr>
                  <p class="text-center">{{ $value->grado }}</p>
                  <p>
                    @if ($value->activo)
                      <form action="{{ route('inscripcion.destroy', $value->id) }}" method="post" class="text-center">
                        <a class="btn btn-sm btn-primary" href="{{ route('inscripcion.show', $value->id) }}" >{{ "Pagar mensualidad del año {$value->anio}" }}</a>
                        {{csrf_field()}}
                        <br><br>
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-sm btn-danger" type="submit">{{ "Borrar la inscripción del año {$value->anio}" }}</button>
                      </form>                        
                    @endif
                  </p>
                  <br>
                </div>
                <br>
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