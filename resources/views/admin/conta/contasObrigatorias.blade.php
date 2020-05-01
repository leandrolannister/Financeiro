@extends('adminlte::page')

@section('title', 'Contas Obrigatórias')

@section('content_header')
  <h1>Contas Obrigatórias</h1>  
@stop

@section('content')  
  <div class="box-body">    
    <table class="table table-borderred table-hover">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Tipo</th>
          <th>Valor</th> 
          <th>Data</th>     
        </tr>  
      </thead>
      <tbody>
        @forelse($contaList as $c)
         <tr class="{{$c->valor == 0 ? 'alert alert-danger' :''}}">
          <td>{{mb_strtoupper($c->nome)}}</td>
          <td>{{$c->tipo}}</td>
          <td>{{number_format($c->valor, 2, '.', ',')}}</td>
          <td>{{$helper->formatDate($c->data)}}</td>             
         </tr>
         @empty
           <p>sem Registro</p>
         @endforelse
      </tbody>
    </table> 
    @if(isset($contas))
      {{$contaList->appends($contas)->links()}}
    @else  
      {{$contaList->links()}}
    @endif  
  </div>
@stop	
