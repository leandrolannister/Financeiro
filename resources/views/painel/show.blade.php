@extends('adminlte::page')

@section('title', 'Painel Show')

@section('content_header')
  <h1>Lançamentos</h1>
@stop

@section('content')
  <div class="box">
    @include('includes.alertas')
    <div class="box-header">
      <form action="{{route('movto.searchForLancamento')}}"
            method="post" class="form form-inline"
            style="margin-bottom: 5px;">
        {!! csrf_field() !!}
        
        <select name="conta_id" class="form-control" 
                style="margin-right: 5px;">
          <option value="">Selecione uma conta</option>      
          @foreach($contas as $key => $c)
            <option value="{{$c->id}}">{{$c->nome}}</option>
          @endforeach  
        </select>       

        <input type="date" name="data" class="form-control"
               style="margin-right: 5px;">       

        <button type="submit" class="btn btn-primary">
        Pesquisar</button>
      </form>
    </div>
  </div>
  <div class="box-body">
    <table class="table table-borderred table-hover table-striped">
      <thead>
        <tr>
          <th>Conta</th>          
          <th>Valor</th>
          <th>Valor Acumulado</th> 
          <th>Data</th> 
        </tr>
      </thead>
      <tbody>
        @forelse($movtos as $m)
         <tr>
          <td>{{mb_strtoupper($m->conta_id)}}</td>          
          <td>{{number_format($m->valor, 2, '.', ',')}}</td>
          <td>
            {{number_format($m->valor_acumulado, 2, '.', '.')}}
          </td>    
          <td>{{$m->data}}</td>      
          <td>
            <form action="{{route('movto.destroy')}}" 
                  method="post">
                   {{csrf_field()}}
              <input type="hidden" name="id" value="{{$m->id}}">
              <button type="submit" 
                       class="btn btn-alert">
                <i class="fas fa-trash"></i> 
              </button>       
             </form>
           </td>
         </tr>
         @empty
           <p>sem Registro</p>
         @endforelse
      </tbody>
    </table>
    @if(isset($dados))    
      {{$movtos->appends($dados)->links()}}
    @else
      {{$movtos->links()}}
    @endif    
  </div>
@stop
