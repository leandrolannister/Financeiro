@extends('adminlte::page')

@section('title', 'Ranking de Contas')

@section('content_header')
  <h1>Contas</h1>  
@stop

@section('content')
  <div class="box">
    @include('includes.alertas')
    <div class="box-header">
      <form action="{{route('painel.ranking')}}" 
            method="post" class="form form-inline"
            style="margin-bottom: 5px;">
        {!! csrf_field() !!}

        <input type="month" name="data" 
               class="form-control"
               style="margin-right: 5px;">      

        <button type="submit" class="btn btn-primary">
        Pesquisar</button>
      </form>      
    </div>
  </div>
  <div class="box-body">    
    <table class="table table-borderred table-hover 
                  table-striped">
      <thead>
        <tr>          
          <th>Nome</th>
          <th>Valor</th>
        </tr>  
      </thead>
      <tbody>
        @forelse($contasList as $key => $c)
         <tr>
          <td>{{mb_strtoupper($c->nome)}}</td>
          <td>{{number_format($c->valor,2,',','.')}}</td>
         </tr>
         @empty
           <p>sem Registro</p>
         @endforelse
      </tbody>
    </table>  
    @if(isset($dados))
       {{$contasList->appends($dados)}}
    @else   
      {{$contasList->links()}}
    @endif   
  </div>  
@stop 
