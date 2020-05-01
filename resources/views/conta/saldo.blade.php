@extends('adminlte::page')

@section('title', 'Conta')

@section('content_header')
  <h1>Saldo Mensal</h1>
@stop

@section('content')
  <div class="box">
    @include('includes.alertas')
    <div class="box-header">
      <form action="{{route('contaSaldo.search')}}" 
            method="post" class="form form-inline"
            style="margin-bottom: 5px;">
        {!! csrf_field() !!}
        
        <input type="month" name="data" class="form-control"
               style="margin-right: 5px;">       

        <button type="submit" class="btn btn-primary">
        Pesquisar</button>
      </form>
    </div>
  </div>
  <h3 class="{{$saldo > 0 ? 'alert alert-success' 
                               : 'alert alert-danger'}}">
       Saldo R$: {{number_format($saldo, 2, '.', ',')}}
  </h3>
  <div class="box-body">
    <table class="table table-borderred table-hover table-striped">
      <thead>
        <tr>
          <th>Grupo</th>
          <th>Tipo</th>
          <th>Valor</th>
          <th>Mês</th>
        </tr>
      </thead>
      <tbody>
        @forelse($dados as $key => $d)
         <tr>
          <td>{{$d->grupo}}</td>
          <td>{{$d->tipo}}</td>
          <td>{{number_format($d->total, 2,'.',',')}}</td>
          <td>{{$helper->formatDate($d->data)}}</td>
         </tr>
         @empty
           <p>sem Registro</p>
         @endforelse
      </tbody>
    </table>
  </div>
@stop
