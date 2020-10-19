@extends('adminlte::page')
@section('content_header')
    <h2>
      Meses disponibles para pagar    
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
        <div class="card-body table-responsive p-0">
          <div class="card-body pb-0">
              <div class="row">
                <div class="col-md-12 col-xs-12 text-center">
                  <div class="row d-flex align-items-stretch" style="background-color: #d2d6de;">
                      <div class="col-md-12 col-xs-12"><br></div>
                      @foreach ($values as $value)
                      <div class="col-md-6 col-xs-12">
                          <div class="small-box bg-success">
                          <div class="inner text-center">
                              <h1>{{ $value->nombre }}</h1>
                              <h4 class="badge badge-info">Pagos realizados {{ $value->pagos_catedraticos->where('anio', date('Y'))->count() }}</h4>
                              <br><br>
                              @if ($value->pagos_catedraticos->where('anio', date('Y'))->count() > 0)
                                <a class="btn btn-sm btn-dark" href="{{ route('comprobante.pago_catedratico', $value->id) }}" target="_blank">Imprimir</a> 
                              @else
                                <br>
                              @endif
                          </div>
                            <a href="{{ route('pagoCatedratico.show', $value->id) }}" class="btn bg-navy btn-flat margin small-box-footer">Registrar pagos<i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                      </div>
                      @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
        </div>
      </div>
      
    </div>
  </div>
@endsection