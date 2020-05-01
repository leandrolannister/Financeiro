@extends('adminlte::page')

@section('title', 'Painel Consumo')

@section('content_header')
  <h1>Consumo Mensal</h1>
@stop

@section('content')  
  <div class="box-body">
    <table class="table table-borderred table-hover">
      <thead>
        <tr>
          <th>Conta</th>          
          <th>Porcentagem</th>
          <th>Limite</th>
          <th>Gastos</th>
          <th>Saldo</th>
        </tr>
      </thead>
      <tbody>
        @forelse($parametros as $key => $p)
         <tr class="{{$p['gastos'] > $p['limite'] 
                    ? 'alert alert-danger' 
                    : '' }}">
            <td>{{mb_strtoupper($key)}}</td>   
            <td>{{$p['porcentagem']}}</td>  
            <td>{{number_format($p['limite'], 2,'.', ',')}}</td>
            <td>{{number_format($p['gastos'],2,'.',',')}}</td>
            <td>{{number_format(
                $p['limite'] - $p['gastos'], 2,'.',',')}}
            </td>
         </tr>
         @empty
           <p>Sem Registro</p>
         @endforelse
      </tbody>
    </table>       
  </div>
  @include('painel.consumoAnual')  
@stop


